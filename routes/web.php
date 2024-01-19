<?php
 //use Carbon\Carbon; 
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

/*Route::get('/time' , function(){$date =new Carbon;echo $date ; } );*/

use App\Http\Controllers\ControladorProducto;
use App\Http\Controllers\ProductoController;


Route::group(array('domain' => '127.0.0.1'), function () {

    Route::get('/', 'ControladorWebHome@index');
    Route::get('/takeaway', 'ControladorWebTakeaway@index');
    Route::post('/takeaway', 'ControladorWebTakeaway@cargarCarrito');
    Route::get('/nosotros', 'ControladorWebNosotros@index');
    Route::get('/gracias-postulacion', 'ControladorWebGraciasPostulacion@index');
    Route::post('/nosotros', 'ControladorWebNosotros@enviar');
    Route::get('/contacto', 'ControladorWebContacto@index');
    Route::post('/contacto', 'ControladorWebContacto@enviar');
    Route::get('/confirmacion-envio', 'ControladorWebConfirmacionEnvio@index');
    Route::get('/mi-cuenta', 'ControladorWebMiCuenta@index');
    Route::get('/login', 'ControladorWebLogin@index');
    Route::post('/login', 'ControladorWebLogin@ingresar');
    Route::get('/recuperar-clave', 'ControladorWebRecuperarClave@index');
    Route::post('/recuperar-clave', 'ControladorWebRecuperarClave@enviar');
    Route::get('/nuevo-registro', 'ControladorWebNuevoRegistro@index');
    Route::post('/nuevo-registro', 'ControladorWebNuevoRegistro@enviar');
    Route::get('/cambiar-clave', 'ControladorWebCambiarClave@index');
    Route::post('/cambiar-clave', 'ControladorWebCambiarClave@guardar');
    Route::get('/logout', 'ControladorWebLogout@logout');
    Route::get('/cambiar-datos', 'ControladorWebCambiarDatos@index');
    Route::post('/cambiar-datos', 'ControladorWebCambiarDatos@editar');
    Route::post('/datos-cambiados', 'ControladorWebDatosCambiados@index');
    Route::get('/carrito', 'ControladorWebCarrito@index');
    Route::post('/carrito', 'ControladorWebCarrito@finalizarPedido');
    Route::post('/eliminarProducto', 'ControladorWebCarrito@eliminarProducto');
    

#le borer el {idPedido} a la ultima ruta para probar
    // web.php


    

 

    Route::get('/admin', 'ControladorHome@index');
    Route::post('/admin/patente/nuevo', 'ControladorPatente@guardar');

/* --------------------------------------------- */
/* CONTROLADOR LOGIN                           */
/* --------------------------------------------- */
    Route::get('/admin/login', 'ControladorLogin@index');
    Route::get('/admin/logout', 'ControladorLogin@logout');
    Route::post('/admin/logout', 'ControladorLogin@entrar');
    Route::post('/admin/login', 'ControladorLogin@entrar');

/* --------------------------------------------- */
/* CONTROLADOR RECUPERO CLAVE                    */
/* --------------------------------------------- */
    Route::get('/admin/recupero-clave', 'ControladorRecuperoClave@index');
    Route::post('/admin/recupero-clave', 'ControladorRecuperoClave@recuperar');

/* --------------------------------------------- */
/* CONTROLADOR PERMISO                           */
/* --------------------------------------------- */
    Route::get('/admin/usuarios/cargarGrillaFamiliaDisponibles', 'ControladorPermiso@cargarGrillaFamiliaDisponibles')->name('usuarios.cargarGrillaFamiliaDisponibles');
    Route::get('/admin/usuarios/cargarGrillaFamiliasDelUsuario', 'ControladorPermiso@cargarGrillaFamiliasDelUsuario')->name('usuarios.cargarGrillaFamiliasDelUsuario');
    Route::get('/admin/permisos', 'ControladorPermiso@index');
    Route::get('/admin/permisos/cargarGrilla', 'ControladorPermiso@cargarGrilla')->name('permiso.cargarGrilla');
    Route::get('/admin/permiso/nuevo', 'ControladorPermiso@nuevo');
    Route::get('/admin/permiso/cargarGrillaPatentesPorFamilia', 'ControladorPermiso@cargarGrillaPatentesPorFamilia')->name('permiso.cargarGrillaPatentesPorFamilia');
    Route::get('/admin/permiso/cargarGrillaPatentesDisponibles', 'ControladorPermiso@cargarGrillaPatentesDisponibles')->name('permiso.cargarGrillaPatentesDisponibles');
    Route::get('/admin/permiso/{idpermiso}', 'ControladorPermiso@editar');
    Route::post('/admin/permiso/{idpermiso}', 'ControladorPermiso@guardar');

/* --------------------------------------------- */
/* CONTROLADOR GRUPO                             */
/* --------------------------------------------- */
    Route::get('/admin/grupos', 'ControladorGrupo@index');
    Route::get('/admin/usuarios/cargarGrillaGruposDelUsuario', 'ControladorGrupo@cargarGrillaGruposDelUsuario')->name('usuarios.cargarGrillaGruposDelUsuario'); //otra cosa
    Route::get('/admin/usuarios/cargarGrillaGruposDisponibles', 'ControladorGrupo@cargarGrillaGruposDisponibles')->name('usuarios.cargarGrillaGruposDisponibles'); //otra cosa
    Route::get('/admin/grupos/cargarGrilla', 'ControladorGrupo@cargarGrilla')->name('grupo.cargarGrilla');
    Route::get('/admin/grupo/nuevo', 'ControladorGrupo@nuevo');
    Route::get('/admin/grupo/setearGrupo', 'ControladorGrupo@setearGrupo');
    Route::post('/admin/grupo/nuevo', 'ControladorGrupo@guardar');
    Route::get('/admin/grupo/{idgrupo}', 'ControladorGrupo@editar');
    Route::post('/admin/grupo/{idgrupo}', 'ControladorGrupo@guardar');

/* --------------------------------------------- */
/* CONTROLADOR USUARIO                           */
/* --------------------------------------------- */
    Route::get('/admin/usuarios', 'ControladorUsuario@index');
    Route::get('/admin/usuarios/nuevo', 'ControladorUsuario@nuevo');
    Route::post('/admin/usuarios/nuevo', 'ControladorUsuario@guardar');
    Route::post('/admin/usuarios/{usuario}', 'ControladorUsuario@guardar');
    Route::get('/admin/usuarios/cargarGrilla', 'ControladorUsuario@cargarGrilla')->name('usuarios.cargarGrilla');
    Route::get('/admin/usuarios/buscarUsuario', 'ControladorUsuario@buscarUsuario');
    Route::get('/admin/usuarios/{usuario}', 'ControladorUsuario@editar');

/* --------------------------------------------- */
/* CONTROLADOR MENU                             */
/* --------------------------------------------- */
    Route::get('/admin/sistema/menu', 'ControladorMenu@index');
    Route::get('/admin/sistema/menu/nuevo', 'ControladorMenu@nuevo');
    Route::post('/admin/sistema/menu/nuevo', 'ControladorMenu@guardar');
    Route::get('/admin/sistema/menu/cargarGrilla', 'ControladorMenu@cargarGrilla')->name('menu.cargarGrilla');
    Route::get('/admin/sistema/menu/eliminar', 'ControladorMenu@eliminar');
    Route::get('/admin/sistema/menu/{id}', 'ControladorMenu@editar');
    Route::post('/admin/sistema/menu/{id}', 'ControladorMenu@guardar');

});

