<?php
$crumbs = $this->Html->getCrumbList('', array(
    'text' => '<span class="glyphicon glyphicon-home"></span>',
    'url' => '/',
    'escape' => false
));
?>
<?php if ($crumbs): ?>
<?php echo $crumbs; ?>
</ol>
<?php endif; ?>