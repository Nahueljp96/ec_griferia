<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
protected $table = 'compras';
      public $timestamps = false;

      protected $fillable = [
            'idcompra',
            'nombre',
            'fk_idproveedor',
            'descripcion',
            'total',
            'fecha',
            'imagen'
          
      ];
      protected $hidden = [

      ];

      public function cargarDesdeRequest($request) {
        $this->idcompra = $request->input('id') != "0" ? $request->input('id') : $this->idcompra;
        $this->nombre = $request->input('txtNombre');
        $this->fk_idproveedor = $request->input('lstProveedor');
        $this->descripcion = $request->input('txtDescripcion');
        $this->total = $request->input('txtTotal');
        $this->fecha = $request->input('txtFecha');
        $this->imagen = $request->input('imagen');
      }

      public function insertar()
      {
          $sql = "INSERT INTO $this->table (
                  nombre,
                  fk_idproveedor,
                  descripcion,
                  total,
                  fecha,
                  imagen
                  
                 
              ) VALUES (?, ?, ?, ?, ?, ?);";
          $result = DB::insert($sql, [
              $this->nombre,
              $this->fk_idproveedor,
              $this->descripcion,
              $this->total,
              $this->fecha,
              $this->imagen
              
          ]);
          return $this->idproducto = DB::getPdo()->lastInsertId();
        }

      public function guardar() {
        $sql = "UPDATE $this->table SET
            nombre='$this->nombre',
            fk_idproveedor='$this->fk_idproveedor',
            descripcion='$this->descripcion',
            total='$this->total',
            fecha='$this->fecha',
            imagen='$this->imagen'
            WHERE idcompra=?";
        $affected = DB::update($sql, [$this->idcompra]);
    }
    
    public function eliminar()
    {
        $sql = "DELETE FROM $this->table WHERE idcompra=?";         
        $affected = DB::delete($sql, [$this->idcompra]);
    }

    public function obtenerPorId($idcompra)
    {
        $sql = "SELECT
                idcompra,
                nombre,
                fk_idproveedor,
                descripcion,
                total,
                fecha,
                imagen
                
                FROM $this->table WHERE idcompra = $idcompra";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idcompra = $lstRetorno[0]->idcompra;
            $this->nombre =$lstRetorno[0]->nombre;
            $this->fk_idproveedor = $lstRetorno[0]->fk_idproveedor;
            $this->descripcion = $lstRetorno[0]->descripcion;
            $this->total= $lstRetorno[0]->total;
            $this->fecha = $lstRetorno[0]->fecha;
            $this->imagen = $lstRetorno[0]->imagen;
            
          
            return $this;
        }
        return null;
    }

    public function obtenerTodos()
    {
        $sql = "SELECT
                A.idcompra,
                A.nombre,
                A.fk_idproveedor,
                A.descripcion,
                A.total,
                A.fecha,
                A.imagen
                FROM $this->table A ORDER BY A.nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }
    
    public function obtenerFiltrado()
    {
        $request = $_REQUEST;
        $columns = array(  //orden de las columnas 
            0 => 'A.idcompra',
            1 => 'A.fk_idproveedor',
            2 => 'A.nombre',
            3 => 'A.descripcion',
            4 => 'A.total',
            5 => 'A.fecha',
            6 => 'A.imagen',
            
        );                             
        #El A. hace que le agregue un alias, es decir A referencia a la tabla productos
        $sql = "SELECT DISTINCT  
                    A.idcompra,
                    A.fk_idproveedor,
                    A.nombre,
                    A.descripcion,
                    A.total,
                    A.fecha,
                    A.imagen,
                    B.nombre AS proveedor,
                    A.descripcion
                    FROM compras A
                    INNER JOIN proveedores B ON A.fk_idproveedor = B.idproveedor
                WHERE 1=1
                ";

        //Realiza el filtrado, tiene los valores de configuración de busqueda.
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( A.nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR A.fk_idproveedor LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR A.precio LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR A.fecha LIKE '%" . $request['search']['value'] . "%')";
           
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir']; //forma de ordenarlo

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }
}      
?>