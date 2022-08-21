<div class="nav-bar">
{{$slot}}
    <div class="user-info">
        @if(isset($username))
            Logged in as {{$username}}
        @else
            Login
        @endif
    </div>
</div>
