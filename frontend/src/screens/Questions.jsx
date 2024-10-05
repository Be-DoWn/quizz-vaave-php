import React, { useEffect, useState } from "react";
import { useNavigate, useParams } from "react-router-dom";
import axios from "axios";

export default function Questions() {
  const [user, setUser] = useState("");
  const [questions, setQuestions] = useState([]);
  const [loading, setLoading] = useState(true);
  const [currentQuestion, setCurrentQuestion] = useState(0);
  const [score, setScore] = useState(0);
  const [quizCompleted, setQuizCompleted] = useState(false);
  const [userAnswers, setUserAnswers] = useState([]); // Store user's selected answers
  const navigate = useNavigate();
  const { topic_name, id } = useParams();
  console.log(id);

  axios.defaults.withCredentials = true;

  useEffect(() => {
    // check session
    axios
      .get("http://localhost:8888/session")
      .then((res) => {
        if (res.data.loggedIn) {
          setUser(res.data.email);
          fetchQuestions(topic_name);
        } else {
          navigate("/home");
        }
      })
      .catch((err) => {
        console.log(err);
        navigate("/home");
      });
  }, [navigate, topic_name]);

  const fetchQuestions = (topic) => {
    // Correct the axios get request by passing topic in params
    axios
      .get("http://localhost:8888/questions", { params: { topic } })
      .then((res) => {
        console.log(res.data.questions);
        const structuredQuestions = structureQuestions(res.data.questions);
        setQuestions(structuredQuestions);
        // console.log(questions);
        setLoading(false);
      })
      .catch((err) => {
        console.log('not topic',err);
        setLoading(false);
      });
  };

  const structureQuestions = (data) => {
    const structuredData = [];
    data.forEach((item) => {
      const existingQuestion = structuredData.find(
        (q) => q.question_text === item.question_text
      );
      if (!existingQuestion) {
        structuredData.push({
          question_text: item.question_text,
          level_id: item.level_id,
          question_id: item.question_id, // Add question ID for the backend
          options: [
            {
              option_text: item.option_text,
              is_correct: item.is_correct,
              option_id: item.option_id, // Add option ID for the backend
            },
          ],
        });
      } else {
        existingQuestion.options.push({
          option_text: item.option_text,
          is_correct: item.is_correct,
          option_id: item.option_id, // Add option ID for the backend
        });
      }
    });
    return structuredData;
  };

  const checkAnswer = (selectedOption, option_id, question_id, level_id) => {
    const currentQ = questions[currentQuestion];
    const correctOption = currentQ.options.find((opt) => opt.is_correct);
    console.log(correctOption)
    // Add user's response
    const updatedAnswers = [
      ...userAnswers,
      {
        level_id: level_id,
        question_id: question_id, // Store question ID
        selected_option_id: option_id, // Store selected option ID
        is_correct: selectedOption === correctOption.option_text,
      },
    ];
    setUserAnswers(updatedAnswers); // Update user answers state

    if (selectedOption === correctOption.option_text) {
      setScore(score + 1); // Increment score if the answer is correct
    }

    if (currentQuestion < questions.length - 1) {
      // Move to the next question if not the last question
      setCurrentQuestion(currentQuestion + 1);
    } else {
      // If it's the last question, mark the quiz as completed
      setQuizCompleted(true);
      const userData = {
        user: user,
        score: score + (selectedOption === correctOption.option_text ? 1 : 0), //Missing last question response so adding once again
        responses: updatedAnswers, // Include all user responses
      };
      console.log(userData);
      submittingScore(userData); // Submit user score and responses
    }
  };

  const submittingScore = (userData) => {
    axios
      .post("http://localhost:8888/userdata", {
        ...userData,
        topic_id: id, // Pass topic_id along with user data
      })
      .then((res) => {
        console.log("Response from backend: ", res.data);
      })
      .catch((err) => {
        if (err.response) {
          console.log("Error from backend: ", err.response.data);
        } else {
          console.log("Network or other error: ", err.message);
        }
      });
  };

  return (
    <div>
      {loading ? (
        <p>Loading questions...</p>
      ) : (
        <div>
          {!quizCompleted ? (
            <div>
              <h2>Questions for {topic_name}</h2>
              <div>
                <h3>
                  {currentQuestion + 1}.{" "}
                  {questions[currentQuestion].question_text}
                </h3>
                {questions[currentQuestion].options.map((opt, index) => {
                  return (
                    <button
                      key={index}
                      onClick={() =>
                        checkAnswer(
                          opt.option_text,
                          opt.option_id,
                          questions[currentQuestion].question_id,
                          questions[currentQuestion].level_id
                        )
                      }
                    >
                      {opt.option_text}
                    </button>
                  );
                })}
              </div>
            </div>
          ) : (
            <div>
              <p>Score: {score}</p>
              <button
                onClick={() => {
                  navigate("/topics");
                }}
              >
                Go to topics
              </button>
            </div>
          )}
        </div>
      )}
    </div>
  );
}
