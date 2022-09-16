<?php
use App\Models\SpotifyDev;

?>
<?php //$devApp->createAuthorizationLink(); ?>
<div class="nav-bar">
{{$slot}}
    <div class="user-info">
        <div class="user-text">
        @if(Auth::check())
                <a href="/logout">Logout</a>Logged in as {{Auth::user()->username}}
        @else
            <a href='/login'>Login</a>
        @endif
        </div>
        <div class="user-image">
        <img src="{{ asset('/icons/person-circle.svg') }}" alt="User icon">
        </div>
    </div>
</div>
