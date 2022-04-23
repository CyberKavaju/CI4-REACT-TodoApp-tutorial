import {useState} from 'react';
const TaskForm = (props) => {
  const [titulo, setTitulo] = useState('');
  const [descripcion, setDescripcion] = useState('');
  const [fechaInicio, setFechaInicio] = useState('');
  const [fechaFin, setFechaFin] = useState('');
 
  const handleAddTask = async () => {
    //create a task
    fetch('http://localhost:8080/tareas/create', {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        titulo: titulo,
        descripcion: descripcion,
        fecha_inicio: fechaInicio,
        fecha_fin: fechaFin
      })
    }).then(response => response.json()).then(data => {
      data.status === true ? props.getTasks() : console.log(data);
    });
  }
  return (
    <div className="row g-3 addTask">
      <div className="col-auto">
        <input type="text" className="form-control-sm" placeholder="Tarea" value={titulo}
        onChange={(e) => setTitulo(e.target.value)}
        />
      </div>
      <div className="col-auto">
        <input type="text" className="form-control-sm" placeholder="Descripción" value={descripcion}
        onChange={(e) => setDescripcion(e.target.value)}
        />
      </div>
      <div className="col-auto">
        <input type="date" className="form-control-sm" value={fechaInicio}
        onChange={(e) => setFechaInicio(e.target.value)}
        />
      </div>
      <div className="col-auto">
        <input type="date" className="form-control-sm" value={fechaFin}
        onChange={(e) => setFechaFin(e.target.value)}
        />
      </div>
      <div className="col-auto">
        <button className="btn btn-success btn-sm mb-3" onClick={handleAddTask}> + </button>
      </div>
    </div>
 
   );
}
 
export default TaskForm;