function changePausePlay() {
    let playIcon = "/icons/play-fill.svg";
    let pauseIcon = "/icons/pause-fill.svg";
    if(document.getElementById("resume-icon").name == "pause") {
        document.getElementById("resume-icon").name = "play";
        document.getElementById("resume-icon").src = playIcon;
        fetch('http://127.0.0.1:8000/api/resume');
    } else {
        document.getElementById("resume-icon").name = "pause";
        document.getElementById("resume-icon").src = pauseIcon;
        fetch('http://127.0.0.1:8000/api/pause');

    }
}
function playerSkip() {
    fetch('http://127.0.0.1:8000/api/next');
}

function playerPrevious() {
    fetch('http://127.0.0.1:8000/api/previous');
}
