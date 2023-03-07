import React, { useState } from 'react'
import { IconContext } from "react-icons";
import { MdCheckCircle } from "react-icons/md";
import { MdCancel} from "react-icons/md";

const Responses = ({ quizID,quizNID,questionID,responses,correctAnswer,updateAnswered,answered,score,updateOutcome,updateScore,updateTotalAnswered,errors,updateErrors  }) => {

  const [selectedOption, setSelectedOption] = useState({});



  const updateStats = (result) => {
    const data = {
      "data": {
        "type": "quiz_stat_entity",
        "attributes": {
          "name": quizID,
          "quiz_id" : quizNID,
          "question_rid" : questionID,
          "correct_response": result
        }
      }
    }
    const requestOptions = {
      method: 'POST',
      user: { 'api':'B@f41148be1e90cafcd'},
      headers: {
        'Content-Type': 'application/vnd.api+json',
        'Accept': 'application/vnd.api+json',
        'Authorization': 'Basic YXBpOkJAZjQxMTQ4YmUxZTkwY2FmY2Q='
      },
      body: JSON.stringify(data)
    }
    let url = drupalSettings.custom.base_url
    fetch(url + 'jsonapi/quiz_stat_entity/quiz_stat_entity', requestOptions)
      .then(response => response.json())
  }

  const onOptionClicked = (option) => {

      setSelectedOption(option)
      updateTotalAnswered()
      updateAnswered()
      const a = localStorage.getItem('globalAttempts') ? parseInt(localStorage.getItem('globalAttempts')) : 0
      localStorage.setItem('globalAttempts', a + 1);

      if (option === correctAnswer) {
        updateStats(true)
        updateOutcome(1,option)
        updateScore(score)
        const s = localStorage.getItem('globalScore') ? parseInt(localStorage.getItem('globalScore')) : 0
        localStorage.setItem('globalScore', s + 1);
      } else {
        updateStats(false)
        updateErrors(errors)
        updateOutcome(0,option)
      }
    };
  const isCorrect = option => {
    return option === correctAnswer;
  };

  return (
      responses.map((option, index) => {
        return (
          <button
            key={index}
            onClick={() => { onOptionClicked(option.response) }}
            disabled={ answered }
            className={`quiz-option
                  ${selectedOption === option.response ?
              !isCorrect(option.response) ?
              'wrong' : 'correct' : ''}
            `}
          >
                <span>
                  <IconContext.Provider value={{  className: "quiz-icon" }}>
                  {answered ? (isCorrect(option.response) ? <MdCheckCircle value={{ color: "blue",className: 'react-icons' }} />: <MdCancel />) : ''}
                  {option.response}
                  </IconContext.Provider>
                </span>
          </button>
        );
      })
    );
};

export default Responses;
