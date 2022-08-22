<div class="nav-bar">
{{$slot}}
    <div class="user-info">
        <div class="user-text">
        @if(isset($user))
            Logged in as {{$user}}
        @else
            Login
        @endif
        </div>
        <div class="user-image">
        <img src="{{ asset('/icons/person-circle.svg') }}" alt="User icon">
        </div>
    </div>
</div>
