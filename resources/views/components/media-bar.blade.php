<?php
use App\Http\Controllers\SpotifySongController;
?>
@if(isset($spotifyUser))
    <script>
        function playerAction(playerAction) {
            fetch('/api/' + playerAction + '/{{ $spotifyUser->getId() }}')
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
    @if(isset($spotifyUser))
        <?php
        $albumInfo = SpotifySongController::getAlbum($spotifyUser);
        ?>
        <div class="currentAlbumContainer">
            <img src="{{ $albumInfo?->images[0]->url ?: "" }}" alt="" class="currentAlbumImage">
            <div class="currentAlbumInfo">
                <div
                    class="currentSongName">{{ $spotifyUser->getCurrentPlaying() ? $spotifyUser->getCurrentPlaying()->item->name : "No Song Playing" }}</div>
                <div class="currentAlbumName">{{ $albumInfo?->name }}</div>
                <div class="currentArtistName">
                    @if(isset($albumInfo))
                        @foreach($albumInfo->artists as $artistInfo)
                            {{$artistInfo->name}}
                            @if(!$loop->last)
                                ,
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="media-player-buttons">
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
