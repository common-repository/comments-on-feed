<?php 
	@session_start();
	$id = intval($_GET['cof_list']);
	if($id == 0) 
		die(__('Invalid request.'));
	global $post;
	$post = get_post($id);
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?php echo get_settings('blogname'); ?> - <?php _e('Comment for ', 'comments-on-feed'); the_title(); ?></title>
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_settings('blog_charset'); ?>" />
		<style type="text/css" media="screen">
			body {
				font-family:tahoma, arial;
				font-size:8pt;
			}

			h3, #quick_comment {
				width: 68.9%;
				margin: 0 auto;
				padding-bottom: 10px;
			}
			.nopassword,
			.nocomments {
				color: #aaa;
				font-size: 24px;
				font-weight: 100;
				margin: 26px 0;
				text-align: center;
			}
			.commentlist {
				list-style: none;
				margin: 0 auto;
				width: 68.9%;
			}
			.content .commentlist {
				width: 100%; 
			}
			.commentlist > li.comment {
				background: #f6f6f6;
				border: 1px solid #ddd;
				border-radius: 5px;
				margin: 0 0 1em;
				padding: 1.625em;
				position: relative;
			}
			.commentlist .pingback {
				margin: 0 0 1.625em;
				padding: 0 1.625em;
			}
			.commentlist .children {
				list-style: none;
				margin: 0;
			}
			.commentlist .children li.comment {
				background: #f8f8f8;
				border: 1px solid #ddd;
				border-radius: 0 5px 5px 0;
				margin: 1em 0;
				padding: 1.625em;
				position: relative;
			}
			.commentlist .children li.comment .fn {
				display: block;
			}
			.comment-meta .fn {
				font-style: normal;
			}
			.comment-meta {
				color: #666;
				font-size: 12px;
				line-height: 2.2em;
			}
			.commentlist .children li.comment .comment-meta {
				line-height: 1.625em;
				margin-left: 50px;
			}
			.commentlist .children li.comment .comment-content {
				margin: 1.625em 0 0;
			}
			.comment-meta a {
				font-weight: bold;
			}
			.comment-meta a:focus,
			.comment-meta a:active,
			.comment-meta a:hover {
			}
			.commentlist .avatar {
				border-radius: 3px;
				box-shadow: 0 1px 2px #ccc;
				padding: 0;
			}
			.commentlist > li:before {
				/* content: url(images/comment-arrow.png); */
				left: -21px;
				position: absolute;
			}
			.commentlist > li.pingback:before {
				content: '';
			}
			.commentlist .children .avatar {
				background: none;
				box-shadow: none;
				left: 2.2em;
				padding: 0;
				top: 2.2em;
			}
			a.comment-reply-link {
				background: #eee;
				border-radius: 5px;
				color: #666;
				display: inline-block;
				font-size: 12px;
				padding: 0 8px;
				text-decoration: none;
			}
			a.comment-reply-link:hover,
			a.comment-reply-link:focus,
			a.comment-reply-link:active {
				background: #888;
				color: #fff;
			}
			a.comment-reply-link > span {
				display: inline-block;
				position: relative;
				top: -1px;
			}

			/* Post author highlighting */
			.commentlist > li.bypostauthor {
				background: #ddd;
				border-color: #d3d3d3;
			}
			.commentlist > li.bypostauthor .comment-meta {
				color: #575757;
			}
			.commentlist > li.bypostauthor .comment-meta a:focus,
			.commentlist > li.bypostauthor .comment-meta a:active,
			.commentlist > li.bypostauthor .comment-meta a:hover {
			}
			.commentlist > li.bypostauthor:before {
				content: url(images/comment-arrow-bypostauthor.png);
			}

			/* Post Author threaded comments */
			.commentlist .children > li.bypostauthor {
				background: #ddd;
				border-color: #d3d3d3;
			}
		</style>
	</head>
	<body <?php echo "dir='$text_direction'";?> >
		<!-- Comments On Feed 1.2 Developed By Reza Moallemi - http://www.moallemi.ir/blog -->
			<div id="comments">
		<h3><?php printf(__('%s comment(s) for "%s": ', 'comments-on-feed'), number_format_i18n( get_comments_number() ), '<a rel="bookmark" href="'.get_permalink()."\">$post->post_title</a>"); ?></h3>
		<ol class="commentlist">
			<?php wp_list_comments('callback=cof_comments_cb', get_approved_comments($id)); ?>
		</ol>
	<?php if ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="nocomments"><?php _e( 'Comments are closed.', 'twentyeleven' ); ?></p>
	<?php endif; ?>
</div>
		<div id="quick_comment">
			<?php $options = get_comments_on_feed_options(); ?>
			<a href="<?php echo get_option('siteurl').'/?cof_write='.$id; ?>" ><?php echo  $options['button_text']; ?></a>
		</div>
	</body>
</html>