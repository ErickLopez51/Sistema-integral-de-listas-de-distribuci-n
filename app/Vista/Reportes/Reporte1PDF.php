<?php 

require_once('../Public/mpdf/vendor/autoload.php');
        //OBTENER FECHA ACTUAL
date_default_timezone_set('America/Mexico_City');
$fecha_actual = date('d-m-Y');

$html='
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Reporte de Estatus Correo '.$fecha_actual.'.pdf</title>
<link rel="stylesheet" href="../Public/mpdf/Plantilla/style.css" media="all" />
<link rel="shortcut icon" type="image/x-icon" href="../Public/img/favicon.ico">
</head>
<body>
<header class="clearfix">
<div>
<img id="logo"  src="../Public/mpdf/Plantilla/logo2019.png">
</div>
<div id="project" class="clearfix"> 
<h1 class="name">SISTEMA DE LISTAS DE DISTRIBUCIÓN DEL IMTA</h1>
<h3>Administrador del sistema</h3>
<div class="address" ><b>Ext:</b> 878</div>
<div class="address"><b>Edificio:</b>  No.4</div>
<div class="email"><b>Correo electronico:</b> <a href="mailto:siad@tlaloc.imta.mx?Subject=Hello%20again" target="_top">mesa_ayuda@tlaloc.imta.mx</a></div>
<div class="date"><b>Fecha:</b> '.$fecha_actual.'</div>';

$html .='<h4>Lista de los estatus de correo.</h4>
</div>
</header>
<main>
<table border="0" cellspacing="0" cellpadding="0">
<thead>
<tr>
<th class="desc">Seguimiento correo</th>
<th class="qty">Porcentaje</th>
<th class="unit">Cantidad total</th>
</tr>
</thead>';
$total=0;
foreach ($datosCorreo as $datos) {
	$html .='<tbody>
	<tr>
	<td class="desc"><h3>'.$datos['estatus'].'</h3></td>
	<td class="qty">'.$datos['porcentaje'].'</td>
	<td class="unit">'.$datos['total'].'</td>

	</tr>';
	$total=$datos['total']+$total;
}
$html .='
</tbody>
<tfoot>
<tr>
<td colspan="0"></td>
<td colspan="0">Total de seguimientos</td>
<td>'.$total.'</td>
</tr>
</tfoot>
</table>
</main>
<footer>
<div class="container my-auto">
<div class="copyright text-center my-auto">
<span>Copyright &copy; 2019 <a href="https://www.gob.mx/imta">Instituto Mexicano de Tecnología del Agua (IMTA)</a></span>
</div>
</div>
</footer>
</body>
</html>
';





$mpdf = new \Mpdf\Mpdf([

]); 
$mpdf->writeHTML($html);

$css=file_get_contents('../Public/pdf/style.css');
$mpdf->writeHTML($css,1);

$mpdf->Output('Reporte de Estatus Correo '.$fecha_actual.'.pdf','I');
?>