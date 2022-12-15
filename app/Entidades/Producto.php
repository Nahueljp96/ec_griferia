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
            'fk_idcategoria',
            'descripcion'
          
      ];
      protected $hidden = [

      ];

      public function cargarDesdeRequest($request) {
        $this->idproducto = $request->input('id') != "0" ? $request->input('id') : $this->idproducto;
        $this->nombre = $request->input('txtNombre');
        $this->cantidad = $request->input('txtCantidad');
        $this->precio = $request->input('txtPrecio');
        $this->imagen = $request->input('imagen');
        $this->fk_idcategoria = $request->input('lstCategoria');
        $this->descripcion = $request->input('txtDescripcion');
      }

      public function insertar()
      {
          $sql = "INSERT INTO $this->table (
                  nombre,
                  cantidad,
                  precio,
                  imagen,
                  fk_idcategoria,
                  descripcion
                 
              ) VALUES (?, ?, ?, ?, ?, ?);";
          $result = DB::insert($sql, [
              $this->nombre,
              $this->cantidad,
              $this->precio,
              $this->imagen,
              $this->fk_idcategoria,
              $this->descripcion
              
          ]);
          return $this->idproducto = DB::getPdo()->lastInsertId();
        }

      public function guardar() {
        $sql = "UPDATE $this->table SET
            nombre='$this->nombre',
            cantidad='$this->cantidad',
            precio='$this->precio',
            imagen='$this->imagen',
            fk_idcategoria='$this->fk_idcategoria',
            descripcion='$this->descripcion'
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
                idproducto,
                nombre,
                cantidad,
                precio,
                imagen,
                fk_idcategoria,
                descripcion
                FROM $this->table WHERE idproducto = $idproducto";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idproducto = $lstRetorno[0]->idproducto;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->cantidad = $lstRetorno[0]->cantidad;
            $this->precio= $lstRetorno[0]->precio;
            $this->imagen = $lstRetorno[0]->imagen;
            $this->fk_idcategoria = $lstRetorno[0]->fk_idcategoria;
            $this->descripcion =$lstRetorno[0]->descripcion;
          
            return $this;
        }
        return null;
    }

    public function obtenerTodos()
    {
        $sql = "SELECT
                A.idproducto,
                A.nombre,
                A.cantidad,
                A.precio,
                A.imagen,
                A.fk_idcategoria,
                A.descripcion
                FROM $this->table A ORDER BY A.nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }
    
    public function obtenerFiltrado()
    {
        $request = $_REQUEST;
        $columns = array(  //orden de las columnas 
            0 => 'A.idproducto',
            1 => 'A.nombre',
            2 => 'A.cantidad',
            3 => 'A.precio',
            4 => 'A.imagen',
            5 => 'A.fk_idcategoria',
            6 => 'A.descripcion',
            
        );                             
        #El A. hace que le agregue un alias, es decir A referencia a la tabla productos
        $sql = "SELECT DISTINCT  
                    A.idproducto,
                    A.nombre,
                    A.cantidad,
                    A.precio,
                    A.imagen,
                    A.fk_idcategoria,
                    B.nombre AS categoria,
                    A.descripcion
                    FROM productos A
                    INNER JOIN categorias B ON A.fk_idcategoria = B.idcategoria
                WHERE 1=1
                ";

        //Realiza el filtrado, tiene los valores de configuración de busqueda.
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( A.nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR A.cantidad LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR A.precio LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR A.fk_idcategoria LIKE '%" . $request['search']['value'] . "%')";
           
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir']; //forma de ordenarlo

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }
}      
?>