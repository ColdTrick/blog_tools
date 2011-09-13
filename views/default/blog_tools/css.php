<?php ?>

#blog_tools_transfer_wrapper {
	width: 550px;
	height: 300px;
}

.blog_tools_blog_image {
	float: left; 
	margin: 5px; 
	padding: 5px; 
	border: 1px solid #CECECE;
}

.blog_tools_blog_image_right {
	float: right;
}

.blog_tools_info_wrapper p.tags,
.blog_tools_info_wrapper p.categories {
	display: inline-block;
}

.blog_tools_info_wrapper p.tags,
.blog_tools_info_wrapper p.blog_tools_categories_no_tags {
	margin: 0 0 7px 5px !important;
}

.blog_tools_info_wrapper .blog_post_icon {
	margin: 0 5px 0 0;
}

#widget_blog_items_container > div {
	display: none;
}
#widget_blog_items_navigator {
	border-top: 1px dotted #CCCCCC;
	padding-top: 5px;
	text-align: center;
}
#widget_blog_items_navigator > span {
	border: 1px solid #CCCCCC;
	cursor: pointer;
	padding: 2px 4px;
	margin: 0 2px;
}

#widget_blog_items_navigator > span.active,
#widget_blog_items_navigator > span:hover {
	background: #CCCCCC;
}

#widget_blog_items_navigator > span.active {
	cursor: auto;
}
#widget_blog_items_container .groupicon{
	float: left;
	margin-right: 20px;
}