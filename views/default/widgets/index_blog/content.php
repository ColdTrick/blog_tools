<?php 

	$widget = $vars["entity"];
	
	// get widget settings
	$count = (int) $widget->blog_count;
	if($count < 1){
		$count = 8;
	}

	// backup context and set
	$old_context = elgg_get_context();
	if($widget->view_mode == 'slider') {
		elgg_set_context("slider");
	} elseif($widget->view_mode != "preview"){
		elgg_set_context("search");
	}
	
	$options = array(
		"type" => "object",
		"subtype" => "blog",
		"limit" => $count,
		"full_view" => false,
		"pagination" => false,
		"view_type_toggle" => false
	);
	
	if($widget->show_featured == "yes") {
		$options["metadata_name_value_pairs"] = array("featured" => true);
	}
	
	
	if($blogs = elgg_list_entities_from_metadata($options)) {
		if($widget->view_mode == 'slider') {
			$blog_entities = elgg_get_entities_from_metadata($options);
			
			echo "<div class='widget_more_wrapper'>";
			
			echo "<div id='blog_tools_widget_items_container_" . $widget->getGUID() . "' class='blog_tools_widget_items_container'>"; 
			echo $blogs;						
			echo "</div>";
			
			echo "<div id='blog_tools_widget_items_navigator_" . $widget->getGUID() . "' class='blog_tools_widget_items_navigator'>";
			
			foreach($blog_entities as $key => $blog) {
				echo "<span rel='blog_tools_blog_" . $blog->getGUID() . "'>" . ($key + 1). "</span>";
			}
			
			echo "</div>";
			
			?>
			<script type="text/javascript">
				function rotateBlogItems<?php echo $widget->getGUID(); ?>(){
					if($("#blog_tools_widget_items_navigator_<?php echo $widget->getGUID(); ?> .active").next().length === 0){
						$("#blog_tools_widget_items_navigator_<?php echo $widget->getGUID(); ?>>span:first").click();
					} else {
						$("#blog_tools_widget_items_navigator_<?php echo $widget->getGUID(); ?> .active").next().click();
					}
				}
			
				$(document).ready(function(){
					$("#blog_tools_widget_items_navigator_<?php echo $widget->getGUID(); ?>>span:first").addClass("active");
					var active = $("#blog_tools_widget_items_navigator_<?php echo $widget->getGUID(); ?>>span:first").attr("rel");
					$("#blog_tools_widget_items_container_<?php echo $widget->getGUID(); ?> #" + active).show();
	
					$("#blog_tools_widget_items_navigator_<?php echo $widget->getGUID(); ?> span").click(function(){
						$("#blog_tools_widget_items_navigator_<?php echo $widget->getGUID(); ?> span.active").removeClass("active");
						$(this).addClass("active");
	
						$("#blog_tools_widget_items_container_<?php echo $widget->getGUID(); ?>>div").hide();
						var active = $(this).attr("rel");
						$("#blog_tools_widget_items_container_<?php echo $widget->getGUID(); ?> #" + active).show();
					});
					
					setInterval (rotateBlogItems<?php echo $widget->getGUID(); ?>, 10000);
				});
			</script>
			<?php
			echo "</div>"; // end widget_more_wrapper
			
		} else {
			echo $blogs;
		}
	} else {
		echo elgg_echo("blog_tools:widgets:index_blog:no_result");
	}

	// reset context
	elgg_set_context($old_context);
	