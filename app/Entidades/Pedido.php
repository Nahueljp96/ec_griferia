<?php
namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
protected $table = 'pedidos';
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

      public function guardar() {
        $sql = "UPDATE $this->table SET
            fecha='$this->fecha',
            descripcion=$this->descripcion,
            total=$this->total
           
            
            WHERE idpedido=?";
        $affected = DB::update($sql, [$this->idpedido]);
    }
    
    public function eliminar()
    {
        $sql = "DELETE FROM $this->table WHERE idpedido=?";         
        $affected = DB::delete($sql, [$this->idpedido]);
    }

    public function obtenerPorId($idpedido)
    {
        $sql = "SELECT
                'idpedido',
                'fecha',
                'descripcion',
                'total',
                'fk_idsucursal',
                'fk_idcliente',
                'fk_idestado'
                FROM $this->table WHERE idpedido =?";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idpedido = $lstRetorno[0]->idpedido;
            $this->fecha = $lstRetorno[0]->fecha;
            $this->descripcion = $lstRetorno[0]->descripcion;
            $this->total = $lstRetorno[0]->total;
            $this->fk_idsucursal = $lstRetorno[0]->fk_idsucursal;
            $this->fk_idcliente = $lstRetorno[0]->fk_idcliente;
            $this->fk_idestado = $lstRetorno[0]->fk_idestado;
            return $this;
        }
        return null;
    }

    public function obtenerTodos()
    {
        $sql = "SELECT
                'idpedido',
                'fecha',
                'descripcion',
                'total',
                'fk_idsucursal',
                'fk_idcliente',
                'fk_idestado'
                FROM $this->table A ORDER BY nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }
}
?>