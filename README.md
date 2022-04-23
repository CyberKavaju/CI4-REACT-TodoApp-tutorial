# Cheat Sheet CI4 / REACT
## Instalar LAMP Stack
[Tutorial de Instalacion](https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-on-ubuntu-20-04)
## Instalar Composer
[Tutorial de instalacion](https://www.hostinger.com/tutorials/how-to-install-composer)
## Instalar CI4
```bash
composer create-project codeigniter4/appstarter backend
```
## Integrate MySQL DB
.env config
```php
CI_ENVIRONMENT = development
database.default.hostname = localhost
database.default.database = ci4
database.default.username = root
database.default.password = root
database.default.DBDriver = MySQLi
```
## Iniciar Servidor
```bash
php spark serve
```
## Generar Migración
Generar archivo de migración en terminal 
```bash
php spark make:migration tbl_tareas
```
## insertar en metodo UP
```php
$this->forge->addField([
           'id'          => [
               'type'           => 'INT',
               'constraint'     => 11,
               'unsigned'       => true,
               'auto_increment' => true,
           ],
           'titulo'       => [
               'type'       => 'VARCHAR',
               'constraint' => '100',
           ],
           'descripcion'  => [
               'type'       => 'TEXT',
           ],
           'fecha_inicio' => [
               'type'       => 'DATE',
           ],
           'fecha_fin'    => [
               'type'       => 'DATE',
           ],
           'estado'       => [
               'type'       => 'VARCHAR',
               'constraint' => '100',
           ],
           'created_at'   => [
               'type'       => 'DATETIME',
               'null'       => true,
           ],
           'updated_at'   => [
               'type'       => 'DATETIME',
               'null'       => true,
           ],
           'deleted_at'   => [
               'type'       => 'DATETIME',
               'null'       => true,
           ],
       ]);
       $this->forge->addKey('id', true);
       $this->forge->createTable('tbl_tareas');
```
## Agregar a metodo DOWN
```php
$this->forge->dropTable('tbl_tareas');
```
## Hacer la migración en la terminal
```bash
php spark migrate 
```
## Generar Modelo
Generar archivo de Modelo en la terminal
```bash
php spark make:model TareaModel
```
Configurations
```php
...
   protected $DBGroup          = 'default';
   protected $table            = 'tbl_tareas';
   protected $primaryKey       = 'id';
   protected $useAutoIncrement = true;
   protected $insertID         = 0;
   protected $returnType       = 'array';
   protected $useSoftDeletes   = true;
   protected $protectFields    = true;
   protected $allowedFields    = ['titulo', 'descripcion', 'fecha_inicio', 'fecha_fin', 'estado'];
 
   // Dates
   protected $useTimestamps = true;
   protected $dateFormat    = 'datetime';
   protected $createdField  = 'created_at';
   protected $updatedField  = 'updated_at';
   protected $deletedField  = 'deleted_at';
...
```
Generar Controlador
Generar controlador con la terminal
php spark make:controller Tareas --restful
Configurar coneccion al modelo
…
use App\Models\TareaModel;
class Tareas extends ResourceController
{
   protected $model;
   public function __construct()
   {
       $this->model = new TareaModel();
   }
…

Generar index
public function index()
{
        return $this->respond($this->model->findAll());
}
Generar read
public function show($id = null)
{
        return $this->respond($this->model->find($id));
}
Generar create
 public function create()
{
        $rules = [
            'titulo' => 'required|min_length[3]|max_length[255]',
            'descripcion' => 'required|min_length[3]|max_length[255]',
            'fecha_inicio' => 'required|min_length[3]|max_length[255]',
            'fecha_fin' => 'required|min_length[3]|max_length[255]',
            'estado' => 'required',
        ];
        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }
        $data = [
            'titulo' => $this->request->getVar('titulo'),
            'descripcion' => $this->request->getVar('descripcion'),
            'fecha_inicio' => $this->request->getVar('fecha_inicio'),
            'fecha_fin' => $this->request->getVar('fecha_fin'),
            'estado' => $this->request->getVar('estado'),
        ];
        if($this->model->insert($data)){
            $response = [
                'status' => true,
                'message' => 'Tarea creada correctamente',
                'data' => $this->model->find($this->model->insertID)
            ];
            return $this->respondCreated($response);
        }else{
            $response = [
                'status' => false,
                'message' => 'Error al crear la tarea',
                //get the error data
                'data' => $this->model->errors()
            ];
            return $this->respondCreated($response);
        }
}
Generar update
public function update($id = null)
{
    $tarea = $this->model->find($id);
        if(!$tarea){
            $response = [
                'status' => false,
                'message' => 'Tarea no encontrada',
                'data' => $this->model->errors()
            ];
            return $this->respondCreated($response);
        }else {
        $rules = [
            'titulo' => 'required|min_length[3]|max_length[255]',
            'descripcion' => 'required|min_length[3]|max_length[255]',
            'fecha_inicio' => 'required|min_length[3]|max_length[255]',
            'fecha_fin' => 'required|min_length[3]|max_length[255]',
            'estado' => 'required',
        ];
        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }
        $data = [
            'titulo' => $this->request->getVar('titulo'),
            'descripcion' => $this->request->getVar('descripcion'),
            'fecha_inicio' => $this->request->getVar('fecha_inicio'),
            'fecha_fin' => $this->request->getVar('fecha_fin'),
            'estado' => $this->request->getVar('estado'),
        ];
        if($this->model->update($id, $data)){
            $response = [
                'status' => true,
                'message' => 'Tarea actualizada correctamente',
                'data' => $this->model->find($id)
            ];
            return $this->respondCreated($response);
        }else{
            $response = [
                'status' => false,
                'message' => 'Error al actualizar la tarea',
                //get the error data
                'data' => $this->model->errors()
            ];
            return $this->respondCreated($response);
        }
}
}
Generar delete
public function delete($id = null)
{
        if($this->model->delete($id)){
            $response = [
                'status' => true,
                'message' => 'Tarea eliminada correctamente',
                'data' => $this->model->find($id)
            ];
            return $this->respondCreated($response);
        }else{
            $response = [
                'status' => false,
                'message' => 'Error al eliminar la tarea',
                //get the error data
                'data' => $this->model->errors()
            ];
            return $this->respondCreated($response);
        }
}
Habilitar filtro CORS
php spark make:filter Cors
insertar en método BEFORE
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-API-KEY, Origin,X-Requested-With, Content-Type, Accept, Access-Control-Requested-Method, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PATCH, PUT, DELETE");
$method = $_SERVER['REQUEST_METHOD'];
if($method == "OPTIONS"){die();}
Llamar datos en app/Config/Filters.php 
use App\Filters\Cors;
…
public $aliases = [
     'csrf'     => CSRF::class,
     'toolbar'  => DebugToolbar::class,
     'honeypot' => Honeypot::class,
     'cors'     => Cors::class,  
];
…
public $globals = [
    'before' => [
        // 'honeypot',
        // 'csrf',
        'cors'
    ],
    'after' => [
        'toolbar',
        // 'honeypot',
    ],
];
 
