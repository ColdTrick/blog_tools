<?php

	$widget = $vars["entity"];
	
	$num = (int) $widget->num_display;
	if($num < 1){
		$num = 4;
	}
	
	$noyes_options = array(
		"no" => elgg_echo("option:no"),
		"yes" => elgg_echo("option:yes")
	);
?>
<p>
	<?php 
		echo elgg_echo('blog:numbertodisplay') . ": "; 
		echo elgg_view("input/pulldown", array("options" => range(1, 10), "value" => $num, "internalname" => "params[num_display]"));
	?>
</p>
<p>
	<?php 
		echo elgg_echo('blog_tools:widget:featured') . ": "; 
		echo elgg_view("input/pulldown", array("options_values" => $noyes_options, "value" => $widget->show_featured, "internalname" => "params[show_featured]"));
	?>
</p>