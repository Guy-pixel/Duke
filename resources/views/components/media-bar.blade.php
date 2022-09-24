@if(isset($spotifyUserId))
    <script>
        let playIcon = "/icons/play-fill.svg";
        let pauseIcon = "/icons/pause-fill.svg";
        function changePausePlay() {

            if (document.getElementById("resume-icon").alt == "Pause") {
                document.getElementById("resume-icon").alt = "Play";
                document.getElementById("resume-icon").src = pauseIcon;
                fetch('http://127.0.0.1:8000/api/resume/{{ $spotifyUserId }}');
            } else {
                document.getElementById("resume-icon").alt = "Pause";
                document.getElementById("resume-icon").src = playIcon;
                fetch('http://127.0.0.1:8000/api/pause/{{ $spotifyUserId }}');

            }
        }

        function playerSkip() {
            fetch('http://127.0.0.1:8000/api/next/{{ $spotifyUserId }}');
            document.getElementById("resume-icon").alt = "Play";
            document.getElementById("resume-icon").src = pauseIcon;
        }

        function playerPrevious() {
            fetch('http://127.0.0.1:8000/api/previous/{{ $spotifyUserId }}');
            document.getElementById("resume-icon").alt = "Play";
            document.getElementById("resume-icon").src = pauseIcon;

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
                                                                        src="/icons/play-fill.svg"
                                                                        alt="Play">
            </button>

            <button id="skip-button" onclick="playerSkip()"><img id="next-icon"
                                                                 src="{{ asset('/icons/skip-end-fill.svg') }}"
                                                                 alt="Next">
            </button>

        </div>
    @endif
</div>
