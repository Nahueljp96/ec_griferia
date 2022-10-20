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
                
                FROM $this->table WHERE idcategoria =?";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idcategoria = $lstRetorno[0]->idcliente;
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
}
?>