<h2>Solicitud de Vacaciones (días disponibles)</h2> 

<p>El usuario <?= AuthComponent::user('nombre') ?> <?= AuthComponent::user('apellido') ?>, ha solicitado <?= $nro_dias ?> dia(s) de sus vacaciones. Para ser disfrutadas a partir del día: <?= $fecha_desde['day']."/".$fecha_desde['month']."/".$fecha_desde['year'] ?>, teniendo como fecha de incorporación el día: <?= turnFecha($fecha_incorporacion) ?>.</p>

<p>El presente correo confirma que la solicitud fue realizada con éxito y se encuentra registrada en el sistema.</p>

<p><b><a href='http://sgp.fii.gob.ve'>Sistema de Gestión de Proyectos.</b></a></p>