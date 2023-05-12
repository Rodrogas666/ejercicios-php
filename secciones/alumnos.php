<?php

include_once '../configuraciones/bd.php';
$conexionBD = BD::crearInstancia();

$id = isset($_POST['id']) ? $_POST['id'] : '';
$nombre_alumno = isset($_POST['nombre']) ? $_POST['nombre'] : '';
$apellidos_alumno = isset($_POST['apellidos']) ? $_POST['apellidos'] : '';

$cursos = isset($_POST['cursos']) ? $_POST['cursos'] : '';
$accion = isset($_POST['accion']) ? $_POST['accion'] : '';

// print_r($_POST);


if ($accion != ''){
    switch ($accion) {
        case 'agregar':
            $sql = "INSERT INTO alumnos (id, nombre, apellidos) VALUES (NULL, :nombre_alumno, :apellidos_alumno)";
            $consulta = $conexionBD->prepare($sql);
            $consulta->bindParam(':nombre_alumno', $nombre_alumno);
            $consulta->bindParam(':apellidos_alumno', $apellidos_alumno);
            $consulta->execute();
            
            $idAlumno=$conexionBD->lastInsertId(); 

            foreach ($cursos as $curso) {
                $sql = "INSERT INTO alumnos_cursos (id, id_alumno, id_curso) VALUES (NULL, :id_alumno, :id_curso)";
                $consulta=$conexionBD->prepare($sql);
                $consulta->bindParam(':id_alumno', $idAlumno);
                $consulta->bindParam(':id_curso', $curso);
                $consulta->execute();
            }


            break;

        case 'editar':
            $sql = "UPDATE alumnos SET nombre=:nombre_alumno, apellidos=:apellidos_alumno  WHERE id=:id";
            $consulta=$conexionBD->prepare($sql);
            $consulta->bindParam(':id', $id);
            $consulta->bindParam(':nombre_alumno', $nombre_alumno);
            $consulta->bindParam(':apellidos_alumno', $apellidos_alumno);
            $consulta->execute();
            echo $sql;
            
            if (isset($cursos)) {
                $sql = "DELETE FROM alumnos_cursos WHERE id_alumno = :id_alumno";
                $consulta = $conexionBD->prepare($sql);
                $consulta->bindParam(':id_alumno', $id);
                $consulta->execute();

                foreach ($cursos as $curso) {
                    $sql = "INSERT INTO alumnos_cursos (id, id_alumno, id_curso) VALUES (NULL, :id_alumno, :id_curso)";
                    $consulta = $conexionBD->prepare($sql);
                    $consulta->bindParam(':id_alumno', $id);
                    $consulta->bindParam(':id_curso', $curso);
                    $consulta->execute();
                }

                $arregloCursos = $cursos;
            }

            break;

        case 'borrar':
            $sql = "DELETE FROM alumnos WHERE id=:id";
            $consulta=$conexionBD->prepare($sql);
            $consulta->bindParam(':id', $id);
            $consulta->execute();

            break;

        case 'Seleccionar':
            $sql = "SELECT * FROM alumnos WHERE id=:id";
            $consulta = $conexionBD->prepare($sql);
            $consulta->bindParam(':id', $id);
            $consulta->execute();
            $alumno=$consulta->fetch(PDO::FETCH_ASSOC);

            $nombre_alumno=$alumno['nombre'];
            $apellidos_alumno=$alumno['apellidos'];

            $sql = "SELECT cursos.id FROM alumnos_cursos INNER JOIN cursos ON cursos.id = alumnos_cursos.id_curso WHERE alumnos_cursos.id_alumno=:id_alumno";
            $consulta=$conexionBD->prepare($sql);
            $consulta->bindParam(':id_alumno', $id);
            $consulta->execute();
            $cursosAlumno=$consulta->fetchAll(PDO::FETCH_ASSOC);

            print_r($cursosAlumno);

            foreach ($cursosAlumno as $curso) {
                $arregloCursos[]=$curso['id'];
            }


            break;


        default:
            # code...
            break;
    }
}



$sql="SELECT * FROM alumnos";
$listaAlumnos=$conexionBD->query($sql);
$alumnos=$listaAlumnos->fetchAll();

foreach ($alumnos as $clave => $alumno) {
    
    $sql = "SELECT * FROM cursos
    WHERE id IN (SELECT id_curso FROM alumnos_cursos WHERE id_alumno=:id_alumno)";

    $consulta=$conexionBD->prepare($sql);
    $consulta->bindParam(':id_alumno', $alumno['id']);
    $consulta->execute();
    $cursosAlumno=$consulta->fetchAll();
    $alumnos[$clave]['cursos']=$cursosAlumno;

}

$sql="SELECT * FROM cursos";
$listaCursos=$conexionBD->query($sql);
$cursos=$listaCursos->fetchAll();

// print_r($cursos);




?>