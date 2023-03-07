import React, { useState, useEffect } from 'react';
import { render } from 'react-dom';
import './App.css';
import Header from './components/header'
import Video from './components/video'
import Question from './components/question'
import Results from './components/results'
import Help from './components/help'
import TagManager from 'react-gtm-module'

const tagManagerArgs = {
  gtmId: 'GTM-WCDSMSS',
  dataLayerName: 'PageDataLayer'
}

TagManager.initialize(tagManagerArgs)

function Quiz() {

  const [error, setError] = useState(null);
  const [isLoaded, setIsLoaded] = useState(false);
  const [items, setItems] = useState([]);

  const [totalQuestions, setTotalQuestions] = useState(0);
  const [totalAnswered, setTotalAnswered] = useState(0);

  const [score, setScore] = useState(0);
  const [errors, setErrors] = useState(0);

  const quizID = window.drupalSettings.quizID;
  const quizNID = window.drupalSettings.quiz.nid;

  const baseURL = drupalSettings.custom.base_url

  const data = baseURL + "jsonapi/node/quiz/" +
    quizID +
    "?fields[node--quiz]=title,quiz_description,quiz_questions,quiz_video,error_threshold,help_text,help_links" +
    "&fields[quiz_video]=video" +
    "&fields[paragraph--quiz_question]=target_id,id,question,responses,correct_explanation" +
    "&fields[paragraph--quiz_responses]=response,correct_resp" +
    "&include=quiz_questions.responses,quiz_video&jsonapi_include=1"

    //const data2 = "http://lawhelp.docksal/jsonapi/node/quiz/27190a6d-2189-4a59-9549-6901f8cc8b4c?fields[node--quiz]=title,quiz_description,quiz_questions,quiz_video,error_threshold,help_text,help_links&fields[quiz_video]=video&fields[paragraph--quiz_question]=target_id,id,question,responses,correct_explanation&fields[paragraph--quiz_responses]=response,correct_resp&include=quiz_questions.responses,quiz_video&jsonapi_include=1"

  const updateScore = (score) => {
    setScore(score + 1)
  }

  const updateErrors = () => {
    setErrors(errors + 1)
  }

  const updateTotalAnswered = () => {
    setTotalAnswered (totalAnswered + 1);
  }

  useEffect(() => {
    fetch(data)
      .then(res => res.json())
      .then(
        (result) => {
          setIsLoaded(true);
          setItems(result);
          setTotalQuestions(result.data.quiz_questions.length)
          },
        (error) => {
          setIsLoaded(true);
          setError(error);
        }
      )
  }, [])

  const quiznode = Object.entries(items)
  const quiz = quiznode[1]

  if (error) {
    return <div>Error: {error.message}</div>;
  } else if (!isLoaded) {
    return <div>Loading...</div>;
  } else {

    let name
    let description
    let questions
    let video
    let error_threshold
    let help_text
    let help_links

    if (quiz && quiz.length) {
       name = quiz[1].title
       description = quiz[1].quiz_description ? quiz[1].quiz_description : ''
       questions = quiz[1].quiz_questions
       video = quiz[1].quiz_video.video
       error_threshold = parseInt(quiz[1].error_threshold)
       help_text=quiz[1].help_text ? quiz[1].help_text.processed : ''
       help_links=quiz[1].help_links
    }

    if (video) {
      if (video.indexOf('=') != -1) {
        video = video.split("=")[1]
      } else {
        const lastslashindex = video.lastIndexOf('/');
        video = video.substring(lastslashindex + 1)
      }
    }
     return (
       <div className="quiz-wrapper">
        <Header
          name={name}
          description={description}
          video={video}
        />
        <Video video={video} />
        <div className="quiz-inner-wrapper">
        <div className="quiz-questions">
        { questions ?
         questions.map((item,index)=> {
           return (
             <Question
                 question={item.question.processed}
                 index={index}
                 responses={item.responses}
                 correct_explanation={item.correct_explanation.processed}
                 score={score}
                 errors={errors}
                 updateScore={updateScore}
                 updateErrors={updateErrors}
                 updateTotalAnswered={updateTotalAnswered}
                 error_threshold={error_threshold}
                 help_text={help_text}
                 help_links={help_links}
                 totalAnswered={totalAnswered}
                 totalQuestions={totalQuestions}
                 quizID={name}
                 quizNID={quizNID}
                 questionID={item.meta.target_revision_id}
               />
           )
         })
          : 'No questions found for this quiz!'
        }
        </div>
          { error_threshold != 0 && (errors >= error_threshold) && (totalAnswered === totalQuestions) ?
            <Help
              errors={errors}
              error_threshold={error_threshold}
              help_text={help_text}
              help_links={help_links}
            />
            : "" }

          { totalAnswered === totalQuestions ?
            <Results
              score={score}
              errors={errors}
              totalQuestions={totalQuestions}
              error_threshold={error_threshold}
              help_text={help_text}
              help_links={help_links}
            />
            : ''}

          {totalAnswered === totalQuestions &&
          <div className="quiz-more"><div>Want to test your knowledge on other areas
            of the law? See <a href="/form/fact-sheet-order-form">more of our fact sheets</a> here!</div><button className="quiz-retake" onClick={() => window.location.reload(false)}>Retake the Quiz?</button></div>
          }
        </div>
        <div className="quiz-privacy">
          <p>LawHelpMN does not collect any personal information when you take this quiz. For more information, see our <a href="/privacy-policy">privacy policy</a>.</p>
        </div>
       </div>
     );
  }
}
render(<Quiz />, document.querySelector('#quiz-app'));


