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
            'clave'
      ];
      protected $hidden = [

      ];


      public function insertar()
      {
          $sql = "INSERT INTO $this->table (
                  nombre,
                  apellido,
                  correo,
                  dni,
                  celular,
                  clave
              ) VALUES (?, ?, ?, ?, ?, ?);";
          $result = DB::insert($sql, [
              $this->nombre,
              $this->apellido,
              $this->correo,
              $this->dni,
              $this->celular,
              $this->clave,
          ]);
          return $this->idcliente = DB::getPdo()->lastInsertId();
      }

      public function guardar() {
        $sql = "UPDATE $this->table SET
            nombre='$this->nombre',
            apellido=$this->apellido,
            correo=$this->correo,
            dni=$this->dni,
            celular='$this->celular'
            
            WHERE idcliente=?";
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
                clave
                FROM $this->table WHERE idcliente =?";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idcliente = $lstRetorno[0]->idcliente;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->apellido = $lstRetorno[0]->apellido;
            $this->correo = $lstRetorno[0]->correo;
            $this->dni = $lstRetorno[0]->dni;
            $this->celular = $lstRetorno[0]->celular;
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
                A.clave
                FROM $this->table A ORDER BY A.nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }
}









?>