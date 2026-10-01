<?php 
namespace App\Http\Middleware; 
use Closure; 
use Illuminate\Http\Request; 
use Auth; 
 
class Admin { 
    public function handle(Request $request, Closure $next){ 
        if (Auth::check()){ 
         if(Auth::user()->role == 'admin'){ 
          return $next($request); 
         } else { 
          abort(403); 
         } 
        } else { 
         return redirect()->route('login'); 
        } 
 
    } 
} 