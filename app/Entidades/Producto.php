<?php

namespace App\Entidades;

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

      public function guardar() {
        $sql = "UPDATE $this->table SET
            nombre='$this->nombre',
            cantidad=$this->cantidad,
            precio=$this->precio,
            imagen='$this->imagen,'
            fk_idcategoria=$this->fk_idcategoria
            
            WHERE idproducto=?";
        $affected = DB::update($sql, [$this->idproducto]);
    }
    
    public function eliminar()
    {
        $sql = "DELETE FROM $this->table WHERE idproducto=?";         
        $affected = DB::delete($sql, [$this->idproducto]);
    }

    public function obtenerPorId($idproducto)
    {
        $sql = "SELECT
                idproducto
                nombre,
                cantidad,
                precio,
                imagen,
                fk_idcategoria
                FROM $this->table WHERE idproducto =?";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idproducto = $lstRetorno[0]->idproducto;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->cantidad = $lstRetorno[0]->cantidad;
            $this->imagen = $lstRetorno[0]->imagen;
            $this->fk_idcategoria = $lstRetorno[0]->fk_idcategoria;
          
            return $this;
        }
        return null;
    }

    public function obtenerTodos()
    {
        $sql = "SELECT
                idproducto
                nombre,
                cantidad,
                precio,
                imagen,
                fk_idcategoria
                FROM $this->table A ORDER BY nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    } 
}      
?>