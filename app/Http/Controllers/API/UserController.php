<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\blocked;
use App\Models\comment_has_likes;
use App\Models\comment_has_replies;
use App\Models\comments;
use App\Models\follow_request;
use App\Models\recipe_has_comment;
use App\Models\recipe_has_likes;
use App\Models\recipe_has_tags;
use App\Models\recipes;
use App\Models\reply_has_likes;
use App\Models\tags;
use App\Models\user_followers;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use function Sodium\increment;

class UserController extends Controller {

    function register(Request $request){
        $user = new User;
        $user->username = $request->username;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->bio = $request->bio;
        $user->save();

        return json_encode("Hello");
    }

    function block(Request $block){
        $user = Auth::user();
        $id = $user->id;

        $userBlock = new blocked;
        $userBlock->user_id = $id;
        $userBlock->blocked_user_id = $block->id;
        $userBlock->save();


    }
    function unblock(Request $unblock){

        $user = Auth::user();
        $id = $user->id;

        blocked::where('user_id', $id)
                ->where('blocked_user_id', $unblock->id)
                ->delete();

    }

    function postRecipe(Request $recipe){

        $user = Auth::user();

        $id = $user->id;

        $newRecipe = new recipes;
        $newRecipe->title = $recipe->title;
        $newRecipe->ingredients = $recipe->ingredients;
        $newRecipe->method = $recipe->how_to;
        $newRecipe->serves = $recipe->serves;
        $newRecipe->prep = $recipe->prep;
        $newRecipe->cook = $recipe->cook;
        $newRecipe->media = $recipe->media;
        $newRecipe->nb_of_likes = 0;
        $newRecipe->nb_of_comments = 0;
        $newRecipe->posted_by = $id;
        $newRecipe->save();

    }

    function getRecipes(){

        $getRecipes = recipes::all()->orderBy('created_at', 'DESC')->get()->toArray();
        return json_encode($getRecipes);

    }

    function likeRecipe(Request $request){

        $user = Auth::user();
        $id = $user->id;
        $recipe_id = $request->id;
        $searching = recipe_has_likes::where('user_id', $id)->where('recipe_id', $recipe_id)->get()->toArray();

        if (count($searching) == 0) {

            $newRecipeLike = new recipe_has_likes;
            $newRecipeLike->user_id = $id;
            $newRecipeLike->recipe_id = $recipe_id;
            $newRecipeLike->save();

            recipes::where('id', $recipe_id)->increment('nb_of_likes');

        }

    }

    function addComment(Request $request){

        $user = Auth::user();
        $id = $user->id;
        $recipe_id = $request->id;


        $newComment = new comments;
        $newComment->body = $request->body;
        $newComment->nb_of_likes = 0;
        $newComment->nb_of_replies = 0;
        $newComment->posted_by = $id;
        $newComment->save();

        $comment_id = $newComment->id;

        $newRecipeComment = new recipe_has_comment;
        $newRecipeComment->recipe_id = $recipe_id;
        $newRecipeComment->comment_id = $comment_id;
        $newRecipeComment->save();

        recipes::where('id', $recipe_id)->increment('nb_of_comments');

    }

    function likeComment(Request $request){

        $user = Auth::user();
        $id = $user->id;
        $comment_id = $request->id;

        $searching = comment_has_likes::where('user_id', $id)->where('comment_id', $comment_id)->get()->toArray();

        if (count($searching) == 0) {

            $newCommentLike = new comment_has_likes;
            $newCommentLike->user_id = $id;
            $newCommentLike->comment_id = $comment_id;
            $newCommentLike->save();

            comments::where('id', $comment_id)->increment('nb_of_likes');

        }

    }

    function addReply(Request $request){

        $user = Auth::user();
        $id = $user->id;
        $comment_id = $request->id;

        $newReply = new comment_has_replies;
        $newReply->comment_id = $comment_id;
        $newReply->user_id = $id;
        $newReply->body = $request->body;
        $newReply->save();

        comments::where('id', $comment_id)->increment('nb_of_replies');

    }

    function likeReply(Request $request){

        $user = Auth::user();
        $id = $user->id;
        $reply_id = $request->id;

        $searching = reply_has_likes::where('user_id', $id)->where('reply_id', $reply_id)->get()->toArray();

        if (count($searching) == 0) {

            $newLikeRep = new reply_has_likes;
            $newLikeRep->user_id = $id;
            $newLikeRep->reply_id = $reply_id;
            $newLikeRep->save();
        }
    }

    function followUser(Request $request){

        $user = Auth::user();
        $id = $user->id;
        $follower_id = $request->id;

        $privacy = User::where('id', $follower_id)
            ->value('private');

        $searching = user_followers::where('user_id', $id)
            ->where('follower_id', $follower_id)
            ->get()
            ->toArray();
        $searchingReq = follow_request::where('user_id', $id)
            ->where('follower_id', $follower_id)
            ->get()
            ->toArray();

        if ($privacy == 0 && count($searching)==0){

            $new_follower = new user_followers;
            $new_follower->user_id = $id;
            $new_follower->follower_id = $follower_id;
            $new_follower->save();

        }
        elseif ($privacy == 1 && count($searching)==0 && count($searchingReq) == 0){

            $new_follow_req = new follow_request;
            $new_follow_req->user_id = $id;
            $new_follow_req->follower_id = $follower_id;
            $new_follow_req->status = 0;
            $new_follow_req->save();

        }
    }

