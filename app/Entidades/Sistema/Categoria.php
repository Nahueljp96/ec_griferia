<?php

namespace App\Entidades\Sistema;

use DB;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
protected $table = 'categoria';
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
}
?>