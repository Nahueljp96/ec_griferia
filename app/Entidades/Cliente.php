<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
protected $table = 'clientes';
      public $timestamps = false;

      protected $fillable = [
            'idcliente',
            'nombre',
            'apellido',
            'correo',
            'dni',
            'celular',
            'direccion',
            'clave'
      ];
      protected $hidden = [

      ];

      public function cargarDesdeRequest($request) {
        $this->idcliente = $request->input('id') != "0" ? $request->input('id') : $this->idcliente;
        $this->nombre = $request->input('txtNombre');
        $this->apellido = $request->input('txtApellido');
        $this->correo = $request->input('txtCorreo');
        $this->dni = $request->input('txtDni');
        $this->celular = $request->input('txtCelular');
        $this->direccion =$request->input('txtDireccion');
        $this->clave = password_hash($request->input('txtClave'), PASSWORD_DEFAULT);
      }
      
      public function insertar()
      {
          $sql = "INSERT INTO $this->table (
                  nombre, 
                  apellido,
                  correo,
                  dni,
                  celular,
                  direccion,
                  clave
              ) VALUES (?, ?, ?, ?, ?, ?,?);";
          $result = DB::insert($sql, [
              $this->nombre,
              $this->apellido,
              $this->correo,
              $this->dni,
              $this->celular,
              $this->direccion,
              $this->clave
          ]);
          return $this->idcliente = DB::getPdo()->lastInsertId();
      }

      public function guardar() {
        if($this->clave != ""){
            $sql = "UPDATE $this->table SET
                nombre='$this->nombre',
                apellido='$this->apellido',
                correo='$this->correo',
                dni='$this->dni',
                celular='$this->celular',
                direccion='$this->direccion',
                clave='$this->clave'
                
                WHERE idcliente=?";
            } else{    
            $sql = "UPDATE $this->table SET
                nombre='$this->nombre',
                apellido='$this->apellido',
                correo='$this->correo',
                dni='$this->dni',
                celular='$this->celular',
                direccion='$this->direccion'
                
                WHERE idcliente=?";
            }
            $affected = DB::update($sql, [$this->idcliente]);
    }
    
    public function eliminar()
    {
        $sql = "DELETE FROM $this->table WHERE idcliente=?";         
        $affected = DB::delete($sql, [$this->idcliente]);
    }

    public function obtenerPorId($idcliente)
    {
        $sql = "SELECT
                idcliente,
                nombre,
                apellido,
                correo,
                dni,
                celular,
                direccion,
                clave
                FROM $this->table WHERE idcliente = $idcliente";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idcliente = $lstRetorno[0]->idcliente;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->apellido = $lstRetorno[0]->apellido;
            $this->correo = $lstRetorno[0]->correo;
            $this->dni = $lstRetorno[0]->dni;
            $this->celular = $lstRetorno[0]->celular;
            $this->direccion =$lstRetorno[0]->direccion;
            $this->clave = $lstRetorno[0]->clave;
            return $this;
        }
        return null;
    }

    public function obtenerTodos()
    {
        $sql = "SELECT
                A.idcliente,
                A.nombre,
                A.apellido,
                A.correo,
                A.dni,
                A.celular,
                A.direccion,
                A.clave
                FROM $this->table A ORDER BY A.nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerFiltrado()
    {
        $request = $_REQUEST;
        $columns = array(  //orden de las columnas 
            0 => 'A.idcliente',
            1 => 'A.nombre',
            2=>  'A.apellido',
            3 => 'A.dni',
            4 => 'A.correo',
            5 => 'A.direccion',
            6 => 'A.celular',
        );
        #El A. hace que le agregue un alias, es decir A referencia a la tabla clientes
        $sql = "SELECT DISTINCT  
                    A.idcliente,  
                    A.nombre,
                    A.apellido,
                    A.correo,
                    A.dni,
                    A.celular,
                    A.direccion,
                    A.clave
                    FROM clientes A
                WHERE 1=1
                ";

        //Realiza el filtrado, tiene los valores de configuración de busqueda.
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( A.nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR A.apellido LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR A.documento LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR A.correo LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR A.direccion LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR A.celular LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir']; //forma de ordenarlo

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function obtenerPorCorreo($correo){
        $sql = "SELECT
                idcliente,
                correo,
                clave
                FROM clientes WHERE correo = '$correo'";
        $lstRetorno = DB::select($sql);
        
        if (count ($lstRetorno) >0) {
            $this->idcliente = $lstRetorno[0]->idcliente;
            $this->correo = $lstRetorno[0]->correo;
            $this->clave = $lstRetorno[0]->clave;
            return $this;
        }
        return null;
            
    }


}









?>