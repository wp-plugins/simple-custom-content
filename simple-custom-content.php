<?php
/*
Plugin Name: Simple Custom Content
Plugin URI: http://perishablepress.com/simple-custom-content/
Description: Easily add custom content to your posts and feeds.
Author: Jeff Starr
Author URI: http://monzilla.biz/
Donate link: http://m0n.co/donate
Version: 20131106
License: GPL v2
Usage: Visit the plugin's settings page to add some custom conent.
*/

// NO EDITING REQUIRED - PLEASE SET PREFERENCES IN THE WP ADMIN!

if (!defined('ABSPATH')) die();

// i18n
function scs_i18n_init() {
	load_plugin_textdomain('scs', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'scs_i18n_init');

$scs_version = '20131106';
$options = get_option('scs_options');

// require minimum version of WordPress
add_action('admin_init', 'require_wp_version');
function require_wp_version() {
	global $wp_version;
	$plugin = plugin_basename(__FILE__);
	$plugin_data = get_plugin_data(__FILE__, false);

	if (version_compare($wp_version, "3.3", "<")) {
		if (is_plugin_active($plugin)) {
			deactivate_plugins($plugin);
			$msg =  '<p><strong>' . $plugin_data['Name'] . '</strong> requires WordPress 3.3 or higher, and has been deactivated!</p>';
			$msg .= '<p>Please upgrade WordPress and try again.</p><p>Return to the <a href="' .admin_url() . '">WordPress Admin area</a>.</p>';
			wp_die($msg);
		}
	}
}

// custom content in all feeds
if ($options['scs_location_feeds'] !== 'scs_feed_none') {
	add_filter('the_excerpt_rss', 'simple_custom_content_feeds');
}
function simple_custom_content_feeds($content) {
	$options = get_option('scs_options');
	$custom = $options['scs_all_feeds'];
	$location = $options['scs_location_feeds'];
	if (is_feed()) {
		if ($location == 'scs_feed_after') {
			return $content . $custom;
		} elseif ($location == 'scs_feed_before') {
			return $custom . $content;
		} elseif ($location == 'scs_feed_both') {
			return $custom . $content . $custom;
		} else {
			return $content;
		}
	} else {
		return $content;
	}
}

// custom content in all posts
if ($options['scs_location_posts'] !== 'scs_feed_none') {
	add_filter('the_content', 'simple_custom_content_posts');
}
if ($options['scs_enable_excerpts'] !== 0) {
	add_filter('the_excerpt', 'simple_custom_content_posts');
}
function simple_custom_content_posts($content) {
	$options = get_option('scs_options');
	$custom = $options['scs_all_posts'];
	$location = $options['scs_location_posts'];
	if (!is_feed()) {
		if ($location == 'scs_post_after') {
			return $content . $custom;
		} elseif ($location == 'scs_post_before') {
			return $custom . $content;
		} elseif ($location == 'scs_post_both') {
			return $custom . $content . $custom;
		} else {
			return $content;
		}
	} else {
		return $content;
	}
}

// SCS alt shortcode
add_shortcode('scs_alt','scs_alt_shortcode');
function scs_alt_shortcode() { 
	$options = get_option('scs_options');
	return $options['scs_alt_shortcode'];
}

// SCS both shortcode
add_shortcode('scs_both','scs_both_shortcode');
function scs_both_shortcode() { 
	$options = get_option('scs_options');
	return $options['scs_both_shortcode'];
}

// SCS feed shortcode
add_shortcode('scs_feed','scs_feed_shortcode');
function scs_feed_shortcode() { 
	$options = get_option('scs_options');
	if (is_feed()) {
		return $options['scs_feed_shortcode'];
	} else {
		return '';
	}
}

// SCS post shortcode
add_shortcode('scs_post','scs_post_shortcode');
function scs_post_shortcode() { 
	$options = get_option('scs_options');
	if (!is_feed()) {
		return $options['scs_post_shortcode'];
	} else {
		return '';
	}
}

// display settings link on plugin page
add_filter ('plugin_action_links', 'scs_plugin_action_links', 10, 2);
function scs_plugin_action_links($links, $file) {
	if ($file == plugin_basename(__FILE__)) {
		$scs_links = '<a href="'. get_admin_url() .'options-general.php?page=simple-custom-content/simple-custom-content.php">'. __('Settings', 'scs') .'</a>';
		array_unshift($links, $scs_links);
	}
	return $links;
}

// rate plugin link
function add_scs_links($links, $file) {
	if ($file == plugin_basename(__FILE__)) {
		$rate_url = 'http://wordpress.org/support/view/plugin-reviews/' . basename(dirname(__FILE__)) . '?rate=5#postform';
		$links[] = '<a href="' . $rate_url . '" target="_blank" title="Click here to rate and review this plugin on WordPress.org">Rate this plugin</a>';
	}
	return $links;
}
add_filter('plugin_row_meta', 'add_scs_links', 10, 2);

// delete plugin settings
function scs_delete_plugin_options() {
	delete_option('scs_options');
}
if ($options['default_options'] == 1) {
	register_uninstall_hook (__FILE__, 'scs_delete_plugin_options');
}

// define default settings
register_activation_hook (__FILE__, 'scs_add_defaults');
function scs_add_defaults() {
	$tmp = get_option('scs_options');
	if(($tmp['default_options'] == '1') || (!is_array($tmp))) {
		$arr = array(
			'scs_all_feeds'       => '<p>This text/markup is included in all post items in all feeds.</p>',
			'scs_all_posts'       => '<p>This text/markup is included in all single post views.</p>',
			'scs_enable_excerpts' => 0,
			'scs_location_feeds'  => 'scs_feed_none',
			'scs_location_posts'  => 'scs_post_none',
			'scs_alt_shortcode'   => '<p>This text/markup is included wherever you put the [scs_alt] shortcode.</p>',
			'scs_both_shortcode'  => '<p>This text/markup is included wherever you put the [scs_both] shortcode.</p>',
			'scs_feed_shortcode'  => '<p>This text/markup is included wherever you put the [scs_feed] shortcode.</p>',
			'scs_post_shortcode'  => '<p>This text/markup is included wherever you put the [scs_post] shortcode.</p>',
			'default_options'     => 0,
		);
		update_option('scs_options', $arr);
	}
}

// feed locations 
$scs_location_feeds = array(
	'scs_feed_after' => array(
		'value' => 'scs_feed_after',
		'label' => 'Include custom content at the end of each feed item',
	),
	'scs_feed_before' => array(
		'value' => 'scs_feed_before',
		'label' => 'Include custom content at the beginning of each feed item',
	),
	'scs_feed_both' => array(
		'value' => 'scs_feed_both',
		'label' => 'Include custom content at the beginning and end of each feed item',
	),
	'scs_feed_none' => array(
		'value' => 'scs_feed_none',
		'label' => 'Do not include custom content in any feed items',
	),
);

// post locations 
$scs_location_posts = array(
	'scs_post_after' => array(
		'value' => 'scs_post_after',
		'label' => 'Include custom content at the end of each post',
	),
	'scs_post_before' => array(
		'value' => 'scs_post_before',
		'label' => 'Include custom content at the beginning of each post',
	),
	'scs_post_both' => array(
		'value' => 'scs_post_both',
		'label' => 'Include custom content at the beginning and end of each post',
	),
	'scs_post_none' => array(
		'value' => 'scs_post_none',
		'label' => 'Do not include custom content in any posts',
	),
);

// whitelist settings
add_action ('admin_init', 'scs_init');
function scs_init() {
	register_setting('scs_plugin_options', 'scs_options', 'scs_validate_options');
}

// sanitize and validate input
function scs_validate_options($input) {
	global $scs_location_feeds, $scs_location_posts;

	$input['scs_all_feeds'] = wp_kses_post($input['scs_all_feeds']);
	$input['scs_all_posts'] = wp_kses_post($input['scs_all_posts']);
	
	$input['scs_alt_shortcode'] = wp_kses_post($input['scs_alt_shortcode']);
	$input['scs_both_shortcode'] = wp_kses_post($input['scs_both_shortcode']);
	$input['scs_feed_shortcode'] = wp_kses_post($input['scs_feed_shortcode']);
	$input['scs_post_shortcode'] = wp_kses_post($input['scs_post_shortcode']);
			
	if (!isset($input['scs_location_feeds'])) $input['scs_location_feeds'] = null;
	if (!array_key_exists($input['scs_location_feeds'], $scs_location_feeds)) $input['scs_location_feeds'] = null;

	if (!isset($input['scs_location_posts'])) $input['scs_location_posts'] = null;
	if (!array_key_exists($input['scs_location_posts'], $scs_location_posts)) $input['scs_location_posts'] = null;

	if (!isset($input['default_options'])) $input['default_options'] = null;
	$input['default_options'] = ($input['default_options'] == 1 ? 1 : 0);

	if (!isset($input['scs_enable_excerpts'])) $input['scs_enable_excerpts'] = null;
	$input['scs_enable_excerpts'] = ($input['scs_enable_excerpts'] == 1 ? 1 : 0);

	return $input;
}

// add the options page
add_action ('admin_menu', 'scs_add_options_page');
function scs_add_options_page() {
	add_options_page('Simple Custom Content', 'SCS', 'manage_options', __FILE__, 'scs_render_form');
}

// create the options page
function scs_render_form() {
	global $scs_version, $scs_location_feeds, $scs_location_posts; ?>

	<style type="text/css">
		#scs-admin abbr { cursor: help; border-bottom: 1px dotted #dfdfdf; }
		#scs-admin h2 small { font-size: 60%; }
		#scs-admin h3 { cursor: pointer; }
		#scs-admin h4, 
		#scs-admin p { margin: 15px; line-height: 18px; }
		#scs-admin ul { margin: 15px 15px 25px 40px; }
		#scs-admin li { margin: 10px 0; list-style-type: disc; }

		#scs-toggle-panels { margin: 5px 0; }
		#scs-credit-info { margin-top: -5px; }
		#setting-error-settings_updated { margin: 10px 0 5px 0; }
		#setting-error-settings_updated p { margin: 5px; }
		.scs-overview { padding-left: 77px; background: url(<?php echo plugins_url(); ?>/simple-custom-content/simple-custom-content.png) no-repeat 15px 0; }
		#scs-admin .button-primary { margin: 0 0 15px 15px; }
		.sfs-restore  { position: relative; left: 3px; bottom: 1px; }
		.sfs-excerpts { position: relative; left: 3px; top: 1px; }

		#scs-admin .scs-custom { margin-top: 8px; }
		#scs-admin .sfs-select-option { margin: -10px 0 30px 15px; }
		#scs-admin .sfs-select-option p { margin-left: 0; }
		#scs-admin .sfs-select-option div { margin: -5px 0 0 10px; }
		#scs-admin .sfs-select-option input { margin: 3px 0; }

		#scs-current { width: 100%; height: 250px; overflow: hidden; }
		#scs-current iframe { width: 100%; height: 100%; overflow: hidden; margin: 0; padding: 0; }
	</style>
	<div id="scs-admin" class="wrap">
		<?php screen_icon(); ?>
		<h2><?php _e('Simple Custom Content', 'scs'); ?> <small><?php echo 'v' . $scs_version; ?></small></h2>
		<div id="scs-toggle-panels"><a href="<?php get_admin_url() . 'options-general.php?page=simple-custom-content/simple-custom-content.php'; ?>"><?php _e('Toggle all panels', 'scs'); ?></a></div>
		<form method="post" action="options.php">
			<?php $options = get_option('scs_options'); settings_fields('scs_plugin_options'); ?>
			<div class="metabox-holder">	
				<div class="meta-box-sortables ui-sortable">
					<div id="scs-overview" class="postbox">
						<h3><?php _e('Overview', 'scs'); ?></h3>
						<div class="toggle">
							<div class="scs-overview">
								<p>
									<?php _e('<strong>Simple Custom Content</strong> (SCS) makes it easy to add custom content in your posts or feeds.', 'scs'); ?>
									<?php _e('You can add content to all posts, all feeds, or both. You can also use shortcodes to selectively include custom content in specific posts.', 'scs'); ?>
								</p>
								<ul>
									<li><?php _e('To add some custom content to your posts and feeds, visit', 'scs'); ?> <a id="scs-custom-content-link" href="#scs-custom-content"><?php _e('Custom content for all posts and feeds', 'scs'); ?></a>.</li>
									<li><?php _e('To add some custom content with shortcodes, visit', 'scs'); ?> <a id="scs-custom-shortcode-link" href="#scs-custom-shortcode"><?php _e('Custom content using shortcodes', 'scs'); ?></a>.</li>
									<li><?php _e('For more information check the', 'scs'); ?> <a href="<?php echo plugins_url(); ?>/simple-custom-content/readme.txt">readme.txt</a> 
									<?php _e('and', 'scs'); ?> <a href="http://perishablepress.com/simple-custom-content/"><?php _e('SCS Homepage', 'scs'); ?></a>.</li>
									<li><?php _e('If you like this plugin, please', 'sbs'); ?> 
										<a href="http://wordpress.org/support/view/plugin-reviews/<?php echo basename(dirname(__FILE__)); ?>?rate=5#postform" title="<?php _e('Click here to rate and review this plugin on WordPress.org', 'sbs'); ?>" target="_blank">
											<?php _e('rate it at the Plugin Directory', 'sbs'); ?>&nbsp;&raquo;
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div id="scs-custom-content" class="postbox">
						<h3><?php _e('Custom content for all posts and feeds', 'scs'); ?></h3>
						<div class="toggle<?php if (!$_GET["settings-updated"]) { echo ' default-hidden'; } ?>">
							<p>
								<strong><?php _e('Feeds', 'scs'); ?></strong> &ndash; <label class="description" for="scs_options[scs_all_feeds]"><?php _e('Add some custom content for your feeds. You may use text and markup.', 'scs'); ?></label><br />
								<textarea class="textarea scs-custom" cols="68" rows="5" name="scs_options[scs_all_feeds]"><?php echo esc_textarea($options['scs_all_feeds']); ?></textarea>
							</p>
							<div class="sfs-select-option">
								<p><label class="description" for="scs_options[scs_location_feeds]"><?php _e('Where should this custom content be displayed?', 'scs'); ?></label></p>
								<div>
								<?php if (!isset($checked)) $checked = '';
									foreach ($scs_location_feeds as $option) {
										$radio_setting = $options['scs_location_feeds'];
										if ('' != $radio_setting) {
											if ($options['scs_location_feeds'] == $option['value']) {
												$checked = "checked=\"checked\"";
											} else {
												$checked = '';
											}
										} ?>
									<input type="radio" name="scs_options[scs_location_feeds]" value="<?php esc_attr_e($option['value']); ?>" <?php echo $checked; ?> /> <?php echo $option['label']; ?>
									<br />
								<?php } ?>
								</div>
							</div>
							<p>
								<strong><?php _e('Posts', 'scs'); ?></strong> &ndash; <label class="description" for="scs_options[scs_all_posts]"><?php _e('Add some custom content for your posts. You may use text and markup.', 'scs'); ?></label><br />
								<textarea class="textarea scs-custom" cols="68" rows="5" name="scs_options[scs_all_posts]"><?php echo esc_textarea($options['scs_all_posts']); ?></textarea>
							</p>
							<div class="sfs-select-option">
								<p><label class="description" for="scs_options[scs_location_posts]"><?php _e('Where should this custom content be displayed?', 'scs'); ?></label></p>
								<div>
								<?php if (!isset($checked)) $checked = '';
									foreach ($scs_location_posts as $option) {
										$radio_setting = $options['scs_location_posts'];
										if ('' != $radio_setting) {
											if ($options['scs_location_posts'] == $option['value']) {
												$checked = "checked=\"checked\"";
											} else {
												$checked = '';
											}
										} ?>
									<input type="radio" name="scs_options[scs_location_posts]" value="<?php esc_attr_e($option['value']); ?>" <?php echo $checked; ?> /> <?php echo $option['label']; ?>
									<br />
								<?php } ?>
								</div>
								<p>
									<input name="scs_options[scs_enable_excerpts]" type="checkbox" value="1" <?php if (isset($options['scs_enable_excerpts'])) { checked('1', $options['scs_enable_excerpts']); } ?> /> 
									<label class="description sfs-excerpts" for="scs_options[scs_enable_excerpts]"><?php _e('Enable the custom post content in excerpts?', 'scs'); ?></label>
								</p>
							</div>
							<input type="submit" class="button-primary" value="<?php _e('Save Settings', 'scs'); ?>" />
						</div>
					</div>
					<div id="scs-custom-shortcode" class="postbox">
						<h3><?php _e('Custom content using shortcodes', 'scs'); ?></h3>
						<div class="toggle<?php if (!$_GET["settings-updated"]) { echo ' default-hidden'; } ?>">
							<p>
								<strong><label class="description" for="scs_options[scs_feed_shortcode]"><?php _e('Shortcode for specific feeds', 'scs'); ?></label></strong><br />
								<?php _e('Add some custom content (text/markup) to display for the <code>[scs_feed]</code> shortcode.', 'scs'); ?><br />
								<textarea class="textarea" cols="68" rows="5" name="scs_options[scs_feed_shortcode]"><?php echo esc_textarea($options['scs_feed_shortcode']); ?></textarea>
							</p>
							<p>
								<strong><label class="description" for="scs_options[scs_post_shortcode]"><?php _e('Shortcode for specific posts', 'scs'); ?></label></strong><br />
								<?php _e('Add some custom content (text/markup) to display for the <code>[scs_post]</code> shortcode.', 'scs'); ?><br />
								<textarea class="textarea" cols="68" rows="5" name="scs_options[scs_post_shortcode]"><?php echo esc_textarea($options['scs_post_shortcode']); ?></textarea>
							</p>
							<p>
								<strong><label class="description" for="scs_options[scs_both_shortcode]"><?php _e('Shortcode for feeds and posts', 'scs'); ?></label></strong><br />
								<?php _e('Add some custom content (text/markup) to display for the <code>[scs_both]</code> shortcode.', 'scs'); ?><br />
								<textarea class="textarea" cols="68" rows="5" name="scs_options[scs_both_shortcode]"><?php echo esc_textarea($options['scs_both_shortcode']); ?></textarea>
							</p>
							<p>
								<strong><label class="description" for="scs_options[scs_alt_shortcode]"><?php _e('Bonus shortcode for anywhere', 'scs'); ?></label></strong><br />
								<?php _e('Add some custom content (text/markup) to display for the <code>[scs_alt]</code> shortcode.', 'scs'); ?><br />
								<textarea class="textarea" cols="68" rows="5" name="scs_options[scs_alt_shortcode]"><?php echo esc_textarea($options['scs_alt_shortcode']); ?></textarea>
							</p>
							<input type="submit" class="button-primary" value="<?php _e('Save Settings', 'scs'); ?>" />
						</div>
					</div>
					<div id="scs-restore-defaults" class="postbox">
						<h3><?php _e('Restore Default Options', 'scs'); ?></h3>
						<div class="toggle<?php if (!$_GET["settings-updated"]) { echo ' default-hidden'; } ?>">
							<p> 
								<input name="scs_options[default_options]" type="checkbox" value="1" id="scs_restore_defaults" <?php if (isset($options['default_options'])) { checked('1', $options['default_options']); } ?> /> 
								<label class="description sfs-restore" for="scs_options[default_options]"><?php _e('Restore default options upon plugin deactivation/reactivation.', 'scs'); ?></label>
							</p>
							<p>
								<small>
									<?php _e('<strong>Tip:</strong> leave this option unchecked to remember your settings. Or, to go ahead and restore all default options, check the box, save your settings, and then deactivate/reactivate the plugin.', 'scs'); ?>
								</small>
							</p>
							<input type="submit" class="button-primary" value="<?php _e('Save Settings', 'scs'); ?>" />
						</div>
					</div>
					<div class="postbox">
						<h3><?php _e('Updates &amp; Info', 'scs'); ?></h3>
						<div class="toggle">
							<div id="scs-current">
								<iframe src="http://perishablepress.com/current/index-scs.html"></iframe>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="scs-credit-info">
				<a target="_blank" href="http://perishablepress.com/simple-custom-content/" title="Simple Custom Content Homepage">Simple Custom Content</a> by 
				<a target="_blank" href="http://twitter.com/perishable" title="Jeff Starr on Twitter">Jeff Starr</a> @ 
				<a target="_blank" href="http://monzilla.biz/" title="Obsessive Web Design &amp; Development">Monzilla Media</a>
			</div>
		</form>
	</div>
	<script type="text/javascript">
		// prevent accidents
		if(!jQuery("#scs_restore_defaults").is(":checked")){
			jQuery('#scs_restore_defaults').click(function(event){
				var r = confirm("<?php _e('Are you sure you want to restore all default options? (this action cannot be undone)', 'scs'); ?>");
				if (r == true){  
					jQuery("#scs_restore_defaults").attr('checked', true);
				} else {
					jQuery("#scs_restore_defaults").attr('checked', false);
				}
			});
		}
		// togglez
		jQuery(document).ready(function(){
			jQuery('#scs-toggle-panels a').click(function(){
				jQuery('.toggle').slideToggle(300);
				return false;
			});
			jQuery('.default-hidden').hide();
			jQuery('h3').click(function(){
				jQuery(this).next().slideToggle(300);
			});
			jQuery('#scs-custom-content-link').click(function(){
				jQuery('.toggle').hide();
				jQuery('#scs-custom-content .toggle').slideToggle(300);
				return true;
			});
			jQuery('#scs-custom-shortcode-link').click(function(){
				jQuery('.toggle').hide();
				jQuery('#scs-custom-shortcode .toggle').slideToggle(300);
				return true;
			});
		});
	</script>

<?php }
