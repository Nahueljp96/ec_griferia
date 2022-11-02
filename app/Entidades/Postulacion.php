<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Postulacion extends Model
{
protected $table = 'postulaciones';
      public $timestamps = false;

      protected $fillable = [
            'idpostulacion',
            'nombre',
            'apellido',
            'celular',
            'correo',
            'curriculum'
            
      ];
      protected $hidden = [

      ];


      public function insertar()
      {
          $sql = "INSERT INTO $this->table (
                  nombre,
                  apellido,
                  celular,
                  correo,
                  curriculum
                  
              ) VALUES (?, ?, ?, ?, ?);";
          $result = DB::insert($sql, [
              $this->nombre,
              $this->apellido,
              $this->celular,
              $this->correo,
              $this->curriculum
              
          ]);
          return $this->idpostulacion = DB::getPdo()->lastInsertId();
      }

      public function guardar() {
        $sql = "UPDATE $this->table SET
            nombre='$this->nombre',
            apellido=$this->apellido,
            celular=$this->celular,
            correo=$this->correo,
            curriculum='$this->curriculum'
            
            WHERE idpostulacion=?";
        $affected = DB::update($sql, [$this->idpostulacion]);
    }
    
    public function eliminar()
    {
        $sql = "DELETE FROM $this->table WHERE idpostulacion=?";         
        $affected = DB::delete($sql, [$this->idpostulacion]);
    }

    public function obtenerPorId($idpostulacion)
    {
        $sql = "SELECT
                idpostulacion
                nombre,
                apellido,
                celular,
                correo,
                curriculum
                FROM $this->table WHERE idpostulacion = $idpostulacion";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idpostulacion = $lstRetorno[0]->idpostulacion;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->apellido = $lstRetorno[0]->apellido;
            $this->celular = $lstRetorno[0]->celular;
            $this->correo = $lstRetorno[0]->correo;
            $this->curriculum = $lstRetorno[0]->curriculum;
            
            return $this;
        }
        return null;
    }

    public function obtenerTodos()
    {
        $sql = "SELECT
                A.idpostulacion
                A.nombre,
                A.apellido,
                A.celular,
                A.correo,
                A.curriculum
                FROM $this->table A ORDER BY A.nombre DESC";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

}
?>