<div class="modal fade" id="message">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Mensaje del sistema</h3>
      </div>
      <div class="modal-body">
      <p class="lead">
      <?php
        $msj_auth = $this->Session->flash('auth');
        $msj_flash = $this->Session->flash('flash');
        echo "<ul class='list-group'>";
          if(!empty($msj_flash)) echo "<li class='list-group-item list-group-item-info'>", $msj_flash, "</li>";
          if(!empty($msj_auth)) echo "<li class='list-group-item list-group-item-warning'>", $msj_auth, "</li>";
        echo "</ul>";
        echo $this->Session->flash('flash');
        if(!empty($msj_auth) || !empty($msj_flash)):
      ?>
        <script>
        $(function() {
                $( "#message" ).modal();
        });
        </script>
      <?
        endif;
       ?>
       </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->