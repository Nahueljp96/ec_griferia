<?php

namespace App\Entidades\Sistema;

use DB;
use Illuminate\Database\Eloquent\Model;

class Postulacion extends Model
{
protected $table = 'postulacion';
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
              $this->curriculum,
              
          ]);
          return $this->idpostulacion = DB::getPdo()->lastInsertId();
      }

}
?>