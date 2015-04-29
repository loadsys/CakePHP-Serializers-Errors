<h2><?php echo __d('json_api_exceptions', $title); ?></h2>
<p class="error">
	<strong><?php echo __d('json_api_exceptions', 'Application Error Code'); ?>: </strong>
	<?php echo h($code); ?>
	<br>

	<strong><?php echo __d('json_api_exceptions', 'Error Message'); ?>: </strong>
	<?php echo h($detail); ?>
	<br>

	<strong><?php echo __d('json_api_exceptions', 'File'); ?>: </strong>
	<?php echo h($error->getFile()); ?>
	<br>

	<strong><?php echo __d('json_api_exceptions', 'Line'); ?>: </strong>
	<?php echo h($error->getLine()); ?>
	<br>

	<strong><?php echo __d('json_api_exceptions', 'HTTP Error Code'); ?>: </strong>
	<?php echo h($status); ?>
	<br>
</p>
<?php
if (extension_loaded('xdebug')) {
	xdebug_print_function_stack();
}
?>
