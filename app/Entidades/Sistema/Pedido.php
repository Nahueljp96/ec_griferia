<?php
namespace App\Entidades\Sistema;

use DB;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
protected $table = 'pedido';
      public $timestamps = false;

      protected $fillable = [
            'idpedido',
            'fecha',
            'descripcion',
            'total',
            'fk_idsucursal',
            'fk_idcliente',
            'fk_idestado'
      ];
      protected $hidden = [

      ];


      public function insertar()
      {
          $sql = "INSERT INTO $this->table (
                  fecha,
                  descripcion,
                  total
                  
              ) VALUES (?, ?, ?);";
          $result = DB::insert($sql, [
              $this->fecha,
              $this->descripcion,
              $this->total,
             
          ]);
          return $this->idpedido = DB::getPdo()->lastInsertId();
      }
}
?>