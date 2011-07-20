<?php

	/**
	 * Elgg blog individual post view
	 * 
	 * @package ElggBlog
	 * @uses $entity Optionally, the blog post to view
	 */
		if (isset($vars["entity"]) && ($vars["entity"] instanceof ElggObject)) {
			$entity = $vars["entity"];
			$full_view = $vars["full"];
			
			// get icon settings
			if($full_view){
				$icon_align = get_plugin_setting("full_align", "blog_tools");
				$icon_size = get_plugin_setting("full_size", "blog_tools");
				
				if(empty($icon_align)){
					$icon_align = "right";
				}
				
				if(empty($icon_size)){
					$icon_size = "large";
				}
			} else {
				$icon_align = get_plugin_setting("listing_align", "blog_tools");
				$icon_size = get_plugin_setting("listing_size", "blog_tools");
				
				if(empty($icon_align)){
					$icon_align = "left";
				}
				
				if(empty($icon_size)){
					$icon_size = "small";
				}
			}
			
			// show icon
			if(!empty($entity->icontime) && ($icon_align != "none")) {
				$show_icon = true;
			} else {
				$show_icon = false;
			}
			
			//display comments link?
			if ($entity->comments_on == 'Off') {
				$comments_on = false;
			} else {
				$comments_on = true;
			}
			
			if ((get_context() == "search")) {
				
				//display the correct layout depending on gallery or list view
				if (get_input('search_viewtype') == "gallery") {
					//display the gallery view
            		echo elgg_view("blog/gallery", $vars);
				} else {
					echo elgg_view("blog/listing", $vars);
				}
			} else {
			
				$url = $entity->getURL();
				$owner = $entity->getOwnerEntity();
				$canedit = $entity->canEdit();
?>
<div class="contentWrapper singleview">
	
	<div class="blog_post">
		<?php 
			$icon_class = "";
			$info_class = "";
			
			if($show_icon){
				if($icon_align == "right"){
					$icon_class = "blog_tools_blog_image_right";
					$info_class = "blog_tools_blog_info_right";
				}
				echo "<div class='blog_tools_blog_image " . $icon_class . "'><img src='" . $vars["entity"]->getIcon($icon_size) . "'></div>";
			}
		?>
		<h3><?php echo elgg_view("output/url", array("href" => $url, "text" => $entity->title)); ?></h3>
		<?php 
			if($full_view){ 
		?>
			<div class="blog_tools_info_wrapper <?php echo $info_class; ?>">
				<div class="blog_post_icon">
			    <?php
			        echo elgg_view("profile/icon",array('entity' => $owner, 'size' => 'tiny'));
				?>
		    	</div>
		    	
				<p class="strapline">
					<?php
		                
						echo sprintf(elgg_echo("blog:strapline"),
										date("F j, Y", $entity->time_created)
						);
						
						echo "&nbsp;" . elgg_echo('by');
						echo "&nbsp;" . elgg_view("output/url", array("href" => $vars["url"] . "pg/blog/owner/" . $owner->username, "text" => $owner->name));
						
						if($comments_on){
				        	//get the number of comments
				    		$num_comments = elgg_count_comments($entity);
				    		
				    		echo "&nbsp;" . elgg_view("output/url", array("href" => $url, "text" => elgg_echo("comments") . " (" . $num_comments . ")"));
				    	}
			    	?>
				</p>
				<!-- display tags -->
				<?php
	
					$tags = elgg_view('output/tags', array('tags' => $entity->tags));
					if (!empty($tags)) {
						echo '<p class="tags">' . $tags . '</p>';
					}
				
					$categories = elgg_view('categories/view', $vars);
					if (!empty($categories)) {
						$cat_class = "";
						if(!empty($tags)){
							echo ",&nbsp;";
						} else {
							$cat_class = "blog_tools_categories_no_tags";
						}
						echo "<p class='categories " . $cat_class . "'>" . $categories . "</p>";
					}
				
				?>
			</div>
		<?php
		}
		?>
			
		<!-- display the actual blog post -->
		<?php
			// see if we need to display the full post or just an excerpt
			if ($full_view) {
				echo $entity->description;
				echo "<div class='clearfloat'></div>";
			} else {
				$body = date("F j, Y", $entity->time_created) . " - ";
				$body .= elgg_get_excerpt($entity->description, 450);
				
				// add a "read more" link if cropped.
				if (elgg_substr($body, -3, 3) == '...') {
					$body .= "&nbsp;" . elgg_view("output/url", array("href" => $entity->getURL(), "text" => strtolower(elgg_echo('more'))));
				}
				
				echo $body;
				echo "<div class='clearfloat'></div>";
			}
		
		?>
		<div class="clearfloat"></div>			
		
		<?php
			if ($canedit) {
				// display edit options if it is the blog post owner
				echo "<p class='options'>";
				 
				echo elgg_view("output/url", array("href" => $vars["url"] . "pg/blog/edit/" . $vars["entity"]->getGUID(), "text" => elgg_echo("edit")));
				
				echo "&nbsp;&nbsp;&nbsp;&nbsp;";
				
				echo elgg_view("output/confirmlink", array(
					'href' => $vars['url'] . "action/blog/delete?blogpost=" . $entity->getGUID(),
					'text' => elgg_echo('delete'),
					'confirm' => elgg_echo('deleteconfirm'),
				));

				// Allow the menu to be extended
				echo elgg_view("editmenu",array('entity' => $entity));
				
				echo "</p>";
			}

			if($full_view){
				// Add This view
				echo elgg_view("addthis/extend");
			}
		?>
	</div>
</div>

<?php
				
		}

	}
