<?php

namespace App\Entidades\Sistema;

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
}      
?>