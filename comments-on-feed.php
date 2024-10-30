<?php
	@session_start();
	/*
	Plugin Name: Comments On Feed
	Plugin URI: http://www.moallemi.ir/en/blog/2009/12/18/comments-on-feed-for-wordpress/
	Description: This plugin lets you show each post comments on post feed.
	Version: 1.2.1
	Author: Reza Moallemi
	Author URI: http://moallemi.ir
	Text Domain: comments-on-feed
  Domain Path: /languages/
	*/
	
	
	function comments_on_feed_options()
	{
		$comments_on_feed_options = get_comments_on_feed_options();
		$buttons_dir = dirname(__FILE__).'/buttons';
		$buttons_url = get_option('siteurl').'/wp-content/plugins/'.plugin_basename(dirname(__FILE__)).'/buttons';
		if (isset($_POST['update_comments_on_feed_settings']))
		{
			$comments_on_feed_options['show_avatar'] = isset($_POST['show_avatar']) ? $_POST['show_avatar'] : 'false';
			$comments_on_feed_options['avatar_size'] = isset($_POST['avatar_size']) ? $_POST['avatar_size'] : '32';
			$comments_on_feed_options['comment_number'] = (isset($_POST['comment_number']) and $_POST['comment_number'] != '') ? intval($_POST['comment_number']) : '5';
			$comments_on_feed_options['comment_order'] = isset($_POST['comment_order']) ? $_POST['comment_order'] : 'ACS';
			$comments_on_feed_options['button_position'] = isset($_POST['button_position']) ? $_POST['button_position'] : 'after';
			$comments_on_feed_options['button_type'] = isset($_POST['button_type']) ? $_POST['button_type'] : 'text';
			$comments_on_feed_options['button_text'] = (isset($_POST['button_text']) and $_POST['button_text'] != '') ? $_POST['button_text'] : __('Write a quick comment', 'comments-on-feed');
			update_option('comments_on_feed_options', $comments_on_feed_options);
			?>
			<div class="updated">
				<p><strong><?php _e("Settings Saved.","comments-on-feed");?></strong></p>
			</div>
			<?php
		} ?>
		<div class=wrap>
		<?php if(function_exists('screen_icon')) screen_icon(); ?>
			<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
				<h2><?php _e('Comments On Feed Settings', 'comments-on-feed'); ?></h2>
				<h3><?php _e('General Settings:', 'comments-on-feed'); ?></h3>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php _e('Avatar', 'comments-on-feed'); ?></th>
						<td>
							<input name="show_avatar" value="true" type="checkbox" <?php if ($comments_on_feed_options['show_avatar'] == 'true' ) echo ' checked="checked" '; ?> /> <?php _e('Show Avatar.', 'comments-on-feed'); ?>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Avatar Size', 'comments-on-feed'); ?> </th>
						<td>
							<select name="avatar_size">
							  <option value="32" <?php if ($comments_on_feed_options['avatar_size'] == '32' ) echo ' selected="selected" '; ?> >32 px</option>
							  <option value="16" <?php if ($comments_on_feed_options['avatar_size'] == '16' ) echo ' selected="selected" '; ?> >16 px</option>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Number of comments on post', 'comments-on-feed'); ?> </th>
						<td>
							<input style="width:30px;direction:ltr;" name="comment_number" type="text" value="<?php echo $comments_on_feed_options['comment_number']; ?>" /> 
							<span class="description"><?php _e('Set the value to <b>-1</b> if you want to show all comments.', 'comments-on-feed'); ?></span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Comments Order', 'comments-on-feed'); ?>  </th>
						<td>
							<select name="comment_order">
							  <option value="ASC" <?php if ($comments_on_feed_options['comment_order'] == 'ASC' ) echo ' selected="selected" '; ?> ><?php _e('Oldest first', 'comments-on-feed'); ?></option>
							  <option value="DESC" <?php if ($comments_on_feed_options['comment_order'] == 'DESC' ) echo ' selected="selected" '; ?> ><?php _e('Newest first', 'comments-on-feed'); ?></option>
							</select>
						</td>
					</tr>
				</table>
				<h3><?php _e('Button Settings', 'comments-on-feed'); ?></h3>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php _e('Button Posintion', 'comments-on-feed'); ?>   </th>
						<td>
							<select name="button_position">
							  <option value="after" <?php if ($comments_on_feed_options['button_position'] == 'after' ) echo ' selected="selected" '; ?> ><?php _e('After comments', 'comments-on-feed'); ?></option>
							  <option value="before" <?php if ($comments_on_feed_options['button_position'] == 'before' ) echo ' selected="selected" '; ?> ><?php _e('Before comments', 'comments-on-feed'); ?></option>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Button Type', 'comments-on-feed'); ?>   </th>
						<td>
							<script type="text/javascript" language="javascript">
							function changeImage()
							{
								jQuery('#preview_img').attr('src', "");
								jQuery('#preview_img').attr('src', "<?php echo $buttons_url; ?>/" + jQuery('#button-type').attr('value'));
							}
							</script>
							<select id="button-type" name="button_type" onchange="changeImage();">
							  <option value="text" <?php if ($comments_on_feed_options['button_type'] == 'text' ) echo ' selected="selected" '; ?> ><?php _e('Text', 'comments-on-feed'); ?></option>
							  <?php 
								if ($handle = opendir($buttons_dir)) 
								{
									while (false !== ($file = readdir($handle))) 
									{
										if($file != '.' and $file != '..')
										{
										?>
										<option value="<?php echo $file;?>" <?php if ($comments_on_feed_options['button_type'] == $file ) echo ' selected="selected" '; ?> ><?php echo $file; ?></option>
										<?php
										}
									}
									closedir($handle);
								} 
								?>
							</select>
							<p> <img id="preview_img" alt="<?php echo $comments_on_feed_options['button_text'];?>" src="<?php echo $buttons_url.'/'.$comments_on_feed_options['button_type']; ?>" />
							</p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Button text', 'comments-on-feed'); ?>   </th>
						<td>
							<input style="width:170px;" name="button_text" type="text" value="<?php echo $comments_on_feed_options['button_text']; ?>" /> 
						</td>
					</tr>
				</table>
				<div class="submit">
					<input class="button-primary" type="submit" name="update_comments_on_feed_settings" value="<?php _e('Save Changes', 'comments-on-feed') ?>" />
				</div>
				<hr />
				<div>
					<h4><?php _e('My other plugins for wordpress:', 'comments-on-feed'); ?></h4>
					<ul>
						<li><b>- <?php _e('Extended Gravatar', 'comments-on-feed'); ?></b>
							(<a href="http://wordpress.org/extend/plugins/extended-gravatar/"><?php _e('Download', 'comments-on-feed'); ?></a> | 
							<a href="<?php _e('http://www.moallemi.ir/blog/1390/05/09/%D8%A7%D9%81%D8%B2%D9%88%D9%86%D9%87-%D9%88%D8%B1%D8%AF%D9%BE%D8%B1%D8%B3-%DA%AF%D8%B1%D8%A7%D9%88%D8%A7%D8%AA%D8%A7%D8%B1-%D8%AA%D9%88%D8%B3%D8%B9%D9%87-%DB%8C%D8%A7%D9%81%D8%AA%D9%87/', 'comments-on-feed'); ?>"><?php _e('More Information', 'comments-on-feed'); ?></a>)
						</li>
						<li><b>- <?php _e('Likekhor', 'comments-on-feed'); ?></b>
							(<a href="http://wordpress.org/extend/plugins/wp-likekhor/"><?php _e('Download', 'comments-on-feed'); ?></a> | 
							<a href="<?php _e('http://www.moallemi.ir/blog/1389/11/22/%D8%A7%D9%81%D8%B2%D9%88%D9%86%D9%87-%D9%84%D8%A7%DB%8C%DA%A9-%D8%AE%D9%88%D8%B1-%D9%88%D8%B1%D8%AF%D9%BE%D8%B1%D8%B3-%D8%A2%D9%85%D8%A7%D8%B1-%D9%BE%DB%8C%D8%B4%D8%B1%D9%81%D8%AA%D9%87/', 'comments-on-feed'); ?>"><?php _e('More Information', 'comments-on-feed'); ?></a>)
						</li>
						<li><b>- <?php _e('Google Reader Stats ', 'comments-on-feed'); ?></b>
							(<a href="http://wordpress.org/extend/plugins/google-reader-stats/"><?php _e('Download', 'comments-on-feed'); ?></a> | 
							<a href="<?php _e('http://www.moallemi.ir/en/blog/2010/06/03/google-reader-stats-for-wordpress/', 'comments-on-feed'); ?>"><?php _e('More Information', 'comments-on-feed'); ?></a>)
						</li>
						<li><b>- <?php _e('Google Transliteration ', 'comments-on-feed'); ?></b>
							(<a href="http://wordpress.org/extend/plugins/google-transliteration/"><?php _e('Download', 'comments-on-feed'); ?></a> | 
							<a href="<?php _e('http://www.moallemi.ir/en/blog/2009/10/10/google-transliteration-for-wordpress/', 'comments-on-feed'); ?>"><?php _e('More Information', 'comments-on-feed'); ?></a>)
						</li>
						<li><b>- <?php _e('Behnevis Transliteration ', 'comments-on-feed'); ?></b> 
							(<a href="http://wordpress.org/extend/plugins/behnevis-transliteration/"><?php _e('Download', 'comments-on-feed'); ?></a> | 
							<a href="http://www.moallemi.ir/blog/1388/07/25/%D8%A7%D9%81%D8%B2%D9%88%D9%86%D9%87-%D9%86%D9%88%DB%8C%D8%B3%D9%87-%DA%AF%D8%B1%D8%AF%D8%A7%D9%86-%D8%A8%D9%87%D9%86%D9%88%DB%8C%D8%B3-%D8%A8%D8%B1%D8%A7%DB%8C-%D9%88%D8%B1%D8%AF%D9%BE%D8%B1%D8%B3/"><?php _e('More Information', 'comments-on-feed'); ?></a> )
						</li>
						<li>- <b><?php _e('Advanced User Agent Displayer ', 'comments-on-feed'); ?></b>
							(<a href="http://wordpress.org/extend/plugins/advanced-user-agent-displayer/"><?php _e('Download', 'comments-on-feed'); ?></a> | 
							<a href="<?php _e('http://www.moallemi.ir/en/blog/2009/09/20/advanced-user-agent-displayer/', 'comments-on-feed'); ?>"><?php _e('More Information', 'comments-on-feed'); ?></a>)
						</li>
						<li><b>- <?php _e('Feed Delay ', 'comments-on-feed'); ?></b> 
							(<a href="http://wordpress.org/extend/plugins/feed-delay/"><?php _e('Download', 'comments-on-feed'); ?></a> | 
							<a href="<?php _e('http://www.moallemi.ir/en/blog/2010/02/25/feed-delay-for-wordpress/', 'comments-on-feed'); ?>"><?php _e('More Information', 'comments-on-feed'); ?></a>)
						</li>
						<li><b>- <?php _e('Contact Commenter ', 'comments-on-feed'); ?></b> 
							(<a href="http://wordpress.org/extend/plugins/contact-commenter/"><?php _e('Download', 'comments-on-feed'); ?></a> | 
							<a href="<?php _e('http://www.moallemi.ir/blog/1388/12/27/%d9%87%d8%af%db%8c%d9%87-%da%a9%d8%a7%d9%88%d8%b4%da%af%d8%b1-%d9%85%d9%86%d8%a7%d8%b3%d8%a8%d8%aa-%d8%b3%d8%a7%d9%84-%d9%86%d9%88-%d9%88%d8%b1%d8%af%d9%be%d8%b1%d8%b3/', 'comments-on-feed'); ?>"><?php _e('More Information', 'comments-on-feed'); ?></a>)
						</li>
					</ul>
				</div>
			</form>
		</div>
		<?php
	}
	
	load_plugin_textdomain('comments-on-feed', NULL, dirname(plugin_basename(__FILE__)) . "/languages");
	
	add_action('admin_menu', 'comments_on_feed_menu');
		
	function comments_on_feed_menu() 
	{
		add_options_page('Comments On Feed Options', __('Comments On Feed', 'comments-on-feed'), 8, 'comments-on-feed', 'comments_on_feed_options');
	}
	
	function get_comments_on_feed_options()
	{
		$comments_on_feed_options = array('show_avatar' => 'true',
								'avatar_size' => '32',
								'comment_number' => '5',
								'comment_order' => 'ASC',
								'button_position' => 'after',
								'button_text' => __('Write a quick comment', 'comments-on-feed'),
								'button_type' => 'text');
		$comments_on_feed_save_options = get_option('comments_on_feed_options');
		if (!empty($comments_on_feed_save_options))
		{
			foreach ($comments_on_feed_save_options as $key => $option)
			$comments_on_feed_options[$key] = $option;
		}
		update_option('comments_on_feed_options', $comments_on_feed_options);
		return $comments_on_feed_options;
	}
	
	
	function CommentsOnFeed() 
	{
		add_filter('the_content', 'add_comments_to_feed', 9999);
		add_action('comment_post', 'add_referrer_to_comments');
		add_action('wp_set_comment_status', 'comments_on_feed_ping');
	}
	
	function comments_on_feed_add_date($givendate, $sec=0) 
	{
      $cd = strtotime($givendate);
      $newdate = date('Y-m-d h:i:s', mktime(date('h',$cd),
		date('i',$cd), date('s',$cd)+$sec, date('m',$cd),
		date('d',$cd), date('Y',$cd)));
      return $newdate;
	}
	
	function comments_on_feed_ping($comment_id)
	{
		$comment = get_comment($comment_id);
		$original_post = get_post($comment->comment_post_ID);
		
		$my_post = array();
		$my_post['ID'] = $comment->comment_post_ID;
		$my_post['post_date'] = comments_on_feed_add_date($original_post->post_date , 1);
		wp_update_post($my_post);
		
		generic_ping();
	}
	
	function add_referrer_to_comments($comment_id)
	{
		if($_SESSION['comments-on-feed'] == 'ok')
		{
			add_comment_meta($comment_id,  'comment_referrer',  'http://www.google.com/reader/view', true); 
			unset($_SESSION['comments-on-feed']);
		}
	}
							
	$plugin = plugin_basename(__FILE__); 
	add_filter("plugin_action_links_$plugin", 'comments_on_feed_links' );
	
	function comments_on_feed_links($links)
	{ 
		$settings_link = '<a href="options-general.php?page=comments-on-feed">'.__('Settings', 'comments-on-feed').'</a>';
		array_unshift($links, $settings_link); 
		return $links; 
	}
	
	function add_comments_to_feed($content)
	{
		if (!is_feed()) 
			return $content;
		$comments_on_feed_options = get_comments_on_feed_options();
		
		global $post, $id;
		$option = array('post_id' => $id, 'order' => $comments_on_feed_options['comment_order'], 'status' => 'approve');
		$comments = get_comments($option);
		$count = 0;
		$comment_number = $comments_on_feed_options['comment_number'];
		$str_cmnt_num = get_comment_count($id);
		$more_num = 0;
		if($comment_number != -1)
			$more_num = $str_cmnt_num['approved'] - $comment_number;
		$write_template_path = get_option('siteurl').'/?cof_write='.$id;
		$view_template_path = get_option('siteurl').'/?cof_list='.$id;
		$comments_to_add = '';
		$plugin_url = get_option('siteurl').'/wp-content/plugins/'.plugin_basename(dirname(__FILE__));
		if($comments_on_feed_options['button_type'] == 'text')
			$write_comment_link = '<b><a target="_blank" href="'.$write_template_path.'">'.$comments_on_feed_options['button_text'].'</a></b>';
		else
			$write_comment_link = '<a target="_blank" href="'.$write_template_path.'"><img align="middle" border="0" src="'.$plugin_url.'/buttons/'.$comments_on_feed_options['button_type'].'" alt="'.$comments_on_feed_options['button_text'].'" /></a>';
		
		$view_comments_link = '<a target="_blank" href="'.$view_template_path.'">'.$more_num. __(" more comment(s).", 'comments-on-feed').'</a>';
		
		if ($str_cmnt_num['approved']!= 0)
		{ 
			$comments_to_add .= '
				<div>';
					if($comment_number != 0) $comments_to_add .= '
					<h4>'.$str_cmnt_num['approved'].__(' comment(s) for this post:', 'comments-on-feed').'</h4>';
					 if($comments_on_feed_options['button_position'] == 'before')
					{
						$comments_to_add .='
						  <p>'.$write_comment_link;
						  if($more_num > 0 and $comment_number != 0)
						  {
							$comments_to_add .= __(' | View ', 'comments-on-feed');
							$comments_to_add .= $view_comments_link;
						  }
						  $comments_to_add .= 
						  '</p>';
					}
					 $comments_to_add .= 
					 '<ol>';
						foreach ($comments as $cmnt)
						{
							if($comment_number != -1 and $count == $comment_number) 
								break; 
							global $comment;
							$comment = $cmnt;
							$comments_to_add .= '
						  <li>';
							if ($comments_on_feed_options['show_avatar'] == 'true') 
								$comments_to_add .= get_avatar($comment, $comments_on_feed_options['avatar_size']);
							$comments_to_add .= '<i>'.$comment->comment_author.':</i>
							<br />
							<small><a rel="nofollow" href="'.get_comment_link().'">'.cof_date('d M Y', $comment->comment_date).'</a></small>
							'.$comment->comment_content.'
						  </li>';
							$count++;
						}
					  $comments_to_add .= '
					  </ol>
				  </div>';
		
		}
		else
		{
			if($comments_on_feed_options['button_position'] == 'before')
			{
				$comments_to_add .='
				  <p>'.$write_comment_link;
				  if($more_num > 0 and $comment_number != 0)
				  {
					$comments_to_add .= __(' | View ', 'comments-on-feed');
					$comments_to_add .= $view_comments_link;
				  }
				  $comments_to_add .= '</p>';
			}
		}
		if($comments_on_feed_options['button_position'] == 'after')
		{
			$comments_to_add .='
			  <p>'.$write_comment_link;
			  if($more_num > 0 and $comment_number != 0)
			  {
				$comments_to_add .= __(' | View ', 'comments-on-feed');
				$comments_to_add .= $view_comments_link;
			  }
			  $comments_to_add .= '</p>';
		}
		return $content.$comments_to_add;
	}
	
	function cof_comments_cb($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment;
	?>
		<li class="comment <?php if($comment->comment_author_email == get_the_author_email()) {echo 'adminComment';} ?>" id="comment-<?php comment_ID() ?>">
			<div id="div-comment-<?php comment_ID() ?> " class="comment-body">
				<div class="comment-author vcard">
					<?php 
						if (function_exists('get_avatar'))
							echo get_avatar($comment, 32);
					?>
					<?php if (get_comment_author_url()): ?>
						<?php
						print get_comment_author_link();
						?>
					<?php else: ?>
						<span id="commentauthor-<?php comment_ID() ?>"><?php comment_author(); ?></span>
					<?php endif; ?>
				</div>	
				<div class="comment-meta commentmetadata">
				<span class="date"> <?php printf( __('%1$s at %2$s', 'comments-on-feed'), get_comment_time(__('F jS, Y', 'Eos')), get_comment_time(__('g:i a', 'Eos')) ); ?></span>
				<?php edit_comment_link(__('Edit', 'comments-on-feed'),' (',')'); ?>
				</div>
				<div class="content">
					<?php if ($comment->comment_approved == '0') : ?>
						<p><small><?php _e('Your comment is awaiting moderation.', 'comments-on-feed'); ?></small></p>
					<?php endif; ?>

					<div id="commentbody-<?php comment_ID() ?>">
						<?php comment_text(); ?>
					</div>
				</div>
			</div>
		</li>
	<?php
	}
	
	add_filter('template_include', 'comments_on_feed_template_loader');
	
	function comments_on_feed_template_loader($template) {
		global $wp_query;
		if(isset($_GET['cof_list']) and $_GET['cof_list'] != '' and intval($_GET['cof_list']) != 0) {
			$template = ABSPATH.'wp-content/plugins/'.basename(dirname(__FILE__)).'/comments-list.php';
		}
		elseif(isset($_GET['cof_write']) and $_GET['cof_write'] != '' and intval($_GET['cof_write']) != 0) {
			$template = ABSPATH.'wp-content/plugins/'.basename(dirname(__FILE__)).'/comments-write.php';
		}		
		return($template);
	}
	
	function cof_date($format, $date) {
		if(function_exists('jdate'))
			return jdate($format, strtotime($date));
		else
			return date($format, strtotime($date));
	}
	
	function cof_never_call(){
    $desc = __('This plugin lets you show each post comments on post feed.', 'comments-on-feed');
    $me = __('Reza Moallemi', 'comments-on-feed');
	}
	
	CommentsOnFeed();
			
?>