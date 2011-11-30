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
	
	$strapline_options = array(
		"default" => elgg_echo("blog_tools:settings:strapline:default"),
		"time" => elgg_echo("blog_tools:settings:strapline:time")
	);
	
	$yesno_options = array(
		"yes" => elgg_echo("option:yes"),
		"no" => elgg_echo("option:no")
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
<h3 class="settings"><?php echo elgg_echo("blog_tools:settings:image"); ?></h3>
<div>
	<?php 
		echo elgg_echo("blog_tools:settings:listing:strapline");
		echo "&nbsp;" . elgg_view("input/pulldown", array("internalname" => "params[listing_strapline]", "options_values" => $strapline_options, "value" => $plugin->listing_strapline));
	?>
</div>
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

<h3 class="settings"><?php echo elgg_echo("blog_tools:settings:other"); ?></h3>
<div>
	<?php 
		echo elgg_echo("blog_tools:settings:advanced_gatekeeper");
		echo "&nbsp;" . elgg_view("input/pulldown", array("internalname" => "params[advanced_gatekeeper]", "options_values" => $yesno_options, "value" => $plugin->advanced_gatekeeper));
		echo "<br />" . elgg_echo("blog_tools:settings:advanced_gatekeeper:description");
	?>
</div>