<?php
require_once('mysqlibd.php');
error_reporting(E_ALL);
$action = 'adddb';
$data = array();

function printReceptors () {
    global $db;
//recibe el receptor de la base de datos que se conecta más abajo
    $receptor = $db->get ("receptor");
    if ($db->count == 0) {
        echo "<td align=center colspan=4>NO HAY NINGUN RECEPTOR</td>";
        return;
    }
    foreach ($receptor as $r) {
        echo "<tr>
            <td>{$r['id_receptor']}</td>
            <td>{$r['nombre']}</td>
            <td>{$r['colonia']}</td>
            <td>{$r['codigo_postal']}</td>
            <td>{$r['rfc']}</td>
        </tr>";
    }
}
function action_adddb () {
    global $db;

    $data = Array(
        'nombre' => $_POST['nombre'],
        'colonia' => $_POST['colonia'],
        'codigo_postal' => $_POST['codigo_postal'],
        'rfc' => $_POST['rfc'],

    );
    $id = $db->insert ('receptor', $data);
    header ("Location: index.php");
    exit;
}


//Esto comenzará a funcionar cuando la clase mysqlidb este funcionando

/*$db = new mysqlidb ('localhost', 'root', '', 'pruebas');
if ($_GET) {
    $f = "action_".$_GET['action'];
    if (function_exists ($f)) {
        $f();
    }
}*/

?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>RECEPTORES</title>
</head>
<body>

<center>
<h3>Receptores</h3>
<table width='50%'>
    <tr >
        <th>ID</th>
        <th>Nombre</th>
        <th>Colonia</th>
        <th>Codigo Postal</th>
         <th>RFC</th>
    </tr>
    <?php printReceptors();?>

</table>
<hr width=50%>
<form action='index.php?action=<?php echo $action?>' method=post>
    <input type=hidden name='id' >
    <input type=text name='Nombre' >
    <input type=text name='Colonia' >
    <input type=text name='CódigoPostal' >
    <input type=text name='rfc' >
   <!-- <input type=submit value='Nuevo Receptor'></td>!-->
<form>
</table>
</center>
</body>
</html>
