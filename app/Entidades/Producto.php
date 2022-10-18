<?php

namespace App\Entidades\Sistema;

use DB;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
protected $table = 'productos';
      public $timestamps = false;

      protected $fillable = [
            'idproducto',
            'nombre',
            'cantidad',
            'precio',
            'imagen',
            'fk_idcategoria'
          
      ];
      protected $hidden = [

      ];


      public function insertar()
      {
          $sql = "INSERT INTO $this->table (
                  nombre,
                  cantidad,
                  precio,
                  imagen,
                  fk_idcategoria
                 
              ) VALUES (?, ?, ?, ?, ?);";
          $result = DB::insert($sql, [
              $this->nombre,
              $this->cantidad,
              $this->precio,
              $this->imagen,
              $this->fk_idcategoria,
              
          ]);
          return $this->idproducto = DB::getPdo()->lastInsertId();
      }
}      
?>