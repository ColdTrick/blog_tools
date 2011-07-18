<?php

	/**
	 * Elgg blog individual post view
	 * 
	 * @package ElggBlog
	 * @uses $vars['entity'] Optionally, the blog post to view
	 */
		if (isset($vars['entity'])) {
			
			//display comments link?
			if ($vars['entity']->comments_on == 'Off') {
				$comments_on = false;
			} else {
				$comments_on = true;
			}
			
			if (get_context() == "search" && $vars['entity'] instanceof ElggObject) {
				
				//display the correct layout depending on gallery or list view
				if (get_input('search_viewtype') == "gallery") {
					//display the gallery view
            		echo elgg_view("blog/gallery",$vars);

				} else {
					echo elgg_view("blog/listing",$vars);
				}
			} else {
			
				if ($vars['entity'] instanceof ElggObject) {
					
					$url = $vars['entity']->getURL();
					$owner = $vars['entity']->getOwnerEntity();
					$canedit = $vars['entity']->canEdit();
					
				} else {
					
					$url = 'javascript:history.go(-1);';
					$owner = $vars['user'];
					$canedit = false;
					
				}
?>
	<div class="contentWrapper singleview">
	
	<div class="blog_post">
		<?php 
			if($vars["entity"]->icontime && ($vars['full'] != "yes")){
				echo "<div style='float: left; margin: 5px; padding: 5px; border: 1px solid #CECECE;'><img src='" . $vars["entity"]->getIcon("medium") . "'></div>"; 
			}
		?>
		<h3><a href="<?php echo $url; ?>"><?php echo $vars['entity']->title; ?></a></h3>
		<?php if($vars["full"] == "yes"){ ?>
		<div class="blog_post_icon">
		    <?php
		        echo elgg_view("profile/icon",array('entity' => $owner, 'size' => 'tiny'));
			?>
	    </div>
			<p class="strapline">
				<?php
	                
					echo sprintf(elgg_echo("blog:strapline"),
									date("F j, Y", $vars['entity']->time_created)
					);
				
				?>
				<?php echo elgg_echo('by'); ?> <a href="<?php echo $vars['url']; ?>pg/blog/owner/<?php echo $owner->username; ?>"><?php echo $owner->name; ?></a> &nbsp;
				<!-- display the comments link -->
				<?php
					if($comments_on && $vars['entity'] instanceof ElggObject){
			        //get the number of comments
			    		$num_comments = elgg_count_comments($vars['entity']);
			    ?>
			    	<a href="<?php echo $url; ?>"><?php echo sprintf(elgg_echo("comments")) . " (" . $num_comments . ")"; ?></a><br />
			    <?php
		    		}
		    	?>
			</p>
			<!-- display tags -->
				<?php
	
					$tags = elgg_view('output/tags', array('tags' => $vars['entity']->tags));
					if (!empty($tags)) {
						echo '<p class="tags">' . $tags . '</p>';
					}
				
					$categories = elgg_view('categories/view', $vars);
					if (!empty($categories)) {
						echo '<p class="categories">' . $categories . '</p>';
					}
				
				?>
				<div class="clearfloat"></div>
		<?php
		}
			
			?>
			
			<!-- display the actual blog post -->
				<?php
					// see if we need to display the full post or just an excerpt
					if (!isset($vars['full']) || (isset($vars['full']) && $vars['full'] != FALSE)) {
						echo $vars['entity']->description;
						echo "<div class='clearfloat'></div>";
					} else {
						$body = date("F j, Y", $vars['entity']->time_created) . " - ";
						$body .= elgg_get_excerpt($vars['entity']->description, 450);
						// add a "read more" link if cropped.
						if (elgg_substr($body, -3, 3) == '...') {
							$body .= " <a href=\"{$vars['entity']->getURL()}\">" . strtolower(elgg_echo('more')) . '</a>';
						}
						
						echo $body;
						echo "<div class='clearfloat'></div>";
					}
				
				?>
			<div class="clearfloat"></div>			
			<!-- display edit options if it is the blog post owner -->
			<p class="options">
			<?php
	
				if ($canedit) {
					
				?>
					<a href="<?php echo $vars['url']; ?>pg/blog/edit/<?php echo $vars['entity']->getGUID(); ?>"><?php echo elgg_echo("edit"); ?></a>  &nbsp;
					<?php
					
						echo elgg_view("output/confirmlink", array(
							'href' => $vars['url'] . "action/blog/delete?blogpost=" . $vars['entity']->getGUID(),
							'text' => elgg_echo('delete'),
							'confirm' => elgg_echo('deleteconfirm'),
						));
	
						// Allow the menu to be extended
						echo elgg_view("editmenu",array('entity' => $vars['entity']));
					
					?>
				<?php
				}
			
			?>
			</p>
		</div>
		</div>

<?php
				
			}

		}

?>
