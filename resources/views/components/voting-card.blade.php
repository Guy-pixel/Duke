<div class="voting-card">
    <div class="voting-card-image">
        <img src="" alt="">
    </div>
    <div class="voting-card-text">
        <div class="voting-card-header">
            {{$song->getName()}}
        </div>
        <div class="voting-card-body">
            {{$song->getAlbum()}}
        </div>
        <div class="voting-card-footer">
            {{$song->getArtist()}}
        </div>
    </div>
    <div class="voting-card-votes">
        <div class="upvote-button">
            <img src="{{ asset('/icons/play-fill.svg') }}" alt="Upvote">
        </div>
        <div class="current-votes">
            20 Votes
        </div>
        <div class="downvote-button">
            <img src="{{ asset('/icons/play-fill.svg') }}" alt="Downvote">
        </div>
    </div>
</div>
