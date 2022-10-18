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


      public function insertar()
      {
          $sql = "INSERT INTO $this->table (
                  fk_idcliente
                  
              ) VALUES (?);";
          $result = DB::insert($sql, [
              $this->fk_idcliente,
             
          ]);
          return $this->idcarrito = DB::getPdo()->lastInsertId();
      } 


}
?>