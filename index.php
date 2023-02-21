<?php 
require_once("clases/claseGenesis.php");

$objeto1 = new Genesis();

$objeto1->encabezado("");


if (isset($_GET["opc"]) )
{
    switch ($_GET["opc"]) {
        case '5': //Agregar
            $objeto1->formularioAgregar();
            break;

        case '1':
        default:
            $objeto1->listarRegistros();

            break;
    }

}else{
    $objeto1->listarRegistros();
}


$objeto1->piedepagina("");

unset($objeto1);


?>

