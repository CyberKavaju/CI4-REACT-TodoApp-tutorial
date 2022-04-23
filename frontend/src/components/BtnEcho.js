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