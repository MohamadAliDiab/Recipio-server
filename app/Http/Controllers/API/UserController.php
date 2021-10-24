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
        $newRecipe->posted_by = $id;

    }

    function getRecipes(){

        $getRecipes = recipes::all()->orderBy('created_at', 'DESC')->get()->toArray();
        return json_encode($getRecipes);

    }

    
}


?>