/* --------------------------------------------- */
/* CONTROLADOR PATENTES                          */
/* --------------------------------------------- */
Route::get('/admin/patentes', 'ControladorPatente@index');
Route::get('/admin/patente/nuevo', 'ControladorPatente@nuevo');
Route::post('/admin/patente/nuevo', 'ControladorPatente@guardar');
Route::get('/admin/patente/cargarGrilla', 'ControladorPatente@cargarGrilla')->name('patente.cargarGrilla');
Route::get('/admin/patente/eliminar', 'ControladorPatente@eliminar');
Route::get('/admin/patente/nuevo/{id}', 'ControladorPatente@editar');
Route::post('/admin/patente/nuevo/{id}', 'ControladorPatente@guardar');


/* --------------------------------------------- */
/* CONTROLADOR Clientes                          */
/* --------------------------------------------- */
Route::get('/admin/cliente/nuevo', 'ControladorCliente@nuevo');
Route::get('/admin/clientes', 'ControladorCliente@index');
Route::post('/admin/cliente/nuevo', 'ControladorCliente@guardar');
Route::get('/admin/clientes/CargarGrilla', 'ControladorCliente@cargarGrilla')->name('cliente.cargarGrilla');
Route::get('/admin/cliente/eliminar', 'ControladorCliente@eliminar');
Route::get('/admin/cliente/{id}', 'ControladorCliente@editar');
Route::post('/admin/cliente/{id}', 'ControladorCliente@guardar');

