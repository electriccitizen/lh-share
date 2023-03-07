import React from 'react'

const Results = ({ score, totalQuestions, errors, error_threshold }) => {
  const scoreFactor = 100/totalQuestions
  const totalScore = scoreFactor*score

  const globalScore = localStorage.getItem('globalScore')
  const globalAttempts = localStorage.getItem('globalAttempts')
  const globalFactor = 100/globalAttempts
  const totalGlobalScore = globalFactor*globalScore

  return (
        <div className="quiz-results" >
          <h3>Results</h3>
          <ul>
            <li>You scored {score} out of {totalQuestions} points!</li>
            <li>This means you scored {totalScore.toFixed(0)}% on your quiz</li>
            <li>Your lifetime results are: {globalScore} correct answers!</li>
            <li>You have a lifetime winning percentage of {totalGlobalScore.toFixed(0)}%!</li>
          </ul>
           </div>
    )
};

export default Results;