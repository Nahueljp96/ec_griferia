<?php

namespace App\Entidades\Sistema;

use DB;
use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
protected $table = 'carritos';
      public $timestamps = false;

      protected $fillable = [
            'idcarrito',
            'fk_idcliente'
          
      ];
      protected $hidden = [

      ];


      /*public function insertar()
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
      } */


}
?>