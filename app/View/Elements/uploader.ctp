<div id="preview" class="thumbnail">
    <a href="#" id="file-select" class="btn btn-default" style="display: none;">Elegir archivo</a>
    <?= $this->Html->image('new/upload_preview.svg') ?>

</div>
<span class="alert alert-info" id="file-info">No hay archivo aún</span>

<form id="file-submit" enctype="multipart/form-data">
    <input id="file" name="file" type="file">
</form>