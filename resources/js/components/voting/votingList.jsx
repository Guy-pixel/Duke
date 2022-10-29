import React from 'react';
import * as ReactDOM from 'react-dom/client';

class VotingCard extends React.Component {
    render() {
        return (
            <div className="voting-card">
                <div className="voting-card-image"></div>
                <div className="voting-card-body">
                    <div>{this.props.name}</div>
                    <div>{this.props.album}</div>
                    <div>{this.props.artist}</div>
                </div>
                <div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        )
    }

}
class VotingList extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            history: [{
                songList: {
                    song1: {
                        name: "songName",
                        album: "albumName",
                        artist: "artistName",
                        requester: "requesterName",
                    },
                    song2: {
                        name: "songName",
                        album: "albumName",
                        artist: "artistName",
                        requester: "requesterName",
                    }
                }
            }]
        }
    };

    handleClick(i) {

    }

    render() {
        const songList = this.state.history[0].songList;
        return (

            <div>
                There should be a voting card here:
                {
                    songList.map(()=>)
                }

            </div>
        );
    }
}


const root = ReactDOM.createRoot(document.getElementById('votinglistroot'));
root.render(<VotingList />);

