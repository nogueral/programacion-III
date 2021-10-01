<?php
include "./clases/usuario.php";
include "./clases/producto.php";
include "./clases/venta.php";

if(isset($_GET["opcion"]))
{
    switch ($_GET["opcion"]) {
        case 'A':
            /*A - Obtener los detalles completos de todos los usuarios y poder ordenarlos
            alfabéticamente de forma ascendente o descendente. */
            Usuario::ArmarListaBD(Usuario::TraerTodosLosUsuariosOrdenados($_GET["value-1"]));
            break;
        case 'B':
            /*B. Obtener los detalles completos de todos los productos y poder ordenarlos
            alfabéticamente de forma ascendente y descendente. */
            Producto::ArmarLista(Producto::TraerTodosLosProductosOrdenados($_GET["value-1"]));
            break;
        case 'C':
            /*C. Obtener todas las compras filtradas entre dos cantidades. */
            Venta::ArmarLista(Venta::TraerTodasLasVentasPorCantidad($_GET["value-1"], $_GET["value-2"]));
            break;
        case 'D':
            /*D. Obtener la cantidad total de todos los productos vendidos entre dos fechas. */
            var_dump(Producto::StockTotalPorFechas($_GET["value-1"], $_GET["value-2"]));
            break;
        case 'E':
            /*E. Mostrar los primeros “N” números de productos que se han enviado. */
            Producto::ArmarLista(Producto::TraerProductos($_GET["value-1"]));
            break;
        case 'F':
            /*F. Mostrar los nombres del usuario y los nombres de los productos de cada venta. */
            var_dump(Venta::MostrarNombres());
            break;
        case 'G':
            /*G. Indicar el monto (cantidad * precio) por cada una de las ventas.*/
            var_dump(Venta::MontoPorVenta());
            break;
        case 'H':
            /*H. Obtener la cantidad total de un producto (ejemplo:1003) vendido por un usuario
            (ejemplo: 104).*/
            var_dump(Venta::CantidadTotalPorUsuario($_GET["value-1"], $_GET["value-2"]));
            break;
        case 'I':
            /*I. Obtener todos los números de los productos vendidos por algún usuario filtrado por
            localidad (ejemplo: ‘Avellaneda’).*/
            var_dump(Venta::ProductosPorLocalidad($_GET["value-1"]));
            break;
        case 'J':
            /*J. Obtener los datos completos de los usuarios filtrando por letras en su nombre o
            apellido.*/
            Usuario::ArmarListaBD(Usuario::FiltrarUsuariosPorNombre($_GET["value-1"]));
            break;
        case 'K':
            /*K. Mostrar las ventas entre dos fechas del año.*/
            Venta::ArmarLista(Venta::VentasEntreDosFechas($_GET["value-1"], $_GET["value-2"]));
            break;
        default:
            echo "No existe listado";
            break;
    }
}

?>