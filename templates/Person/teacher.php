<div class="containter">
    <div class="form-row text-center">  
        <div class="form-group col-12">
            <h3>Listado Cursos con Profesores</h3>
            <hr>
        </div>
    </div>

    <?php  foreach($cursos as $curso){ ?>
        <div class="card">
            <?php echo $curso->nombre; ?>
            <?php  foreach($curso->members as $integrantes){ ?>
                <?php echo $integrantes->id_persona; ?>
                <?php echo $integrantes->perso->nombre; ?>
             <?php } ?>
        </div>
    <?php } ?>
</div>