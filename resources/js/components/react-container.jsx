import React from 'react';
import ReactDOM from 'react-dom';

export default function reactContainer(){
         return (
             <div id="votinglistroot">

             </div>
         )
}


if (document.getElementById('react-container')) {
    ReactDOM.render(<reactContainer />, document.getElementById('react-container'));
}
