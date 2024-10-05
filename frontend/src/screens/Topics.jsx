import React, { useEffect, useState } from "react";
import { Link, useNavigate } from "react-router-dom";
import axios from "axios";
import Logout from "../components/logout";

export default function Topics() {
  const [topicsData, setTopicsData] = useState([]);
  const [loading, setLoading] = useState(true); // Track loading state
  const [useremail, setUserEmail] = useState("");
  const navigate = useNavigate();

  useEffect(() => {
    axios
      .get("http://localhost:8888/session", { withCredentials: true })
      .then((res) => {
        console.log('this is front data '+ res.data);
        console.log('this new',JSON.stringify(res.data, 2))
        console.log(res.data.loggedIn)

        if (res.data.loggedIn) {
          setUserEmail(res.data.email);
          getTopics(); // Fetch topics after session validation
        } else {
        //   // If session is invalid, navigate to login
          navigate("/home");
        }
      })
      .catch((err) => {
        console.log("Error checking session", err);
        navigate("/home");
      });
  }, [navigate]);

  const getTopics = () => {
    axios
      .get("http://localhost:8888/topics")
      .then((res) => {
        console.log(res.data);
        // console.log('this new',JSON.stringify(res.data, 2))
        setTopicsData(res.data.topics);
        console.log('topicsdata' , res.data.topics)
        setLoading(false); // Stop loading once topics are fetched
      })
      .catch((err) => {
        console.log("Error fetching topics", err);
        setLoading(false); // Stop loading if there is an error
      });
  };

  return (
    <div>
      {/* Display user email if session is valid */}
      {useremail ? <p>Welcome, {useremail}</p> : null}

      {/* Display topics or loading status */}
      {loading ? (
        <p>Loading topics...</p>
      ) : topicsData.length > 0 ? (
        <div>
          {topicsData.map((dat) => (
            <p key={dat.id}>
              <Link to={`/questions/${dat.topic_name}/${dat.id}`}>
                {dat.topic_name}
              </Link>
            </p>
          ))}
        </div>
      ) : (
        <p>No topics available</p>
      )}

      {/* Logout component */}
      <Logout />
    </div>
  );
}
