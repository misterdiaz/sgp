<div class="modal fade" id="uploader">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Subir archivos</h4>
      </div>
      <div class="modal-body">
        <div id="preview" class="thumbnail">
          <a href="#" id="file-select" class="btn btn-default" style="display: none;">Elegir archivo</a>
          <?= $this->Html->image('upload_preview.svg') ?>

        </div>
        <span class="alert alert-info" id="file-info">No hay archivo aún</span>

        <?php
          echo $this->Form->create('Proyecto', array('enctype' => 'multipart/form-data', 'action'=>'addFile'));
          echo $this->Form->file('archivo', array('id'=>'file'));
          echo $this->Form->input('proyecto_id', array('type'=>'hidden', 'value'=>$proyecto_id));
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <?= $this->Form->end(array('label'=>'Guardar', 'div'=>false, "class"=>"btn btn-default")); ?>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->