/* --------------------------------------------- */
/* CONTROLADOR Productos                          */
/* --------------------------------------------- */
Route::get('/admin/producto/nuevo', 'ControladorProducto@nuevo');
Route::get('/admin/productos', 'ControladorProducto@index');
Route::post('/admin/producto/nuevo', 'ControladorProducto@guardar');
Route::get('/admin/productos/CargarGrilla', 'ControladorProducto@cargarGrilla')->name('producto.cargarGrilla');
Route::get('/admin/producto/eliminar', 'ControladorProducto@eliminar');
Route::get('/admin/producto/editarPrecio', 'ControladorProducto@editarPrecio')->name('producto.editarPrecio');
Route::get('/admin/producto/editarPrecioCategoria', 'ControladorProducto@editarPrecioCategoria')->name('producto.editarPrecioCategoria');
Route::get('/admin/producto/{id}', 'ControladorProducto@editar');
Route::post('/admin/producto/{id}', 'ControladorProducto@guardar');

Route::post('/subir-precios', [ControladorProducto::class, 'subirPrecios'])->name('subir.precios');
Route::post('/subir-precios-categoria', 'ControladorProducto@subirPreciosCategoria')->name('subir.productos.categoria');

/* --------------------------------------------- */
/* CONTROLADOR Pedidos                          */
/* --------------------------------------------- */
use App\Http\Controllers\BoletaController;
Route::get('/admin/pedido/nuevo', 'ControladorPedido@nuevo');
Route::get('/admin/pedidos', 'ControladorPedido@index');
Route::post('/admin/pedido/nuevo', 'ControladorPedido@guardar');
Route::get('/admin/pedidos/CargarGrilla', 'ControladorPedido@cargarGrilla')->name('pedido.cargarGrilla');
Route::get('/admin/pedido/eliminar', 'ControladorPedido@eliminar');
Route::get('/admin/pedido/{id}', 'ControladorPedido@editar');
Route::get('/admin/pedido/boleta/{id}', 'ControladorPedido@generarBoleta');
Route::get('/generar-boleta/{idPedido}', [BoletaController::class, 'generarBoleta'])->name('generar.boleta');
Route::post('/admin/pedido/{id}', 'ControladorPedido@guardar');
/* --------------------------------------------- */
/* CONTROLADOR Postulaciones                          */
/* --------------------------------------------- */
Route::get('/admin/postulacion/nuevo', 'ControladorPostulacion@nuevo');
Route::get('/admin/postulaciones', 'ControladorPostulacion@index');
Route::post('/admin/postulacion/nuevo', 'ControladorPostulacion@guardar');
Route::get('/admin/postulaciones/CargarGrilla', 'ControladorPostulacion@cargarGrilla')->name('postulacion.cargarGrilla');
Route::get('/admin/postulacion/eliminar', 'ControladorPostulacion@eliminar');
Route::get('/admin/postulacion/{id}', 'ControladorPostulacion@editar');
Route::post('/admin/postulacion/{id}', 'ControladorPostulacion@guardar');

