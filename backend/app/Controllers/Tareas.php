<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\TareaModel;
class Tareas extends ResourceController
{
    protected $model;
    public function __construct()
    {
        $this->model = new TareaModel();
    }
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        return $this->respond($this->model->find($id));
    }


    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $rules = [
            'titulo' => 'required|min_length[3]|max_length[100]',
            'descripcion' => 'required|min_length[3]|max_length[500]',
            'fecha_inicio' => 'required|min_length[3]|max_length[20]',
            'fecha_fin' => 'required|min_length[3]|max_length[20]',
        ];
        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }
        $data = [
            'titulo' => $this->request->getVar('titulo'),
            'descripcion' => $this->request->getVar('descripcion'),
            'fecha_inicio' => $this->request->getVar('fecha_inicio'),
            'fecha_fin' => $this->request->getVar('fecha_fin'),
            'estado' => '0',
        ];
        if ($this->model->insert($data)) {
            $response = [
                'status' => true,
                'message' => 'Tarea creada correctamente',
                'data' => $this->model->find($this->model->insertID)
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                'status' => false,
                'message' => 'Error al crear la tarea',
                //get the error data
                'data' => $this->model->errors()
            ];
            return $this->respondCreated($response);
        }
    }

    

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $tarea = $this->model->find($id);
        if (!$tarea) {
            $response = [
                'status' => false,
                'message' => 'Tarea no encontrada',
                'data' => $this->model->errors()
            ];
            return $this->respondCreated($response);
        } else {
            $rules = [
                'titulo' => 'required|min_length[3]|max_length[255]',
                'descripcion' => 'required|min_length[3]|max_length[255]',
                'fecha_inicio' => 'required|min_length[3]|max_length[255]',
                'fecha_fin' => 'required|min_length[3]|max_length[255]',
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
            if ($this->model->update($id, $data)) {
                $response = [
                    'status' => true,
                    'message' => 'Tarea actualizada correctamente',
                    'data' => $this->model->find($id)
                ];
                return $this->respondCreated($response);
            } else {
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
    public function done($id = null)
    {
        $tarea = $this->model->find($id);
        if (!$tarea) {
            $response = [
                'status' => false,
                'message' => 'Tarea no encontrada',
                'data' => $this->model->errors()
            ];
            return $this->respondCreated($response);
        } else {
            $rules = [
                'estado' => 'required',
            ];
            if (!$this->validate($rules)) {
                return $this->fail($this->validator->getErrors());
            }
            $data = [
                'estado' => $this->request->getVar('estado'),
            ];
            if ($this->model->update($id, $data)) {
                $response = [
                    'status' => true,
                    'message' => 'Tarea actualizada correctamente',
                    'data' => $this->model->find($id)
                ];
                return $this->respondCreated($response);
            } else {
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
    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            $response = [
                'status' => true,
                'message' => 'Tarea eliminada correctamente',
                'data' => $this->model->find($id)
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                'status' => false,
                'message' => 'Error al eliminar la tarea',
                //get the error data
                'data' => $this->model->errors()
            ];
            return $this->respondCreated($response);
        }
    }
}
