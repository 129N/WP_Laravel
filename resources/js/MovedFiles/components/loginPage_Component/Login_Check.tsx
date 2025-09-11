
  import { useState } from "react";
  import React from "react";
import { useNavigate } from "react-router-dom";
  
  const Login_Check = () => {

    const navigate = useNavigate();
    const [Username, SetUsername] = useState("");
    const [Password, SetPassword] =useState("");

    const handleSubmit = (e: React.FormEvent) => {
      e.preventDefault(); // Prevent the default form submission behavior
      
      if(Username === "Username" && Password === "Password"){
        navigate("/after-login");

      } else {
        alert("Invalid username or password");
      }
    };
  
    return (
      <form onSubmit={handleSubmit} className="flex flex-col gap-4 p-4">
        <div>
            <h1 className="text-lg sm:text-xl font-bold mb-2 sm:mb-0">Go to the After_login.tsx </h1>
          <br />
          <p>Username</p> 
          <input
          type="text"
          value={Username}
          onChange={(e) => SetUsername(e.target.value)}
          placeholder="Username"
          className="p-2 border border-gray-300 rounded"
          />
          <br />
          <p>Password</p>

          <input
          type="text"
          value={Password}
          onChange={(e) => SetPassword(e.target.value)}
          placeholder="Password"
          className="p-2 border border-gray-300 rounded"
          />

          <br />

          <button
          type="submit"
          className="p-2 bg-blue-500 text-white rounded hover:bg-blue-600"

          >
          Submit
          </button>

        </div>
      </form>
    );
  };


  export default Login_Check;