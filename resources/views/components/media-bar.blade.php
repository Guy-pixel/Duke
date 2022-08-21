<div class="media-bar">
    <div class="media-buttons">
    <button id="pause-button" onclick="playerPause()"><img id="pause-icon" src="{{ asset('/icons/pause-fill.svg') }}" alt="Pause"></button>
    <button id="resume-button" onclick="playerResume()"><img id="resume-icon" src="{{ asset('/icons/play-fill.svg') }}" alt="Play"></button>
    <button id="previous-button" onclick="playerPrevious()"><img id="previous-icon" src="{{ asset('/icons/skip-start-fill.svg') }}" alt="Previous"></button>
    <button id="skip-button" onclick="playerSkip()"><img id="next-icon" src="{{ asset('/icons/skip-end-fill.svg') }}" alt="Next"></button>

    </div>
</div>