    function getRequests(){
        $user = Auth::user();
        $id = $user->id;

        $getFollowRequests = follow_request::where('user_id' , $id)
            ->where('status', '0')
            ->orderBy('created_at', 'DESC')
            ->get()
            ->toArray();
        return json_encode($getFollowRequests);
    }

    function appRequest(Request $request){
        $user = Auth::user();
        $id = $user->id;
        $follower_id = $request->follower_id;

        $searching = user_followers::where('user_id', $id)
            ->where('follower_id', $follower_id)
            ->get()
            ->toArray();

        if (count($searching)==0){

            $new_follower = new user_followers;
            $new_follower->user_id = $id;
            $new_follower->follower_id = $follower_id;
            $new_follower->save();


            follow_request::where('user_id', $id)
                ->where('follower_id', $follower_id)
                ->delete();

        }
    }
    function declineReq(Request $request){
        $user = Auth::user();
        $id = $user->id;
        $follower_id = $request->follower_id;

        follow_request::where('user_id', $id)
            ->where('follower_id', $follower_id)
            ->delete();
    }

    function getUserInfo(Request $request){
        $user_id = $request->id;

        $info = User::where('id', $user_id)
            ->get()
            ->toArray();

        return json_encode($info);
    }

    function deleteRecipe(Request $request){
        $user = Auth::user();
        $id = $user->id;
        $recipe_id = $request->id;

        recipes::where('id', $recipe_id)
            ->where('posted_by', $id)
            ->delete();
    }

    function deleteComment(Request $request){
        $user = Auth::user();
        $id = $user->id;
        $comment_id = $request->id;

        comments::where('id', $comment_id)
            ->where('posted_by', $id)
            ->delete();
        recipe_has_comment::where('$comment_id', $comment_id)
            ->delete();
    }

    function deleteReply(Request $request){
        $user = Auth::user();
        $id = $user->id;
        $reply_id = $request->id;

        comment_has_replies::where('id', $reply_id)
            ->where('user_id', $id)
            ->delete();
    }
//    function createTag(Request $request){
//        $name = $request->name;
//
//        $newTag = new tags;
//        $newTag->name = $name;
//        $newTag->save();
//    }
    function addTag(Request $request){
        $tag_name = $request->name;
        $recipe_id = $request->id;

        $searchForTag = tags::where('name', $tag_name)
            ->get()
            ->toArray();

        if (count($searchForTag) == 0){

            $newTag = new tags;
            $newTag->name = $tag_name;
            $newTag->save();

            $tagRecipe = new recipe_has_tags;
            $tagRecipe->recipe_id = $recipe_id;
            $tagRecipe->tag_id = $newTag->id;
            $tagRecipe->save();
        }
        else{

            $existingTag = $searchForTag[0]->id;

            $tagRecipe = new recipe_has_tags;
            $tagRecipe->recipe_id = $recipe_id;
            $tagRecipe->tag_id = $existingTag;
            $tagRecipe->save();
        }
    }
    function removeLikeRecipe(Request $request){
        $user = Auth::user();
        $id = $user->id;
        $recipe_id = $request->id;

        $likesExists = recipe_has_likes::where('recipe_id', $recipe_id)->where('user_id', $id)->get()->toArray();

        if (count($likesExists) == 1) {
            recipe_has_likes::where('recipe_id', $recipe_id)->where('user_id', $id)->delete();
            recipes::where('id', $recipe_id)->decrement('nb_of_likes');
        }
    }

    function removeLikeComment(Request $request){
        $user = Auth::user();
        $id = $user->id;
        $comment_id = $request->id;

        $likesExists = comment_has_likes::where('comment_id', $comment_id)->where('user_id', $id)->get()->toArray();

        if (count($likesExists) == 1) {
            comment_has_likes::where('comment_id', $comment_id)->where('user_id', $id)->delete();
            comments::where('id', $comment_id)->decrement('nb_of_likes');
        }
    }

    function removeLikeReply(Request $request){
        $user = Auth::user();
        $id = $user->id;
        $reply_id = $request->id;

        $likesExists = reply_has_likes::where('reply_id', $reply_id)->where('user_id', $id)->get()->toArray();

        if (count($likesExists) == 1) {
            reply_has_likes::where('reply_id', $reply_id)->where('user_id', $id)->delete();
        }
    }

    function getTopRecipes(){

        $getRecipes = recipes::all()->orderBy('nb_of_likes', 'DESC')->limit(6)->get()->toArray();

        return json_encode($getRecipes);
    }
    
//    function getTopUsers(){
//
//        $topUsers = user_followers::count()
//
//        $getUsers = User::all()->orderBy('nb_of_likes', 'DESC')->limit(6)->get()->toArray();
//
//        return json_encode($getRecipes);
//    }

}


?>