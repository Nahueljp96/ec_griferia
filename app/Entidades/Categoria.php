<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
protected $table = 'categorias';
      public $timestamps = false;

      protected $fillable = [
            'idcategoria',
            'nombre'
      ];
      protected $hidden = [

      ];

      public function cargarDesdeRequest($request) {
        $this->idcategoria = $request->input('id') != "0" ? $request->input('id') : $this->idcategoria;
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
          return $this->idcategoria = DB::getPdo()->lastInsertId();
      }

      public function guardar() {
        $sql = "UPDATE $this->table SET
            nombre='$this->nombre',
         
            WHERE idcategoria=?";
        $affected = DB::update($sql, [$this->idcategoria]);
    }
    
    public function eliminar()
    {
        $sql = "DELETE FROM $this->table WHERE idcategoria=?";         
        $affected = DB::delete($sql, [$this->idcategoria]);
    }

    public function obtenerPorId($idcategoria)
    {
        $sql = "SELECT
                idcategoria,
                nombre
                
                FROM $this->table WHERE idcategoria = $idcategoria";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idcategoria = $lstRetorno[0]->idcategoria;
            $this->nombre = $lstRetorno[0]->nombre;
            
            return $this;
        }
        return null;
    }

    public function obtenerTodos()
    {
        $sql = "SELECT
                A.idcategoria,
                A.nombre
               
                FROM $this->table A ORDER BY A.nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }
    
    public function obtenerFiltrado()
    {
        $request = $_REQUEST;
        $columns = array(  //orden de las columnas 
            0 => 'A.idcategoria',
            1 => 'A.nombre',
           
            
        );                             
        #El A. hace que le agregue un alias, es decir A referencia a la tabla productos
        $sql = "SELECT DISTINCT  
                    A.idcategoria,
                    A.nombre
                    FROM categorias A
                    
                WHERE 1=1
                ";

        //Realiza el filtrado, tiene los valores de configuración de busqueda.
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( A.nombre LIKE '%" . $request['search']['value'] . "%' ";
           // $sql .= " OR A.nombre LIKE '%" . $request['search']['value'] . "%' ";
            
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir']; //forma de ordenarlo

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }
}
?>