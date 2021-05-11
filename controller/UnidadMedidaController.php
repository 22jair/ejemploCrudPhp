<?php

include_once __DIR__ . '/../service/UnidadMedidaService.php';

class UnidadMedidaController
{

    private $service;

    function __construct()
    {
        $this->service = new UnidadMedidaService();
    }

    function listar()
    {
        $data = $this->service->listar();
        echo json_encode(["data" => $data]);
    }

    function porId($id)
    {
        $data = $this->service->porId($id);

        if (count($data) > 0) {
            http_response_code(200);
            echo json_encode($data);
        } else {
            http_response_code(404);
            echo json_encode(["message" =>"Unidad de Medida no encontrado.", "data" =>$data]);       
        }
    }

    function agregar($data)
    {
        $errors = [];

        if (!isset($data["unidad_medida"]) || strlen($data["unidad_medida"]) <= 0) $errors["unidad_medida"] = "Ingrese unidad de medida";
        if (!isset($data["descripcion"]) || strlen($data["descripcion"]) <= 0) $errors["descripcion"] = "Ingrese unidad de medida";

        if (count($errors) > 0){
            http_response_code(404);
            echo json_encode(["message" =>"Corregir los errores.", "errors"=>$errors]);            
            die();
        } 

        if ($this->service->agregar($data)) {
            http_response_code(201);
            echo json_encode(["message" => "Registrado correctamente."]);
        } else {
            http_response_code(404);
            echo json_encode(["message" =>"Error en el servicio, Contacte a Sistemas."]);
        }        
    }

    function actualizar($data)
    {
        $errors = [];
        if (!isset($data["id_unidad_medida"]) || strlen($data["id_unidad_medida"]) <= 0) $errors["id_unidad_medida"] = "Ingrese el ID.";
        if (!isset($data["unidad_medida"]) || strlen($data["unidad_medida"]) <= 0) $errors["unidad_medida"] = "Ingrese unidad de medida";
        if (!isset($data["descripcion"]) || strlen($data["descripcion"]) <= 0) $errors["descripcion"] = "Ingrese unidad de medida";

        if (count($errors) > 0){
            http_response_code(404);
            echo json_encode(["message" =>"Corregir los errores.", "errors"=>$errors]);            
            die();
        } 

        if ($this->service->actualizar($data)) {
            http_response_code(200);
            echo json_encode(["message" => "Actualizado correctamente."]);
        } else {
            http_response_code(404);
            echo json_encode(["message" =>"Error en el servicio, Contacte a Sistemas."]);
        }
    }

    function eliminar($id)
    {
        $errors = [];
        if (strlen($id) <= 0) $errors["id_unidad_medida"] = "Ingrese id_unidad_medida";        

        if (count($errors) > 0){
            http_response_code(404);
            echo json_encode(["message" =>"Corregir los errores.", "errors"=>$errors]);            
            die();
        } 

        if ($this->service->eliminar($id)) {
            http_response_code(200);
            echo json_encode(["message" => "Eliminado correctamente."]);
        } else {
            http_response_code(404);
            echo json_encode(["message" =>"Error en el servicio, Contacte a Sistemas."]);
        }
    }
}