Instalar node.js
https://www.digitalocean.com/community/tutorials/how-to-install-node-js-on-ubuntu-20-04
Instalar npm
sudo apt install npm
Instalar react.js
npx create-react-app frontend
Generar Componente CRUD
install bootstrap
npm install --save bootstrap
Llamar en el index.js
import 'bootstrap/dist/css/bootstrap.min.css';
Generar App.js
import {useEffect, useState} from 'react';
import TaskForm from "./componets/TaskForm";
import Tasks from "./componets/Tasks";
 
function App() {
  const [tasks, setTasks] = useState([]);
  //get tasks from API
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
Generar Tasks.js
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
Generate TaskForm.js
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
Generar BtnEcho.js
const BtnEcho = (props) => {
  //cange the state of the task
  const handleEcho = async (id) => {
    const  status = {
      id: id,
      estado: 1
    };
    const response = await fetch('http://localhost:8080/tareas/done/'+id, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(status)
    });
    const data = await response.json();
    if (data.status === true) {
      props.getTasks();
    }
  };
  return (
    <button className="btn btn-success btn-sm " onClick={() => handleEcho(props.id)}>Echo</button>
   );
}
 
export default BtnEcho;
Generar BtnBorrar.js
const BtnBorrar = (props) => {
  const handleDelete = async (id) => {
    const response = await fetch('http://localhost:8080/tareas/delete/'+id, {
      method: 'DELETE'
    });
    const data = await response.json();
    if (data.status === true) {
      props.getTasks();
    }
  };
  return (
    <>
      <button className="btn btn-danger btn-sm" onClick={() => handleDelete(props.id)}>Borrar</button>
    </>
  );
}
 
export default BtnBorrar;
## Generar index.css
```css
.taskList{
  list-style: none;
  padding: 0;
  margin: 0;
}
.taskList li{
  padding: 0.25em 0;
  border-bottom: 1px solid #e5e5e5;
}
.taskList li span{
  font-weight: bolder;
}
.taskList li button{
  margin-left: 1em;
}
.addTask{
  margin-top: 1em;
  padding: 0.25em 0;
  border-top: 1px solid #e5e5e5;
  border-bottom: 1px solid #e5e5e5;
}
```


