import React from 'react'

const Explanation = ({ outcome,answered,correct_explanation }) => {
  return ( answered ?
      <div className="quiz-explanation">
        <h3>{outcome}</h3>
        <div dangerouslySetInnerHTML={{ __html:  correct_explanation }} />
      </div>
      : ''
  )
};

export default Explanation;