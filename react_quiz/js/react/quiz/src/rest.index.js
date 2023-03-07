import React, { useState, useEffect } from 'react';
import { render } from 'react-dom';
const domContainer = document.querySelector('#quiz-app');
const e = React.createElement;
function MyComponent() {
  const [error, setError] = useState(null);
  const [isLoaded, setIsLoaded] = useState(false);
  const [items, setItems] = useState([]);

  useEffect(() => {
    $jsonrequest = "http://lawhelp.docksal/jsonapi/quiz_entity/quiz_entity/" +
      "1a64d39a-ddee-46cc-9049-6d4d5e7f8680?" +
      "fields[quiz_entity--quiz_entity]=id,description,name,quiz_questions" +
      "&fields[paragraph--quiz_question]=question,responses" +
      "&fields[paragraph--quiz_responses]=response,correct_resp" +
      "&include=quiz_questions.responses";
    fetch($jsonrequest)
      .then(res => res.json())
      .then(
        (result) => {
          setIsLoaded(true);
          setItems(result);
        },
        // Note: it's important to handle errors here
        // instead of a catch() block so that we don't swallow
        // exceptions from actual bugs in components.
        (error) => {
          setIsLoaded(true);
          setError(error);
        }
      )
  }, [])

  if (error) {
    return <div>Error: {error.message}</div>;
  } else if (!isLoaded) {
    return <div>Loading...</div>;
  } else {
    return (
      <>
        <h1>Test your knowledge</h1>
      <ul>
        {items.map(item => (
         <p>boo</p>
        ))}
      </ul>
        </>
    );
  }
}


render(<MyComponent />, document.querySelector('#quiz-app'));

//ReactDOM.hydrate(e(Root, {reactNID: window.drupalSettings.reactNID}, null), domContainer);
//<>Hi there. My QUIZ ID is {drupalSettings.reactQID}, bitch. Now let's go eat some data.</>
