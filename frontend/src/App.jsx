import "./App.css";
import Login from "./screens/Login";
import { GoogleOAuthProvider } from "@react-oauth/google";
import { BrowserRouter, Routes, Route } from "react-router-dom";
import Topics from "./screens/Topics";
import Questions from "./screens/Questions";

function App() {
  const clientId =
    "1086744707768-1mo9tdm3fad31g114u5sk0au2phuqkte.apps.googleusercontent.com";
  return (
    <>
      <GoogleOAuthProvider clientId={clientId}>
        <BrowserRouter>
          <Routes>
            <Route index element={<Login />} />
            <Route path="/home" element={<Login />} />
            <Route path="/topics" element={<Topics />} />
            <Route path="/questions/:topic_name/:id" element={<Questions />} />
          </Routes>
        </BrowserRouter>
      </GoogleOAuthProvider>
    </>
  );
}

export default App;
