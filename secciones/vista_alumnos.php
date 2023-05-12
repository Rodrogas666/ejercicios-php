<?php include('../templates/header.php'); ?>
<?php include('alumnos.php'); ?>

<div class="row">
    <div class="col-5">
        <form action="" method="post">
            <div class="card">
                <div class="card-header">
                    Alumnos
                </div>
                <div class="card-body">
                    <div class="mb-3">
                      <label for="id" class="form-label">ID</label>
                      <input type="text"
                        class="form-control" 
                        name="id" 
                        id="id" 
                        value="<?php echo $id?>"
                        aria-describedby="helpId" 
                        placeholder="ID">
                    </div>

                    <div class="mb-3">
                      <label for="nombre" class="form-label">Nombre</label>
                      <input type="text"
                        class="form-control" 
                        name="nombre" 
                        id="nombre" 
                        value="<?php echo $nombre_alumno?>"
                        aria-describedby="helpId" 
                        placeholder="Escriba el nombre">
                    </div>

                    <div class="mb-3">
                      <label for="apellidos" class="form-label">Apellidos</label>
                      <input type="text"
                        class="form-control" 
                        name="apellidos" 
                        id="apellidos" 
                        value="<?php echo $apellidos_alumno?>"
                        aria-describedby="helpId" 
                        placeholder="Escriba los apellidos">
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Curso del alumno</label>
                        <select multiple class="form-select form-select-lg" name="cursos[]" id="listaCursos">

                            <?php foreach ($cursos as $curso) { ?>
                                <option 
                                <?php
                                if (!empty($arregloCursos)):
                                    if(in_array($curso['id'], $arregloCursos)):
                                        echo 'selected';
                                    endif;
                                endif;
                                ?>
                                value=" <?php echo $curso['id']; ?> "> 
                                <?php echo $curso['id']; ?> - <?php echo $curso['nombre_curso']; ?> 
                                </option>
                            <?php } ?>

                        </select>
                    </div>

                    <div class="btn-group" role="group" aria-label="Button group name">
                        <button type="sumbit" name="accion" value="agregar" class="btn btn-success">Agregar</button>
                        <button type="submit" name="accion" value="editar" class="btn btn-warning">Editar</button>
                        <button type="submit" name="accion" value="borrar" class="btn btn-danger">Borrar</button>
                    </div>

                </div>
            </div>
        </form>
    </div>
    <div class="col-7">
        <div class="table-responsive">
            <table class="table table-primary">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($alumnos as $alumno) { ?>
                    <tr class="">
                        
                            
                        <td><?php echo $alumno['id'] ?></td>
                        <td>
                            <?php echo $alumno['nombre'] ?> <?php echo $alumno['apellidos']; ?>

                            <?php
                            foreach ($alumno['cursos'] as $curso) { ?>
                                <br>
                                - <a href="certificado.php?id_curso=<?php echo $curso['id']; ?>$id_alumno=<?php echo $alumno['id'] ?>"> 
                                <i class="bi bi-filetype-pdf text-danger"></i>  <?php echo $curso['nombre_curso']; ?> </a>
                                
                            <?php } ?> 
                        </td>


                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="id" id="id" value="<?php echo $alumno['id']?>" />
                                <input type="submit" value="Seleccionar" name="accion" class="btn btn-info" />
                            </form>
                        </td>   
                         
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

<script>

    new TomSelect('#listaCursos')
</script>

<?php include('../templates/footer.php'); ?>