/* --------------------------------------------- */
/* CONTROLADOR Sucursales                          */
/* --------------------------------------------- */
Route::get('/admin/sucursal/nuevo', 'ControladorSucursal@nuevo');
Route::get('/admin/sucursales', 'ControladorSucursal@index');
Route::post('/admin/sucursal/nuevo', 'ControladorSucursal@guardar');
Route::get('/admin/sucursales/CargarGrilla', 'ControladorSucursal@cargarGrilla')->name('sucursal.cargarGrilla');
Route::get('/admin/sucursal/eliminar', 'ControladorSucursal@eliminar');
Route::get('/admin/sucursal/{id}', 'ControladorSucursal@editar');
Route::post('/admin/sucursal/{id}', 'ControladorSucursal@guardar');
/* --------------------------------------------- */
/* CONTROLADOR Categorias                          */
/* --------------------------------------------- */
Route::get('/admin/categoria/nuevo', 'ControladorCategoria@nuevo');
Route::get('/admin/categorias', 'ControladorCategoria@index');
Route::post('/admin/categoria/nuevo', 'ControladorCategoria@guardar');
Route::get('/admin/categorias/CargarGrilla', 'ControladorCategoria@cargarGrilla')->name('categoria.cargarGrilla');
Route::get('/admin/categoria/eliminar', 'ControladorCategoria@eliminar');
Route::get('/admin/categoria/{id}', 'ControladorCategoria@editar');
Route::post('/admin/categoria/{id}', 'ControladorCategoria@guardar');

/* --------------------------------------------- */
/* CONTROLADOR Estados                          */
/* --------------------------------------------- */
Route::get('/admin/estado/nuevo', 'ControladorEstado@nuevo');
Route::get('/admin/estados', 'ControladorEstado@index');
Route::post('/admin/estado/nuevo', 'ControladorEstado@guardar');
Route::get('/admin/estados/CargarGrilla', 'ControladorEstado@cargarGrilla')->name('estado.cargarGrilla');
Route::get('/admin/estado/eliminar', 'ControladorEstado@eliminar');
Route::get('/admin/estado/{id}', 'ControladorEstado@editar');
Route::post('/admin/estado/{id}', 'ControladorEstado@guardar');

/* --------------------------------------------- */
/* CONTROLADOR Proveedores                          */
/* --------------------------------------------- */

Route::get('/admin/proveedor/nuevo', 'ControladorProveedor@nuevo');
Route::get('/admin/proveedores', 'ControladorProveedor@index');
Route::post('/admin/proveedor/nuevo', 'ControladorProveedor@guardar');
Route::get('/admin/proveedores/CargarGrilla', 'Controladorproveedor@cargarGrilla')->name('proveedor.cargarGrilla');
Route::get('/admin/proveedor/eliminar', 'Controladorproveedores@eliminar');
Route::get('/admin/proveedor/{id}', 'Controladorproveedor@editar');
Route::post('/admin/proveedor/{id}', 'Controladorproveedor@guardar');

/* --------------------------------------------- */
/* CONTROLADOR Compras                          */
/* --------------------------------------------- */

Route::get('/admin/compra/nuevo', 'ControladorCompra@nuevo');
Route::get('/admin/compras', 'ControladorCompra@index');
Route::post('/admin/compra/nuevo', 'ControladorCompra@guardar');
Route::get('/admin/compras/CargarGrilla', 'ControladorCompra@cargarGrilla')->name('compra.cargarGrilla');
Route::get('/admin/compra/eliminar', 'ControladorCompra@eliminar');
Route::get('/admin/compra/{id}', 'ControladorCompra@editar');
Route::post('/admin/compra/{id}', 'ControladorCompra@guardar');

