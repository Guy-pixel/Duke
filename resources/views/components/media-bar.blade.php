@if(isset($spotifyUserId))
    <script>
        function playerAction(playerAction){
            fetch('/api/' + playerAction + '/{{ $spotifyUserId }}');
            if(playerAction == 'play' || playerAction == 'next' || playerAction == 'previous'){
                document.getElementById('pause-button').show();
                document.getElementById('play-button').hide();
            } else {
                document.getElementById('pause-button').hide();
                document.getElementById('play-button').show();
            }
        }

    </script>
@endif
<div class="media-bar">
    @if(isset($spotifyUserId))
        <div class="media-buttons">
            <button id="previous-button" onclick="playerAction('previous')"><img id="previous-icon"
                                                                         src="{{ asset('/icons/skip-start-fill.svg') }}"
                                                                         alt="Previous"></button>
            <button id="resume-button" onclick="changePausePlay()"><img id="resume-icon"
                                                                        src="/icons/play-fill.svg"
                                                                        alt="Play">
            </button>
            <button id="pause-button" onclick="changePausePlay()"><img id="resume-icon"
                                                                        src="/icons/pause-fill.svg"
                                                                        alt="Play">
            </button>

            <button id="skip-button" onclick="playerSkip()"><img id="next-icon"
                                                                 src="{{ asset('/icons/skip-end-fill.svg') }}"
                                                                 alt="Next">
            </button>

        </div>
    @endif
</div>
