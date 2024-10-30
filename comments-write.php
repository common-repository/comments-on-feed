<?php 
@session_start();
$id = intval($_GET['cof_write']);
if($id == 0) die(__('Invalid request.'));
$post = get_post($id);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
     <title><?php printf(__('%1$s - Comments on %2$s'), get_option('blogname'), the_title('','',false)); ?></title>

	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_option('blog_charset'); ?>" />
	<style type="text/css" media="screen">
		body {
			font-family: tahoma, arial;
			font-size: 8pt;
		}
		a {
			text-decoration: none;
		}
		
		.send_status {
			background-color:#FFFFE0;
			border:1px solid #E6DB55;
			padding:5px;
		}
		
		textarea, input {
			font-family: tahoma, arial;
			font-size: 9pt;
		}
	</style>

</head>
<body id="commentspopup" style="direction: <?php echo $text_direction;?>">
<?php if( isset($_GET['sent']) and $_GET['sent'] == 'ok') : ?>
	<div class="send_status">
	<b><?php _e('Your comment was sent successfully.', 'comments-on-feed'); ?></b>
		<div style="padding-top:5px;">
			<a style="color:green;" href="<?php the_permalink(); ?>" ><?php _e('View this post', 'comments-on-feed'); ?></a> | 
			<a  href="<?php echo get_option('siteurl'); ?>/?cof_list=<?php echo $id; ?>" ><?php _e('View other comments', 'comments-on-feed'); ?></a> | 
			<a style="color:red;" href="#" onclick="window.open('','_self');window.close();"><?php _e('Close this window', 'comments-on-feed'); ?></a>
		</div>
	</div>
<?php endif; ?>
<?php if ( comments_open() ) { ?>
<h3><?php printf(__('Leave a comment for "%s": ', 'comments-on-feed'), '<a rel="bookmark" href="'.get_permalink()."\">$post->post_title</a>"); ?></h3>
<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
<?php if ( $user_ID ) : ?>
	<p><?php printf(__('Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out &raquo;</a>'), get_option('siteurl') . '/wp-admin/profile.php', $user_identity, wp_logout_url(get_permalink())); ?></p>
<?php else : ?>
	<p>
	  <input type="text" name="author" id="author" class="textarea" value="<?php echo esc_attr($comment_author); ?>" size="28" tabindex="1" />
	   <label for="author"><?php _e('Name'); ?></label>
	</p>

	<p>
	  <input type="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="28" tabindex="2" />
	   <label for="email"><?php _e('E-mail'); ?></label>
	</p>

	<p>
	  <input type="text" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" size="28" tabindex="3" />
	   <label for="url"><?php _e('<abbr title="Universal Resource Locator">URL</abbr>'); ?></label>
	</p>
<?php endif; ?>

	<p>
	  <label for="comment"><?php _e('Your Comment'); ?></label>
	<br />
	  <textarea name="comment" id="comment" cols="70" rows="4" tabindex="4"></textarea>
	</p>

	<p>
	  <input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
	  <input type="hidden" name="redirect_to" value="<?php echo esc_attr($_SERVER["REQUEST_URI"].'&amp;sent=ok'); ?>" />
	  <input name="submit" type="submit" tabindex="5" value="<?php _e('Say It!' ); ?>" />
	</p>
	<?php //do_action('comment_form', $post->ID); ?>
</form>
<?php } else { // comments are closed ?>
<p><?php _e('Sorry, the comment form is closed at this time.'); ?></p>
<?php }
?>

<div><strong><a href="javascript:window.close()"><?php _e('Close this window.'); ?></a></strong></div>

<?php //} ?>
<script type="text/javascript">
<!--
document.onkeypress = function esc(e) {
	if(typeof(e) == "undefined") { e=event; }
	if (e.keyCode == 27) { self.close(); }
}
// -->
</script>
</body>
</html>