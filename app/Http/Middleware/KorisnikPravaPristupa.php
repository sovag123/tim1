<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KorisnikPravaPristupa
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if($user->tipkorisnika->id == 1){
            return $next($request);
        }else{
            Auth::logout();
            return redirect()->route('login')->with('pravaPristupaError' ,  'Nemate prava pristupa.');
        }

    }
}
