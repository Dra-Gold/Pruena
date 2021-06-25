<div class="containter">
    <div class="form-row text-center">
        <div class="form-group col-12">
            <h3>Listado Alumnos</h3>
            <hr>
        </div>
    </div>

    <?php  foreach($person as $persona){ ?>
    <div class="card">
        <ul class="list-group list-group-flush">
            <li class="list-group-item">Nombre Alumno : <?php echo $persona->nombre; ?></li>
            <li class="list-group-item">Apellido Paterno : <?php echo $persona->apellido_paterno; ?></li>
            <li class="list-group-item">Apellido Maternno : <?php echo $persona->apellido_materno; ?></li>
            <li class="list-group-item">id_tipo_documento : <?php echo $persona->id_tipo_documento; ?> </li>
            <li class="list-group-item">numero_documento : <?php echo $persona->numero_documento; ?></li>
        </ul>
        <div class="card-footer">
           <h4> Cursos Anotados: </h4>
           <ul class="list-group list-group-flush">
                <?php  foreach($persona->members as $member){ ?>
                    <li class="list-group-item">Nombre : <?php echo $member->curso->nombre; ?></li>
                    <li class="list-group-item">Clases:
                    <?php  foreach($member->curso->classroom as $clase){ ?>
                        <?php   echo $clase->nombre ?>
                        <br>
                    <?php } ?></li>
                <?php } ?>
            </ul>
        </div>
    </div>
        <br>
        <?php } ?>
</div>