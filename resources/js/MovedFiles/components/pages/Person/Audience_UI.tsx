import  {useState}from "react";
import { useNavigate } from "react-router-dom";


const Audience_UI = () => {
    const [backgroundColor] = useState("bg-gray-600 ");

    const navigate = useNavigate();
    return(

    <div className=  {`p-4 ${backgroundColor} text-white flex flex-col sm:flex-row justify-between items-center`}>
        <h2 className="text-2xl font-bold mb-4">Audience View </h2>
        <button className="p-2 bg-red-500 text-white m-2" onClick={() => navigate("/")}>
      Back to Login
      </button>
        <p>Welcome to the Live Map. Explore the event in real-time.</p>
    </div>
    );

};


export default Audience_UI;
