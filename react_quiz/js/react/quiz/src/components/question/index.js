import React, { useState } from "react";
import Responses from '../../components/responses'
import  Explanation from '../explanation'
import Help from '../help'
import TagManager from "react-gtm-module";

const Question = ({ quizID,quizNID,questionID,index,question, totalAnswered, totalQuestions, responses, correct_explanation,score,updateScore,errors,updateErrors, updateTotalAnswered,error_threshold,help_text,help_links }) => {
  const [answered, setAnswered] = useState(false);
  const [outcome, setOutcome] = useState('So sorry');

  const updateAnswered = () => {
    setAnswered(true)
  }

  const correctResponses =  ["Nice job!", "Correct!", "Good answer", "Good job"];
  const success = correctResponses[Math.floor(Math.random() * correctResponses.length)];

  const errorResponses =  ["Keep trying!!", "Wrong", "Incorrect", "Whoops", "So close!"];
  const failure = errorResponses[Math.floor(Math.random() * errorResponses.length)];

  const quizSID = window.drupalSettings.quiz.sid;

  const updateOutcome = (status,response) => {
    status === 1 ?
    setOutcome(success)
      : setOutcome(failure)

    TagManager.dataLayer({
      dataLayer: {
        event: 'pageview',
        category:  quizID,
        action: question.replace(/(<([^>]+)>)/gi, ""),
        label: quizSID,
        value: status
      },
      dataLayerName: 'PageDataLayer',
    })

  }

  let correctAnswer = ''
  responses.map(item => {
   item.correct_resp===true ?
    correctAnswer = item.response : 'none'
  })

  return (
    <div className="quiz-question">
      <span className="quiz-question-number">{index + 1}.</span>
      <div className="quiz-question-text" dangerouslySetInnerHTML={{ __html:  question }} />
      <Responses
        responses={responses}
        correctAnswer={correctAnswer}
        answered={answered}
        score={score}
        updateAnswered={updateAnswered}
        updateScore={updateScore}
        errors={errors}
        updateErrors={updateErrors}
        updateTotalAnswered={updateTotalAnswered}
        updateOutcome={updateOutcome}
        quizID={quizID}
        quizNID={quizNID}
        questionID={questionID}
      />
      <Explanation
        answered={answered}
        correct_explanation={correct_explanation}
        errors={errors}
        error_threshold={error_threshold}
        help_text={help_text}
        help_links={help_links}
        outcome={outcome}
        />
     { (errors === error_threshold) && (index+1 === totalAnswered) && (totalQuestions !== totalAnswered) &&
      <Help
        errors={errors}
        error_threshold={error_threshold}
        help_text={help_text}
        help_links={help_links}
      />
      }
    </div>
  );
};

export default Question;
