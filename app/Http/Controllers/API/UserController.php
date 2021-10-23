<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\blocked;
use App\Models\follow_requests;
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

    function block($blocked){
        $user = Auth::user();
        $id = $user->id;

        $userBlock = new blocked;
        $userBlock->user_id = $id;
        $userBlock->blocked_user_id = $blocked;
        $userBlock->save();
        return json_encode("done");

    }

    
}


?>