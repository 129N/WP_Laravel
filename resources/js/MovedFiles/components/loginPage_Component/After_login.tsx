
import { useNavigate } from "react-router-dom";

import Header_Icons from "../components/Header";
import ThemeToggle from "../components/ThemeToggle";
const After_Login = () =>{

    const navigate = useNavigate();

   
    return (

     
        <div className="min-h-screen bg-purple-100">
  
            <Header_Icons/>

          <h2 className="text-2xl font-bold mb-6">Here is the Logined Page</h2>
            <button className="p-2 bg-blue-500 text-white m-2" onClick={() => navigate("/participant")}>
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

  export default After_Login;