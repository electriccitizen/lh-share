import React from "react";
import YouTube from 'react-youtube';
const opts = {
  height: '390',
  width: '640',
  wmode: 'transparent',
  playerVars: {
    // https://developers.google.com/youtube/player_parameters
    autoplay: 0,
    wmode: 'transparent',
  },
};

const Video = ({ video }) => {
  return (
    video ?
      <div className="quiz-video">
        <p>Watch this short video and then try to answer the questions below!</p>
        <div className="quiz-responsive-video">
          <YouTube videoId={video} opts={opts}  />
        </div>
      </div>
      : <div className="quiz-video"><p>Are you ready? Try to answer the questions below!</p></div>
  );
};

export default Video;