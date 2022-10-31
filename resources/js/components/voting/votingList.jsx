import React, {useEffect} from 'react';
import * as ReactDOM from 'react-dom/client';

function VotingCard(props) {
    useEffect(()=>{

    })
    return (
        <div className="voting-card" songID={props.song.id}>
            <div className="voting-card-image"></div>
            <div className="voting-card-text">
                <div className="voting-card-header">{props.song.name}</div>
                <div className="voting-card-body">{props.song.album}<br/>
                    {props.song.artist}</div>
                <div className="voting-card-footer">{props.song.requester}</div>
            </div>
            <div className="voting-card-votes">
                <div className="upvote-button" onClick={()=>props.onClick(props.song.id)}>
                    <img src="/icons/play-fill.svg" alt="Upvote"/>
                </div>
                <div className="current-votes">
                    {props.song.votes} Votes
                </div>
                <div onClick={() => {props.onClick(props.song.id)}} className="downvote-button">
                    <img src="/icons/play-fill.svg" alt="Downvote"/>
                </div>
            </div>
        </div>)

}

class VotingList extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            history: [{
                songList0: {
                    song1: {
                        name: "songName1",
                        album: "albumName1",
                        artist: "artistName1",
                        requester: "requesterName1",
                        votes: "5"
                    }, song2: {
                        name: "songName2",
                        album: "albumName2",
                        artist: "artistName2",
                        requester: "requesterName2",
                        votes: "10"
                    }
                }
            }]
        }
    };


    componentDidMount() {

        const history = this.state.history;

        fetch('/api/songlist', {method: 'GET'})
            .then(response => response.json())
            .then((responseData) => {

                this.setState({
                    history: history.push([{
                        ['songList'+this.state.history.length]: responseData
                    }])
                });
                console.log(responseData);
            })
            .catch((error) => console.log(error));
        console.log(this.state);
    }


    handleClick(i) {

    }

    render() {
        return (<div style={{width: "100%"}}>
            {Object.entries(this.state.history[this.state.history.length-1]).map(([songID, songInfo]) => (
                <VotingCard onClick={this.handleClick(songInfo.id)} song={songInfo}/>))}
        </div>);

    }
}


const root = ReactDOM.createRoot(document.getElementById('votinglistroot'));
root.render(<VotingList/>);

