<?php
namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;


class Pedido extends Model
{
protected $table = 'pedidos';
protected $primaryKey = 'idpedido';
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

      public function cargarDesdeRequest($request) {
        $this->idpedido = $request->input('id') != "0" ? $request->input('id') : $this->idpedido;
        $this->fecha = $request->input('txtFecha');
        $this->descripcion = $request->input('txtDescripcion');
        $this->total = $request->input('txtTotal');
        $this->fk_idsucursal = $request->input('lstSucursal');
        $this->fk_idcliente = $request->input('lstCliente');
        $this->fk_idestado = $request->input('lstEstado');
        
      }

      public function insertar()
      {
            
          $sql = "INSERT INTO $this->table (
                  fecha,
                  descripcion,
                  total,
                  fk_idsucursal,
                  fk_idcliente,
                  fk_idestado
                  
              ) VALUES (?, ?, ?, ? ,? ,?);";
          $result = DB::insert($sql, [
              $this->fecha,
              $this->descripcion,
              $this->total,
              $this->fk_idsucursal,
              $this->fk_idcliente,
              $this->fk_idestado
             
          ]);
          return $this->idpedido = DB::getPdo()->lastInsertId();
        }

      public function guardar() {
        $sql = "UPDATE $this->table SET
            fecha='$this->fecha',
            descripcion='$this->descripcion',
            total='$this->total',
            fk_idsucursal='$this->fk_idsucursal',
            fk_idcliente='$this->fk_idcliente',
            fk_idestado='$this->fk_idestado'
           
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
                idpedido,
                fecha,
                descripcion,
                total,
                fk_idsucursal,
                fk_idcliente,
                fk_idestado
                FROM $this->table WHERE idpedido = $idpedido";
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
                A.idpedido,
                A.fecha,
                A.descripcion,
                A.total,
                A.fk_idsucursal,
                A.fk_idcliente,
                A.fk_idestado
                FROM $this->table A ORDER BY A.nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerFiltrado()
    {
        $request = $_REQUEST;
        $columns = array(  //orden de las columnas 
            0 => 'A.idpedido',
            1 => 'A.fecha',
            2 => 'A.descripcion',
            3 => 'A.total',
            4 => 'A.fk_idsucursal',
            5 => 'A.fk_idcliente',
            6 => 'A.fk_idestado'
           
        );
         #El A. hace que le agregue un alias, es decir A referencia a la tabla clientes
        $sql = "SELECT DISTINCT 
                    A.idpedido,  
                    A.fecha,
                    A.descripcion,
                    A.total,
                    A.fk_idsucursal,
                    D.nombre AS sucursal,
                    A.fk_idcliente,
                    B.nombre AS cliente,
                    A.fk_idestado,
                    C.nombre AS estado 
                    FROM pedidos A
                    INNER JOIN clientes B on A.fk_idcliente = B.idcliente
                    INNER JOIN estados C on A.fk_idestado = C.idestado
                    INNER JOIN sucursales D on A.fk_idsucursal = D.idsucursal

                WHERE 1=1
                ";

        //Realiza el filtrado, tiene los valores de configuración de busqueda.
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( B.nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR A.fecha LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR A.descripcion LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR D.nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR C.nombre LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir']; //forma de ordenarlo

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function obtenerPedidosPorCliente($idcliente) {
        if (isset($idcliente) && !is_null($idcliente)) {
            $sql = "SELECT
                        A.idpedido,
                        A.fecha,
                        A.descripcion,
                        A.total,
                        A.fk_idsucursal,
                        B.nombre AS sucursal,
                        A.fk_idcliente,
                        A.fk_idestado,
                        C.nombre AS estado   
                    FROM pedidos A
                    INNER JOIN sucursales B ON A.fk_idsucursal = B.idsucursal
                    INNER JOIN estados C ON A.fk_idestado = C.idestado
                    WHERE fk_idcliente = :idcliente AND A.fk_idestado <> 4";
            #linea 183, preguntamos dodnde fk sea igual al id del cliente y que el estado sea distinto de 4 (entregado)
            $lstRetorno = DB::select($sql, ['idcliente' => $idcliente]);  
            return $lstRetorno;
        }
    }
    
}
?>