
//import reactLogo from './assets/react.svg'
//import viteLogo from '/vite.svg'
import './App.css'
import Approuter from './Router'
//import Fotter from './components/Fotter.tsx';

function App() {
  //const [count, setCount] = useState(0)

  return (
    <>

      <h1>Test test test</h1>

      <h1 className="text-lg sm:text-xl font-bold mb-2 sm:mb-0">Route Tracker</h1>


      <Approuter/>
 
      {/*<Fotter/>*/}
     
    </>
  )
}


export default App


/* 
    
      <div>
        <a href="https://vite.dev" target="_blank">
          <img src={viteLogo} className="logo" alt="Vite logo" />
        </a>
        <a href="https://react.dev" target="_blank">
          <img src={reactLogo} className="logo react" alt="React logo" />
        </a>
      </div>
      <h1>Vite + React</h1>
      <div className="card">
        <button onClick={() => setCount((count) => count + 1)}>
          count is {count}
        </button>
        <p>
          Edit <code>src/App.tsx</code> and save to test HMR
        </p>
      </div>
      <p className="read-the-docs">
        Click on the Vite and React logos to learn more
      </p>
 */