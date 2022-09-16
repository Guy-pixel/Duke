<script>
    function playerPause() {
        fetch('http://127.0.0.1:8000/api/pause');
    }

    function playerResume() {
        fetch('http://127.0.0.1:8000/api/resume')
    }

    function playerSkip() {
        fetch('http://127.0.0.1:8000/api/next')
    }

    function playerPrevious() {
        fetch('http://127.0.0.1:8000/api/previous')
    }
</script>
<div class="media-bar">
    <div class="media-buttons">
        <button id="previous-button" onclick="playerPrevious()"><img id="previous-icon"
                                                                     src="{{ asset('/icons/skip-start-fill.svg') }}"
                                                                     alt="Previous"></button>
        <button id="resume-button" onclick="changePausePlay()"><img id="resume-icon"
                                                                 src="/icons/play-fill.svg" name="pause" alt="Play">
        </button>

        <button id="skip-button" onclick="playerSkip()"><img id="next-icon"
                                                             src="{{ asset('/icons/skip-end-fill.svg') }}" alt="Next">
        </button>

    </div>
</div>
