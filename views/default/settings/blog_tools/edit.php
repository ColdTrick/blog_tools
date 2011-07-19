<?php
	
	$plugin = $vars["entity"];
	
	// define possible values
	$align_options = array(
		"none" => elgg_echo("blog_tools:settings:align:none"),
		"left" => elgg_echo("blog_tools:settings:align:left"),
		"right" => elgg_echo("blog_tools:settings:align:right"),
	);
	
	$size_options = array(
		"tiny" => elgg_echo("blog_tools:settings:size:tiny"),
		"small" => elgg_echo("blog_tools:settings:size:small"),
		"medium" => elgg_echo("blog_tools:settings:size:medium"),
		"large" => elgg_echo("blog_tools:settings:size:large"),
	);
	
	// get settings
	$listing_align = $plugin->listing_align;
	$listing_size = $plugin->listing_size;
	$full_align = $plugin->full_align;
	$full_size = $plugin->full_size;
	
	// make default settings
	if(empty($listing_align)) {
		$listing_align = "left";
	}
	
	if(empty($listing_size)) {
		$listing_size = "small";
	}
	
	if(empty($full_align)) {
		$full_align = "right";
	}
	
	if(empty($full_size)) {
		$full_size = "large";
	}
?>
<div>
	<?php 
		echo elgg_echo("blog_tools:settings:listing:image_align");
		echo "&nbsp;" . elgg_view("input/pulldown", array("internalname" => "params[listing_align]", "options_values" => $align_options, "value" => $listing_align));
	?>
</div>
<div>
	<?php 
		echo elgg_echo("blog_tools:settings:listing:image_size");
		echo "&nbsp;" . elgg_view("input/pulldown", array("internalname" => "params[listing_size]", "options_values" => $size_options, "value" => $listing_size));
	?>
</div>
<div>
	<?php 
		echo elgg_echo("blog_tools:settings:full:image_align");
		echo "&nbsp;" . elgg_view("input/pulldown", array("internalname" => "params[full_align]", "options_values" => $align_options, "value" => $full_align));
	?>
</div>
<div>
	<?php 
		echo elgg_echo("blog_tools:settings:full:image_size");
		echo "&nbsp;" . elgg_view("input/pulldown", array("internalname" => "params[full_size]", "options_values" => $size_options, "value" => $full_size));
	?>
</div>