<?php
 #Editar como proveedores y chequear mejoras.
namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
protected $table = 'proveedores';
      public $timestamps = false;

      protected $fillable = [
            'idproveedor',
            'nombre',
            'correo',
            'telefono',
            'direccion',
            'descripcion'
            
      ];
      protected $hidden = [

      ];

      public function cargarDesdeRequest($request) {

        $this->idproveedor = $request->input('id') != "0" ? $request->input('id') : $this->idproveedor;
        $this->nombre = $request->input('txtNombre');
        $this->correo = $request->input('txtCorreo');
        $this->telefono = $request->input('txtTelefono');
        $this->direccion = $request->input('txtDireccion');
        $this->descripcion =$request->input('txtDescripcion');
      }
      
      public function insertar()
      {
          $sql = "INSERT INTO $this->table (
                  nombre, 
                  correo,
                  telefono,
                  direccion,
                  descripcion
                 
              ) VALUES (?, ?, ?, ?, ?);";
          $result = DB::insert($sql, [
              $this->nombre,
              $this->correo,
              $this->telefono,
              $this->direccion,
              $this->descripcion,
             
          ]);
          return $this->idproveedor = DB::getPdo()->lastInsertId();
      }

      public function guardar() {
        
            $sql = "UPDATE $this->table SET
                nombre='$this->nombre',
                correo='$this->correo',
                telefono='$this->telefono',
                direccion='$this->direccion',
                descripcion='$this->descripcion'
                
                
                WHERE idproveedor=?";
            
            $affected = DB::update($sql, [$this->idproveedor]);
    }
    
    
    public function eliminar()
    {
        $sql = "DELETE FROM $this->table WHERE idproveedor=?";         
        $affected = DB::delete($sql, [$this->idproveedor]);
    }

    public function obtenerPorId($idproveedor)
    {
        $sql = "SELECT
                idproveedor,
                nombre,
                correo,
                telefono,
                direccion,
                descripcion
                
                FROM $this->table WHERE idproveedor = $idproveedor";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idproveedor = $lstRetorno[0]->idproveedor;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->correo = $lstRetorno[0]->correo;
            $this->telefono = $lstRetorno[0]->telefono;
            $this->direccion = $lstRetorno[0]->direccion;
            $this->descripcion = $lstRetorno[0]->descripcion;
            return $this;
        }
        return null;
    }

    public function obtenerTodos()
    {
        $sql = "SELECT
                A.idproveedor,
                A.nombre,
                A.correo,
                A.telefono,
                A.direccion,
                A.descripcion,
               
                FROM $this->table A ORDER BY A.nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerFiltrado()
    {
        $request = $_REQUEST;
        $columns = array(  //orden de las columnas 
            0 => 'A.idproveedor',
            1 => 'A.nombre',
            2=>  'A.correo',
            3 => 'A.telefono',
            4 => 'A.direccion',
            5 => 'A.descripcion',
            
        );
        #El A. hace que le agregue un alias, es decir A referencia a la tabla clientes
        $sql = "SELECT DISTINCT  
                    A.idproveedor,  
                    A.nombre,
                    A.correo,
                    A.telefono,
                    A.direccion,
                    A.descripcion
                    
                    FROM proveedores A
                WHERE 1=1
                ";

        //Realiza el filtrado, tiene los valores de configuración de busqueda.
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( A.nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR A.correo LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR A.telefono LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR A.direccion LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR A.descripcion LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir']; //forma de ordenarlo

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function obtenerPorCorreo($correo){
        $sql = "SELECT
                idproveedor,
                correo,
                
                FROM proveedores WHERE correo = '$correo'";
        $lstRetorno = DB::select($sql);
        
        if (count ($lstRetorno) >0) {
            $this->idproveedor = $lstRetorno[0]->idcliente;
            $this->correo = $lstRetorno[0]->correo;
            
            return $this;
        }
        return null;
            
    }


}









?>