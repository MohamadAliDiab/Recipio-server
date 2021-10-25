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

    
}


?>