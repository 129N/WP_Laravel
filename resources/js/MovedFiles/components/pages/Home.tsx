import React, { useState } from "react";
import { useNavigate } from "react-router-dom";



import ThemeToggle from "../components/ThemeToggle";

import Header_Icons from "../components/Header";

import Login_Select from "../loginPage_Component/Login_Select";





  const Home = () => {

    const [role,setRole] =useState<string | null>(null);
    const [darkMode, setDarkMode] = useState(false);
    const [isLoggedIn, setIsLoggedIn] = useState(false);

    const appBG_Chnager = darkMode ?  "bg-gray-900" : "bg-gray-100";

    const handleLogin = (selectedRole: string) => setRole(selectedRole);



    const handleLoginSuccess = () => {
      setIsLoggedIn(true); // Update login state
    };

    return (

      <div className={`min-h-screen ${appBG_Chnager}`}>
        <ThemeToggle darkMode={darkMode} setDarkMode={setDarkMode} />
        <Header_Icons />

      {/* If no role is selected, show the login page */}
      {/*<LoginPage onLogin={handleLogin} />*/}

      
      
      {!role ? (
        <Login_Select/>
       
      ) : (
        <>
          
          
        </>
      )}



    </div>
    );

      
    };
    
  export default Home;



  /*
{!isLoggedIn ? (
        <Login_Check onLoginSuccess={handleLoginSuccess}/>
      ) : (
        <LoginPage  onLogin={handleLogin}/>
      )}


   
      {!role ? (
        <LoginPage/>
       
      ) : (
        <>
          <Authentication_Real role={role} onBackToLogin={handleBackToLogin} />
          {role === "admin" && <Admin_UI />}
          {role === "participant" && <Participant_UI />}
          {role === "audience" && <Audience_UI />}
        </>
      )}
   */





  /* 
  if(!role){
      return (
      <div  className={`min-h-screen ${appBG_Chnager}`} >
      <ThemeToggle darkMode={darkMode} setDarkMode={setDarkMode} />
      <StatusIndicator status="Online" battery={85} />
      <LoginPage />
      
      </div>
      );
    } 
  */
  /*{role === "admin" && <Admin_UI />}
      {role === "audience" && <Audience_UI />}
      {role === "participant" && <Participant_UI />}
      
      
      else if(role === "admin"){
      return (
        <div className={`min-h-screen ${appBG_Chnager}`}>
         <ThemeToggle darkMode={darkMode} setDarkMode={setDarkMode} />
         <NavigatoinBar role = {role} onBackToLogin = {handleBackToLogin}/>
         <StatusIndicator status="Online" battery={85} />

      
         <Admin_UI/>
        </div>
       );

    }  else if(role ==="participant"){

      return (
        <div className={`min-h-screen ${appBG_Chnager}`}>
      <ThemeToggle darkMode={darkMode} setDarkMode={setDarkMode} />
      <NavigatoinBar role = {role} onBackToLogin = {handleBackToLogin}/>
      <StatusIndicator status="Online" battery={85} />


      <Participant_UI/>
      </div>
      );
    } else if(role ==="audience"){

      return (
        <div className={`min-h-screen ${appBG_Chnager}`}>
      <ThemeToggle darkMode={darkMode} setDarkMode={setDarkMode} />
      <NavigatoinBar role = {role} onBackToLogin = {handleBackToLogin}/>
      <StatusIndicator status="Online" battery={85} />


      <Audience_UI/>
      </div>
      );
    }*/



      {/* Authentication_Real */}
      /*
const Authentication_Real = ({})=> {

  const [backgroundColor, setBackgroundColor] = useState("bg-gray-600 ");
  const navigate = useNavigate();

    
    const handleButtonclisk =  (newColor) => {
      setBackgroundColor(newColor);
    };

    const handleBackButtonClick = () => {
      onBackToLogin(); 
      navigate("/"); // Navigate back to the home route
    };

    return (
    <nav className= {`p-4 ${backgroundColor} text-white flex flex-col sm:flex-row justify-between items-center`}>
    
 
      <div className="mr-4 " >

      <button
          className="mr-4 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
          onClick={handleBackButtonClick}
        >
          Back to Login
        </button>
        {role === "admin" && <button className="mr-4 " onClick={() => handleButtonclisk("bg-green-600")} >Admin Panel </button>}
        {role === "audience" && <button className="mr-4" onClick={() => handleButtonclisk("bg-purple-600")}>Audience Panel</button>}
        {role === "participant" && <button className="mr-4 " onClick={() => handleButtonclisk("bg-blue-600")}>Participant Waypoint View test</button>}
      </div>
    </nav>  
    );
  }
*/