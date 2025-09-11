
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';

import Home from './pages/Home.tsx';
import MapView from './pages/MapView.tsx'
import Settings from './pages/Settings.tsx';
import Participant_UI from "./pages/Person/Participant_UI.tsx";
import Audience_UI from "./pages/Person/Audience_UI.tsx";
import Admin_UI from "./pages/Person/Admin_UI.tsx";
import Competition_UI from "./pages/Person/Competitor_UI/Competition.tsx";
import Login_Check from "./loginPage_Component/Login_Check";
import After_Login from './loginPage_Component/After_login.tsx';
import DarkModeProvider from './components/DarkMode.tsx';

const Approuter = () =>{
return (

    <DarkModeProvider>
        <Router>
            <Routes>
            <Route path="/" element={<Home />} />
            <Route path="/map" element={<MapView />} />
            <Route path="/settings" element={<Settings />} />
            <Route path="/admin" element={<Admin_UI/>} />
            <Route path="/participant" element={<Participant_UI/>} />
            <Route path="/audience" element={<Audience_UI/>} />
            <Route path="/competition" element={<Competition_UI/> }/>
            <Route path="/login-check" element={<Login_Check  />} />
            <Route path="/after-login" element={<After_Login/>} />
            </Routes>

        </Router>

    </DarkModeProvider>
);

};


export default Approuter;