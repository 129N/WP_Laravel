import { useState } from "react";
import ThemeToggle_second from "../../../components/ThemeToggle";
//import ThemeToggle from "../../../components/ThemeToggle";
import { Icon } from "@iconify/react/dist/iconify.js";
import Fotter from "../../../components/Fotter"
import "./Comp.css";



const Competition_Screen = () => {
        const [darkMode, setDarkMode] = useState(false);

        const Mode_Change = ({ darkMode, setDarkMode }: { darkMode: boolean; setDarkMode: (mode: boolean) => void }) => {
            return (

              <div className="Icon_buttons">
              <Icon icon="heroicons-outline:arrow-left" width="30px" height="30px" />
                <button 
                onClick={() => setDarkMode(!darkMode)}
                className={`mode-toggle ${darkMode ? 'dark' : 'light'}`}
                aria-label={darkMode ? "Switch to light mode" : "Switch to dark mode"}
                
                >
                <Icon icon={darkMode ? "ri:moon-fill" : "ri:moon-line"}  width="30" height="30"/>
                </button>
                
              </div>
            );
          };



    return(
  <div className={`competition-container ${darkMode ? 'bg-gray-900' : 'bg-gray-100'} `}>
            {/* Header */}
            <div  className="header">

              <Mode_Change darkMode={darkMode} setDarkMode = {setDarkMode} />
              <ThemeToggle_second darkMode={darkMode} setDarkMode={setDarkMode} />          
                
            </div>

            {/* Waypoint & Direction */}
            <div className="WP_Arrow">
                <Icon icon="el:arrow-up" width="150" height="150" className={darkMode ? 'text-white' : 'text-black'} />
                <p className={`mt-2 text-lg ${darkMode ? 'text-white' : 'text-black'}`}>Waypoint: 3 | Angle: 45°</p>
            </div>


             {/* Speed & ETA (Lower Right Corner) */}
      <div className={`status-box ${darkMode ? 'bg-gray-800' : 'bg-gray-200'} `}>

        <p className={`text-lg ${darkMode ? 'text-white' : 'text-black'}`}>
          <Icon icon="mdi:speedometer" className="text-yellow-500 mr-2" />
        Speed: 12 km/h
        </p>
        <p className={`text-lg ${darkMode ? 'text-white' : 'text-black'}`}>
          <Icon icon="mdi:clock-outline" className="text-green-400 mr-2" />
        Distance Left: 14 km
        </p>
        <p className={`text-lg ${darkMode ? 'text-white' : 'text-black'}`}>
          <Icon icon="mdi:clock-outline" className="text-green-400 mr-2" />
        ETA: 14 min
        </p>

      </div>


    {/* Emergency & Surrender Buttons */}
    <div className="flex justify-center space-x-4 mb-10">
          <button className="bg-red-600 text-white px-4 py-2 rounded-lg flex items-center shadow-md text-sm">
            <Icon icon="mdi:alert-circle-outline" className="text-xl mr-2" />
            HELP
          </button>
          <button className="bg-gray-500 text-white px-4 py-2 rounded-lg flex items-center shadow-md text-sm">
            <Icon icon="mdi:exit-run" className="text-xl mr-2" />
            Surrender
          </button>
    </div>
        
      <Fotter/>


         
  </div>
    );
}

export default Competition_Screen;
