<?php

namespace App\Http\Middleware\Auth;

use Closure;
use Auth;

class Authenticate {
	
	public function handle($request, Closure $next, $guard = null){
		
		if(!Auth::user()){
			if($request->ajax() || $request->wantsJson()){
				return response("Unauthorized", 401);
			}else{
				return redirect()->route("index");
			}
		}
		
		return $next($request);
		
	}
}



