import React from "react";
import axios from "axios";
import { useNavigate } from "react-router-dom";

export default function Logout() {
  const navigate = useNavigate();
  const logoutfn = async () => {
    try {
      const res = await axios.get(
        "http://localhost:8888/logout",
        { withCredentials: true } // ensure cookies are sent with the request
      ).then((res)=>{
        console.log(res.data.sessionDestroyed)
        if(res.data.sessionDestroyed){
          navigate("/home");
          console.log("Logged out successfully");
          }
      });
      
    } catch (err) {
      console.log("Error during logout:", err);
    }
  };

  return (
    <button
      onClick={() => {
        logoutfn();
      }}
    >
      Logout
    </button>
  );
}
