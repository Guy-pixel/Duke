<div class="nav-bar">
{{$slot}}
    <div class="user-info">
        @if(isset($user))
            Logged in as {{$user}}
        @else
            Login
        @endif

    </div>
</div>
