import React, {useEffect} from 'react';
import * as ReactDOM from 'react-dom/client';

function VotingCard(props) {
    useEffect(() => {

    })
    return (
        <div className="voting-card" value={props.song.id}>
            <div className="voting-card-image"></div>
            <div className="voting-card-text">
                <div className="voting-card-header">{props.song.name}</div>
                <div className="voting-card-body">{props.song.album}<br/>
                    {props.song.artist}</div>
                <div className="voting-card-footer">{props.song.requester}</div>
            </div>
            <div className="voting-card-votes">
                <div onClick={this.props.handleVoteClick(1, props.song.id)} className="upvote-button">
                    <img src="/icons/play-fill.svg" alt="Upvote"/>
                </div>
                <div className="current-votes">
                    {props.song.votes} Votes
                </div>
                <div onClick={this.props.handleVoteClick(-1, props.song.id)} className="downvote-button">
                    <img src="/icons/play-fill.svg" alt="Downvote"/>
                </div>
            </div>
        </div>)

}

class VotingList extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            history: [
                [
                    {
                        name: "songName1",
                        album: "albumName1",
                        artist: "artistName1",
                        requester: "requesterName1",
                        votes: "5"
                    },
                    {
                        name: "songName2",
                        album: "albumName2",
                        artist: "artistName2",
                        requester: "requesterName2",
                        votes: "10"
                    }
                ]
            ]
        }
    };


    componentDidMount() {
        this.interval = setInterval(() => {
            const oldHistory = this.state.history;
            fetch('/api/songlist', {method: 'GET'})
                .then(response => response.json())
                .then((responseData) => {
                    if (JSON.stringify(responseData) != JSON.stringify(this.state.history[this.state.history.length - 1])) {
                        this.setState({
                            history: oldHistory.concat([
                                responseData
                            ])
                        });
                    }
                })
                .catch((error) => console.log(error));
        }, 1000)
    }
    componentWillUnmount() {
        clearInterval(this.interval);
    }


    handleVoteClick(diff, id) {
        
    }

    render() {
        return (<div style={{width: "100%"}}>
            {Object.entries(this.state.history[this.state.history.length - 1]).map(([songID, songInfo]) => (
                <VotingCard song={songInfo}/>))}
        </div>);

    }
}


const root = ReactDOM.createRoot(document.getElementById('votinglistroot'));
root.render(<VotingList/>);

