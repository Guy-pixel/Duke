@if(isset($spotifyUserId))
    <script>
        function changePausePlay() {
            let playIcon = "/icons/play-fill.svg";
            let pauseIcon = "/icons/pause-fill.svg";
            if (document.getElementById("resume-icon").name == "pause") {
                document.getElementById("resume-icon").name = "play";
                document.getElementById("resume-icon").src = playIcon;
                fetch('http://127.0.0.1:8000/api/resume/{{ $spotifyUserId }}');
            } else {
                document.getElementById("resume-icon").name = "pause";
                document.getElementById("resume-icon").src = pauseIcon;
                fetch('http://127.0.0.1:8000/api/pause/{{ $spotifyUserId }}');

            }
        }

        function playerSkip() {
            fetch('http://127.0.0.1:8000/api/next/{{ $spotifyUserId }}');
        }

        function playerPrevious() {
            fetch('http://127.0.0.1:8000/api/previous/{{ $spotifyUserId }}');
        }
    </script>
@endif
<div class="media-bar">
    @if(isset($spotifyUserId))
        <div class="media-buttons">
            <button id="previous-button" onclick="playerPrevious()"><img id="previous-icon"
                                                                         src="{{ asset('/icons/skip-start-fill.svg') }}"
                                                                         alt="Previous"></button>
            <button id="resume-button" onclick="changePausePlay()"><img id="resume-icon"
                                                                        src="/icons/play-fill.svg" name="pause"
                                                                        alt="Play">
            </button>

            <button id="skip-button" onclick="playerSkip()"><img id="next-icon"
                                                                 src="{{ asset('/icons/skip-end-fill.svg') }}"
                                                                 alt="Next">
            </button>

        </div>
    @endif
</div>
