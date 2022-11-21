<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
protected $table = 'estados';
      public $timestamps = false;

      protected $fillable = [
            'idestado',
            'nombre'
           
      ];
      protected $hidden = [

      ];

      public function cargarDesdeRequest($request) {
        $this->idestado = $request->input('id') != "0" ? $request->input('id') : $this->idestado;
        $this->nombre = $request->input('txtNombre');
      
      }

      public function insertar()
      {
          $sql = "INSERT INTO $this->table (
                  nombre
                 
              ) VALUES (?);";
          $result = DB::insert($sql, [
              $this->nombre,
             
          ]);
          return $this->idestado = DB::getPdo()->lastInsertId();
      }

      public function guardar() {
        $sql = "UPDATE $this->table SET
            nombre='$this->nombre',
            
            
            WHERE idestado=?";
        $affected = DB::update($sql, [$this->idestado]);
    }
    
    public function eliminar()
    {
        $sql = "DELETE FROM $this->table WHERE idestado=?";         
        $affected = DB::delete($sql, [$this->idestado]);
    }

    public function obtenerPorId($idestado)
    {
        $sql = "SELECT
                idestado,
                nombre
               
                FROM $this->table WHERE idestado = $idestado";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idestado = $lstRetorno[0]->idestado;
            $this->nombre = $lstRetorno[0]->nombre;
           
            return $this;
        }
        return null;
    }

    public function obtenerTodos()
    {
        $sql = "SELECT
                A.idestado,
                A.nombre
               
                FROM $this->table A ORDER BY A.nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerFiltrado()
    {
        $request = $_REQUEST;
        $columns = array(  //orden de las columnas 
            0 => 'A.idestado',
            1 => 'A.nombre',
         
        );
        #El A. hace que le agregue un alias, es decir A referencia a la tabla clientes
        $sql = "SELECT DISTINCT  
                     A.idestado,
                     A.nombre
                    FROM estados A
                WHERE 1=1
                ";

        //Realiza el filtrado, tiene los valores de configuración de busqueda.
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( A.nombre LIKE '%" . $request['search']['value'] . "%' )";
            
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir']; //forma de ordenarlo

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }
}      
?>