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