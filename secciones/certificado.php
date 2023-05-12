<?php


require('../librerias/fpdf/fpdf.php');

include_once("../configuraciones/bd.php");
$conexionBD = BD::crearInstancia();

print_r($_GET);
$id_curso = isset($_GET['id_curso']) ? $_GET['id_curso'] : '';
$id_alumno = isset($_GET['id_alumno']) ? $_GET['id_alumno'] : '';

$sql = "SELECT alumnos.nombre, alumnos.apellidos, cursos.nombre_curso FROM alumnos, cursos WHERE alumnos.id = :id_alumno and cursos.id = :id_curso";
$consulta = $conexionBD->prepare($sql);
$consulta->bindParam(':id_alumno', $id_alumno);
$consulta->bindParam(':id_curso', $id_curso);
$consulta->execute();
$alumno = $consulta->fetch(PDO::FETCH_ASSOC);
print_r($alumno);


// $pdf = new FPDF();
// $pdf->AddPage();
// $pdf->SetFont('Arial','B',16);
// $pdf->Cell(40,10,'¡Hola, Mundo!');
// $pdf->Output();


?>