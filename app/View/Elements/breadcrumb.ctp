<?php
$crumbs = $this->Html->getCrumbList('', array(
    'text' => '<span class="glyphicon glyphicon-home"></span>',
    'url' => array('controller' => 'pages', 'action' => 'display', 'home'),
    'escape' => false
));
?>
<?php if ($crumbs): ?>
<?php echo $crumbs; ?>
</ol>
<?php endif; ?>