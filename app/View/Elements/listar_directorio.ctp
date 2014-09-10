<table class="table table-responsive table-bordered" id="fileList">
    <thead>
        <tr class='success'>
            <th class='col-md-11'>Nombre del archivo</th>
            <th class='col-md-1'>Acciones</th>
        </tr>
    </thead>
    <tbody>
    <?php
        $ruta = "/files/proyectos/".$proyecto_id."/";
        $directorio = opendir(WWW_ROOT.$ruta);
        $i=0;
        while ($archivo = readdir($directorio)){
    ?>

    <?php
            if (!is_dir($archivo)):
    ?>
        <tr id='tr_<?= $i++ ?>' >
           <td><?= $archivo ?></td>
           <td class='actions' data="<?= $archivo ?>" id="<?= $proyecto_id ?>">
               <?= $this->Html->link('<span class="glyphicon glyphicon-save"></span>',
                $ruta.$archivo, array("confirm"=>null, "escape"=>false, 'target'=>'_blank',
                    "data-toggle"=>"tooltip", "data-placement"=>"top", "title"=>"Descargar archivo"
                )); ?>
               <?= $this->Html->link('<span class="glyphicon glyphicon-trash"></span>',
                "#delete", array("confirm"=>null, "escape"=>false, 'class'=>'btn_delete',
                    "data-toggle"=>"tooltip", "data-placement"=>"top", "title"=>"Eliminar archivo"
                )); ?>
            </td>
        </tr>
    <?
            endif;
        }
    ?>
    </tbody>
</table>
<div class="modal fade" id="alerta">
<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Mensaje del sistema</h4>
      </div>
      <div class="modal-body">
          <strong>Ocurrio un error al eliminar el archivo. Por favor, refresque la página he intente nuevamente.</strong>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
$(document).ready(function() {

    $('.btn_delete').click(function(){
        //Recogemos la id del contenedor padre
        var parent = $(this).parent().attr('id');
        var capa = $(this).parent().parent().attr('id');
        //alert(capa);
        //Recogemos el valor del servicio
        var archivo = $(this).parent().attr('data');

        var dataString = 'name='+archivo;
        if(confirm('Estas seguro de eliminar este archivo?')){
            $.ajax({
                type: "POST",
                url: "../deleteArchivo/"+parent,
                data: dataString,
                statusCode:{
                    200 : function() { 
                        $('#'+capa).remove().fadeIn('slow');
                    },
                    404: function() { 
                        $('#alerta').modal('show');
                    }
                }
            });    
        }
        
    });                 
});    
</script>