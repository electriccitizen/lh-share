import React from "react";

const Header = ({ name, description }) => {
  return (
    <div className="quiz-header">
      { name ?
        <h3>{name}</h3> : ''
      }
      { description ?
        <div dangerouslySetInnerHTML={{ __html:  description }} /> : ''
      }
    </div>
  );
};

export default Header;