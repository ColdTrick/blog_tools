<?php 

	$widget = $vars["entity"];
	
	// get widget settings
	$count = (int) $widget->blog_count;
	if($count < 1){
		$count = 8;
	}

	// backup context and set
	$old_context = get_context();
	if($widget->view_mode != "preview"){
		set_context("search");
	}
	
	if($widget->view_mode == 'slider')
	{
		set_context("slider");
	}
	
	$options = array(
		"type" => "object",
		"subtype" => "blog",
		"limit" => $count,
		"full_view" => false,
		"pagination" => false,
		"view_type_toggle" => false
	);
	
	if($widget->show_featured == "yes")
	{
		$options["metadata_name_value_pairs"] = array("featured" => true);
	}
	
	
	if($blogs = elgg_list_entities_from_metadata($options))
	{
		if(get_context() == 'slider')
		{
			$blog_entities =  elgg_get_entities_from_metadata($options);
			
			echo '<div class="contentWrapper">
						<div id="widget_blog_items_container">'; 
					echo $blogs;						
				echo "</div>";
			
			echo "<div id='widget_blog_items_navigator'>";
			
				foreach($blog_entities as $key => $blog)
				{
					echo "<span rel='widget_blog_item_" . $blog->getGUID() . "'>" . ($key + 1). "</span>";
				}
				
			?>
			</div>
			<script type="text/javascript">
				function rotateBlogItems(){
					if($("#widget_blog_items_navigator .active").next().length === 0){
						$("#widget_blog_items_navigator>span:first").click();
					} else {
						$("#widget_blog_items_navigator .active").next().click();
					}
				}
			
				$(document).ready(function(){
					$("#widget_blog_items_navigator>span:first").addClass("active");
					var active = $("#widget_blog_items_navigator>span:first").attr("rel");
					$("#" + active).show();
	
					$("#widget_blog_items_navigator span").click(function(){
						$("#widget_blog_items_navigator span.active").removeClass("active");
						$(this).addClass("active");
	
						$("#widget_blog_items_container>div").hide();
						var active = $(this).attr("rel");
						$("#" + active).show();
					});
					
					setInterval (rotateBlogItems, 10000);
		
				});
			</script>
			</div>
			<?php 
		}
		else
		{
			echo $blogs;
		}
	} else {
		echo elgg_view("page_elements/contentwrapper", array("body" => elgg_echo("blog_tools:widgets:index_blog:no_result")));
	}

	// reset context
	set_context($old_context);
?>