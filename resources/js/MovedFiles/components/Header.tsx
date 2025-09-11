
import { Icon } from "@iconify/react/dist/iconify.js";
import "./Header.css";
import { useState } from "react";
const Header_Icons = ()=> {

  const [darkMode, setDarkMode] = useState(false);
  const Mode_Change = ({ darkMode, setDarkMode }: { darkMode: boolean; setDarkMode: (mode: boolean) => void }) => {
    return (

      <div className="Icon_buttons">
      
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

        return (
          <div className="Header">
            <Icon icon="flowbite:bars-outline" width="30px" height="30px"  />
            
            <Mode_Change darkMode={darkMode} setDarkMode = {setDarkMode}  />

            
            <Icon icon="material-symbols:login" width="30px" height="30px"  />
          </div>
        );

 
} 


export default Header_Icons;

/* const StatusIndicator = ({ status, battery }) => {
    return (
      <div className="p-2 text-sm text-gray-700 bg-gray-200 flex justify-between">
        <span>Status: {status}</span>
        <span>Battery: {battery}%</span>
      </div>
    ); */