@if(isset($spotifyUserId))
    <script>
        function playerAction(playerAction) {
            fetch('/api/' + playerAction + '/{{ $spotifyUserId }}');
            if (playerAction === 'resume' || playerAction === 'next' || playerAction === 'previous') {
                document.getElementById('pause-button').style.display = "flex";
                document.getElementById('resume-button').style.display = "none";
            } else {
                document.getElementById('pause-button').style.display = "none";
                document.getElementById('resume-button').style.display = "flex";
            }
        }

    </script>
@endif
<div class="media-bar">
    @if(isset($spotifyUserId))
        <div class="media-buttons">
            <button id="previous-button" onclick="playerAction('previous')">
                <img id="previous-icon"
                     src="{{ asset('/icons/skip-start-fill.svg') }}"
                     alt="Previous"></button>
            <button id="resume-button" onclick="playerAction('resume')">
                <img id="resume-icon"
                     src="{{ asset('/icons/play-fill.svg') }}"
                     alt="Play">
            </button>
            <button id="pause-button" onclick="playerAction('pause')">
                <img id="resume-icon"
                     src="{{ asset('/icons/pause-fill.svg') }}"
                     alt="Play">
            </button>

            <button id="skip-button" onclick="playerAction('next')">
                <img id="next-icon"
                     src="{{ asset('/icons/skip-end-fill.svg') }}"
                     alt="Next">
            </button>

        </div>
    @endif
</div>
