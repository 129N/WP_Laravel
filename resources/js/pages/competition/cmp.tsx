import { Head } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import Icon from 'react-native-iconify';
export default function CMP(){
    
    return(
        <AppLayout>
            <Head title="Competition" />
            <div className="p-10 text-3xl font-bold text-blue-600">
                ✅ Participant Dashboard Loaded
            </div>

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
  </div>
        </AppLayout>
    );
}