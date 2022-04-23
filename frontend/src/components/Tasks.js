import BtnBorrar from "./BtnBorrar";
import BtnEcho from "./BtnEcho";
 
const Tasks = ({tasks, getTasks}) => {
  return (
    <>
      <ul className="taskList">
        {tasks.map(task => (
            <li key={task.id}>
              <span>{task.titulo}</span> - {task.descripcion} -
              Inicia: {task.fecha_inicio} - Termina: {task.fecha_fin}
               <BtnBorrar id={task.id} getTasks={getTasks}/>
               {task.estado === '0' && <BtnEcho id={task.id} getTasks={getTasks}/>}
            </li>
        ))}
      </ul>
    </>
   );
}
 
export default Tasks;