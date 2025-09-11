// DarkModeContext.tsx
import { createContext, useContext, useState } from "react";

type DarkModeContextType = {
  darkMode: boolean;
  setDarkMode: (mode: boolean) => void;
};

const DarkModeContext = createContext<DarkModeContextType | undefined>(undefined);

export const DarkModeProvider = ({ children }: { children: React.ReactNode }) => {
  const [darkMode, setDarkMode] = useState(false);
  
  return (
    <DarkModeContext.Provider value={{ darkMode, setDarkMode }}>
      <div className={darkMode ? 'dark' : 'light'}>
        {children}
      </div>
    </DarkModeContext.Provider>
  );
};

export const useDarkMode = () => {
  const context = useContext(DarkModeContext);
  if (context === undefined) {
    throw new Error('useDarkMode must be used within a DarkModeProvider');
  }
  return context;
};

export default DarkModeProvider;