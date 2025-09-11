
import { useNavigate } from "react-router-dom";
import ModeChange from "../components/ModeChange";
import DarkModeProvider, { useDarkMode } from "../components/DarkMode";

import "./LoginPage.css";
const LoginPage = () =>{

    const navigate = useNavigate();

    const { darkMode, setDarkMode } = useDarkMode();

  
   
    return (

     
      <div className={`competition-container ${darkMode ? 'bg-gray-900' : 'bg-gray-100'}`}>
        <ModeChange  darkMode={darkMode} setDarkMode={setDarkMode}/>
        

          <h2 className={`text-2xl font-bold mb-6'  ${darkMode ? 'text-white' : 'text-black'}  `}>Go to Login_Check.tsx</h2>


            <button className="p-2 bg-blue-500 text-white m-2" onClick={() => navigate("/login-check")}>
              Participant
            </button>
            <button className="p-2 bg-green-500 text-white m-2" onClick={() => navigate("/admin")}>
              Event Holder (Admin)
            </button>
            <button className="p-2 bg-purple-500 text-white m-2" onClick={() => navigate("/audience")}>
              Audience
            </button>


        </div>

      
    );

  };

  export default LoginPage;