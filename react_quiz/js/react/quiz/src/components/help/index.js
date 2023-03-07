import React from 'react'

const Help = ({ help_text,help_links }) => {

  return (
    <div className="quiz-help" >
      <h3>Need some help?</h3>
      <p dangerouslySetInnerHTML={{ __html: help_text }}/>
      <div className="links">
        <ul>
        { help_links.map((item) => {
          return <li><a href={item.uri}>{item.title}</a></li>
        })
        }
        </ul>
      </div>
    </div>
  )
};

export default Help;