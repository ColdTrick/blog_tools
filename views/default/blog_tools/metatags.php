<?php
	global $fancybox_js_loaded;
	
	if(empty($fancybox_js_loaded)){
		$fancybox_js_loaded = true;
		
		?>
		<script type="text/javascript" src="<?php echo $vars["url"];?>mod/blog_tools/vendors/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
		<?php 
	}
?>
<script type="text/javascript">
	$(document).ready(function(){
		$("a.blog_tools_fancybox").fancybox();
	});
</script>