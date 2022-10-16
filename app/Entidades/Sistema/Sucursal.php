<?php

namespace App\Entidades\Sistema;

use DB;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
      protected $table = 'sucursales';
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
          return $this->idcliente = DB::getPdo()->lastInsertId();
      }
}



?>