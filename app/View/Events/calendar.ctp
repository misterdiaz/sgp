<script type="text/javascript">
$(document).ready(function() {
    $(".calendar_link").fancybox();
    $("#add_link").fancybox({
		'modal2': true
	});
});
</script>
<?php echo $this->html->link(__('Agregar Actividad', true), array('controller'=>'Events','action'=>'add'), array('id'=>'add_link')); ?>
<div class="events" id="calendar_div">
<?php 

	echo $this->Calendar->calendar($year, $month, $data, $base_url);
	
?>
</div>

