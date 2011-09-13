<?php 

	$widget = $vars["entity"];
	
	$count = (int) $widget->blog_count;
	if($count < 1){
		$count = 8;
	}
	
	$view_mode_options_values = array(
		"list" => elgg_echo("blog_tools:widgets:index_blog:view_mode:list"),
		"preview" => elgg_echo("blog_tools:widgets:index_blog:view_mode:preview"),
		"slider" => elgg_echo("blog_tools:widgets:index_blog:view_mode:slider")
	);
	
	$noyes_options = array(
			"no" => elgg_echo("option:no"),
			"yes" => elgg_echo("option:yes")
	);

?>
<div><?php echo elgg_echo("blog_tools:widgets:index_blog:blog_count"); ?></div>
<input type="text" name="params[blog_count]" value="<?php echo elgg_view("output/text", array("value" => $count)); ?>" size="4" maxlength="4" />

<div><?php echo elgg_echo("blog_tools:widgets:index_blog:view_mode"); ?></div>
<?php echo elgg_view("input/pulldown", array("internalname" => "params[view_mode]", "options_values" => $view_mode_options_values, "value" => $widget->view_mode)); ?>

<div><?php echo elgg_echo('blog_tools:widget:featured') . ": "; ?></div> 
<?php echo elgg_view("input/pulldown", array("options_values" => $noyes_options, "value" => $widget->show_featured, "internalname" => "params[show_featured]")); ?>