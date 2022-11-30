<?php

namespace App\Http\Middleware;
use Closure;
use App\Models\SpotifyDev;

class SpotifyConnect
{
    function handle($request, Closure $next)
    {
        $devApp = new SpotifyDev(env('SPOTIFY_CLIENT_ID'), env('SPOTIFY_CLIENT_SECRET'));
        $token = $devApp->getAccessToken();
        session(['devToken'=>$token]);
        return redirect($devApp->createAuthorizationLink());
    }
}
