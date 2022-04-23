import {useEffect, useState} from 'react';
import TaskForm from "./components/TaskForm";
import Tasks from "./components/Tasks";
 
function App() {
  const [tasks, setTasks] = useState([]);
  const getTasks = async () => {
    const response = await fetch('http://localhost:8080/tareas');
    const data = await response.json();
    setTasks(data);
  };
  useEffect(() => {
    getTasks();
  }, []);
  return (
    <div className="container" >
      <div className="card mt-5">
        <div className="card-body">
          <h5 className="card-title">Mis Tareas</h5>
          <TaskForm getTasks={getTasks}/>
          <Tasks tasks={tasks} getTasks={getTasks}/>
        </div>
      </div>
    </div>
  );
}
 
export default App;