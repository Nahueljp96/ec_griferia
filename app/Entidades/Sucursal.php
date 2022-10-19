<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
      protected $table = 'sucursales';
      public $timestamps = false;

      protected $fillable = [
            'idsucursal',
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
          return $this->idcliente = DB::getPdo()->lastInsertId();
      }

      public function guardar() {
        $sql = "UPDATE $this->table SET
            nombre='$this->nombre',
            
            
            WHERE idsucursal=?";
        $affected = DB::update($sql, [$this->idsucursal]);
    }
    
    public function eliminar()
    {
        $sql = "DELETE FROM $this->table WHERE idsucursal=?";         
        $affected = DB::delete($sql, [$this->idsucursal]);
    }

    public function obtenerPorId($idsucursal)
    {
        $sql = "SELECT
                idsucursal,
                nombre
               
                FROM $this->table WHERE idsucursal =?";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idsucursal = $lstRetorno[0]->idsucursal;
            $this->nombre = $lstRetorno[0]->nombre;
           
            return $this;
        }
        return null;
    }

    public function obtenerTodos()
    {
        $sql = "SELECT
                idsucursal,
                nombre
                FROM $this->table A ORDER BY nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }
}



?>