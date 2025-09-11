

const ThemeToggle = ({ darkMode, setDarkMode }: { darkMode: boolean; setDarkMode: (mode: boolean) => void }) => {
  return (
    <button className="p-2 bg-gray-800 text-white" onClick={() => setDarkMode(!darkMode)}>
      {darkMode ? "Light Mode" : "Dark Mode"}
    </button>
  );
};
const ThemeToggle_second = ({ darkMode, setDarkMode }: { darkMode: boolean; setDarkMode: (mode: boolean) => void }) => {
    return (
      <button className="p-2 bg-white text-black border border-gray-300" onClick={() => setDarkMode(!darkMode)}>
        {darkMode ? "Light Mode" : "Dark Mode"}
      </button>
    );
  };


export default ThemeToggle;
