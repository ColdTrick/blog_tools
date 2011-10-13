<?php
// Set the content type
header("Content-type: text/html; charset=UTF-8");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<?php echo elgg_view('page/elements/head', $vars); ?>
	</head>
	<body>
		<div class="elgg-page-body">
			<div class="elgg-inner">
				<?php echo elgg_view('page/elements/body', $vars); ?>
			</div>
		</div>
	</body>
</html>