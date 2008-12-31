<?php
/*
Plugin Name: Last.fm widget
Description: Adds a sidebar widget to display a Last.fm recent played music and top albums music quilt.
Author: OcELL
Version: 2.0
Author URI: http://www.ridersofthebit.net
Plugin URI: http://wordpress.org/extend/plugins/lastfm-widget/
*/

// This gets called at the plugins_loaded action
function widget_lastfm_init() {
	// Check for the required API functions
	if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
		return;
	// This function prints the sidebar widget--the cool stuff!
	function widget_lastfm($args) {
		// $args is an array of strings which help your widget
  	// conform to the active theme: before_widget, before_title,
  	// after_widget, and after_title are the array keys.
  	extract($args);
  	// Collect our widget's options, or define their defaults.
  	$options = get_option('widget_lastfm');
  	$title = empty($options['title']) ? 'lastfm' : $options['title'];
  	$user = empty($options['user']) ? 'no user' : $options['user'];
  	$color = empty($options['color']) ? 'blue' : $options['color'];
  	$show_quilts = empty($options['show_quilts']) ? 0 : $options['show_quilts'];
  	$show_charts = empty($options['show_charts']) ? 0 : $options['show_charts'];
  	// Recently Listened Tracks chart.
  	$charts = "<style type=\"text/css\">table.lfmWidgetchart_975e74de31f143cee1218f46aa053118 td {margin:0 !important;padding:0 !important;border:0 !important;}table.lfmWidgetchart_975e74de31f143cee1218f46aa053118 tr.lfmHead a:hover {background:url(http://cdn.last.fm/widgets/images/en/header/chart/recenttracks_regular_$color.png) no-repeat 0 0 !important;}table.lfmWidgetchart_975e74de31f143cee1218f46aa053118 tr.lfmEmbed object {float:left;}table.lfmWidgetchart_975e74de31f143cee1218f46aa053118 tr.lfmFoot td.lfmConfig a:hover {background:url(http://cdn.last.fm/widgets/images/en/footer/$color.png) no-repeat 0px 0 !important;;}table.lfmWidgetchart_975e74de31f143cee1218f46aa053118 tr.lfmFoot td.lfmView a:hover {background:url(http://cdn.last.fm/widgets/images/en/footer/$color.png) no-repeat -85px 0 !important;}table.lfmWidgetchart_975e74de31f143cee1218f46aa053118 tr.lfmFoot td.lfmPopup a:hover {background:url(http://cdn.last.fm/widgets/images/en/footer/$color.png) no-repeat -159px 0 !important;}</style>
<table class=\"lfmWidgetchart_975e74de31f143cee1218f46aa053118\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:184px;\"><tr class=\"lfmHead\"><td><a title=\"$user: Recently Listened Tracks\" href=\"http://www.last.fm/user/$user\" target=\"_blank\" style=\"display:block;overflow:hidden;height:20px;width:184px;background:url(http://cdn.last.fm/widgets/images/en/header/chart/recenttracks_regular_$color.png) no-repeat 0 -20px;text-decoration:none;border:0;\"></a></td></tr><tr class=\"lfmEmbed\"><td><object type=\"application/x-shockwave-flash\" data=\"http://cdn.last.fm/widgets/chart/friends_6.swf\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0\" id=\"lfmEmbed_461539035\" width=\"184\" height=\"199\"> <param name=\"movie\" value=\"http://cdn.last.fm/widgets/chart/friends_6.swf\" /> <param name=\"flashvars\" value=\"type=recenttracks&amp;user=$user&amp;theme=$color&amp;lang=en&amp;widget_id=chart_975e74de31f143cee1218f46aa053118\" /> <param name=\"allowScriptAccess\" value=\"always\" /> <param name=\"allowNetworking\" value=\"all\" /> <param name=\"allowFullScreen\" value=\"true\" /> <param name=\"quality\" value=\"high\" /> <param name=\"bgcolor\" value=\"6598cd\" /> <param name=\"wmode\" value=\"transparent\" /> <param name=\"menu\" value=\"true\" /> </object></td></tr><tr class=\"lfmFoot\"><td style=\"background:url(http://cdn.last.fm/widgets/images/footer_bg/$color.png) repeat-x 0 0;text-align:right;\"><table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" style=\"width:184px;\"><tr><td class=\"lfmConfig\"><a href=\"http://www.last.fm/widgets/?colour=$color&amp;chartType=recenttracks&amp;user=$user&amp;chartFriends=1&amp;from=code&amp;widget=chart\" title=\"Get your own widget\" target=\"_blank\" style=\"display:block;overflow:hidden;width:85px;height:20px;float:right;background:url(http://cdn.last.fm/widgets/images/en/footer/$color.png) no-repeat 0px -20px;text-decoration:none;border:0;\"></a></td><td class=\"lfmView\" style=\"width:74px;\"><a href=\"http://www.last.fm/user/$user\" title=\"View $user's profile\" target=\"_blank\" style=\"display:block;overflow:hidden;width:74px;height:20px;background:url(http://cdn.last.fm/widgets/images/en/footer/$color.png) no-repeat -85px -20px;text-decoration:none;border:0;\"></a></td><td class=\"lfmPopup\"style=\"width:25px;\"><a href=\"http://www.last.fm/widgets/popup/?colour=$color&amp;chartType=recenttracks&amp;user=$user&amp;chartFriends=1&amp;from=code&amp;widget=chart&amp;resize=1\" title=\"Load this chart in a pop up\" target=\"_blank\" style=\"display:block;overflow:hidden;width:25px;height:20px;background:url(http://cdn.last.fm/widgets/images/en/footer/$color.png) no-repeat -159px -20px;text-decoration:none;border:0;\" onclick=\"window.open(this.href + '&amp;resize=0','lfm_popup','height=299,width=234,resizable=yes,scrollbars=yes'); return false;\"></a></td></tr></table></td></tr></table>";
    // Top albums music quilt.
  	$quilts = "<style type=\"text/css\">table.lfmWidgetquilt_653334f9b901a6a92e7af1333e1aaf43 td {margin:0 !important;padding:0 !important;border:0 !important;}table.lfmWidgetquilt_653334f9b901a6a92e7af1333e1aaf43 tr.lfmHead a:hover {background:url(http://cdn.last.fm/widgets/images/en/header/quilt/album_vertical_$color.png) no-repeat 0 0 !important;}table.lfmWidgetquilt_653334f9b901a6a92e7af1333e1aaf43 tr.lfmEmbed object {float:left;}table.lfmWidgetquilt_653334f9b901a6a92e7af1333e1aaf43 tr.lfmFoot td.lfmConfig a:hover {background:url(http://cdn.last.fm/widgets/images/en/footer/$color.png) no-repeat 0px 0 !important;;}table.lfmWidgetquilt_653334f9b901a6a92e7af1333e1aaf43 tr.lfmFoot td.lfmView a:hover {background:url(http://cdn.last.fm/widgets/images/en/footer/$color.png) no-repeat -85px 0 !important;}table.lfmWidgetquilt_653334f9b901a6a92e7af1333e1aaf43 tr.lfmFoot td.lfmPopup a:hover {background:url(http://cdn.last.fm/widgets/images/en/footer/$color.png) no-repeat -159px 0 !important;}</style>
<table class=\"lfmWidgetquilt_653334f9b901a6a92e7af1333e1aaf43\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:184px;\"><tr class=\"lfmHead\"><td><a title=\"Top albums\" href=\"http://www.last.fm/user/$user/charts\" target=\"_blank\" style=\"display:block;overflow:hidden;height:20px;width:184px;background:url(http://cdn.last.fm/widgets/images/en/header/quilt/album_vertical_$color.png) no-repeat 0 -20px;text-decoration:none;border:0;\"></a></td></tr><tr class=\"lfmEmbed\"><td><object type=\"application/x-shockwave-flash\" data=\"http://cdn.last.fm/widgets/quilt/13.swf\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0\" id=\"lfmEmbed_1212036793\" width=\"184\" height=\"270\"> <param name=\"movie\" value=\"http://cdn.last.fm/widgets/quilt/13.swf\" /> <param name=\"flashvars\" value=\"type=user&amp;variable=$user&amp;file=topalbums&amp;bgColor=$color&amp;theme=$color&amp;lang=en&amp;widget_id=quilt_653334f9b901a6a92e7af1333e1aaf43\" /> <param name=\"allowScriptAccess\" value=\"always\" /> <param name=\"allowNetworking\" value=\"all\" /> <param name=\"allowFullScreen\" value=\"true\" /> <param name=\"quality\" value=\"high\" /> <param name=\"bgcolor\" value=\"6598cd\" /> <param name=\"wmode\" value=\"transparent\" /> <param name=\"menu\" value=\"true\" /> </object></td></tr><tr class=\"lfmFoot\"><td style=\"background:url(http://cdn.last.fm/widgets/images/footer_bg/$color.png) repeat-x 0 0;text-align:right;\"><table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" style=\"width:184px;\"><tr><td class=\"lfmConfig\"><a href=\"http://www.last.fm/widgets/?url=user%2F$user%2Fpersonal&amp;colour=$color&amp;quiltType=album&amp;orient=vertical&amp;height=small&amp;from=code&amp;widget=quilt\" title=\"Get your own widget\" target=\"_blank\" style=\"display:block;overflow:hidden;width:85px;height:20px;float:right;background:url(http://cdn.last.fm/widgets/images/en/footer/$color.png) no-repeat 0px -20px;text-decoration:none;border:0;\"></a></td><td class=\"lfmView\" style=\"width:74px;\"><a href=\"http://www.last.fm/user/$user\" title=\"View $user's profile\" target=\"_blank\" style=\"display:block;overflow:hidden;width:74px;height:20px;background:url(http://cdn.last.fm/widgets/images/en/footer/$color.png) no-repeat -85px -20px;text-decoration:none;border:0;\"></a></td><td class=\"lfmPopup\"style=\"width:25px;\"><a href=\"http://www.last.fm/widgets/popup/?url=user%2F$user%2Fpersonal&amp;colour=$color&amp;quiltType=album&amp;orient=vertical&amp;height=small&amp;from=code&amp;widget=quilt&amp;resize=1\" title=\"Load this quilt in a pop up\" target=\"_blank\" style=\"display:block;overflow:hidden;width:25px;height:20px;background:url(http://cdn.last.fm/widgets/images/en/footer/$color.png) no-repeat -159px -20px;text-decoration:none;border:0;\" onclick=\"window.open(this.href + '&amp;resize=0','lfm_popup','height=370,width=234,resizable=yes,scrollbars=yes'); return false;\"></a></td></tr></table></td></tr></table>";
   	// It's important to use the $before_widget, $before_title,
   	// $after_title and $after_widget variables in your output.
  	echo $before_widget;
  	echo $before_title . $title . $after_title;
  	if ( $show_charts ) {
    	echo $charts;
  	}
  	if ( $show_quilts ) {
    	echo $quilts;
  	}
  	echo $after_widget;
}
	// This saves options and prints the widget's config form.
	function widget_lastfm_control() {
		$options = $newoptions = get_option('widget_lastfm');
		if ( $_POST['lastfm-submit'] ) {
			$newoptions['title'] = strip_tags(stripslashes($_POST['lastfm-title']));
			$newoptions['user'] = strip_tags(stripslashes($_POST['lastfm-user']));
			$newoptions['color'] = strip_tags(stripslashes($_POST['lastfm-color']));
			$newoptions['show_quilts'] = strip_tags(stripslashes($_POST['lastfm-showquilts']));
			$newoptions['show_charts'] = strip_tags(stripslashes($_POST['lastfm-showcharts']));
		}
		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('widget_lastfm', $options);
		}
		// Format options as valid HTML. Hey, why not.
		$title = htmlspecialchars($options['title'], ENT_QUOTES);
		$user = htmlspecialchars($options['user'], ENT_QUOTES);
		$color = htmlspecialchars($options['color'], ENT_QUOTES);
		$show_quilts = htmlspecialchars($options['show_quilts'], ENT_QUOTES);
		$show_charts = htmlspecialchars($options['show_charts'], ENT_QUOTES);
?>		
<div>			
  <label for="lastfm-title" style="line-height:35px;display:block;">
    <?php _e('Title:', 'widgets'); ?>				
    <input type="text" id="lastfm-title" name="lastfm-title" value="<?php echo wp_specialchars($title, true); ?>" />			
  </label>
  <label for="lastfm-user" style="line-height:35px;display:block;">
    <?php _e('User:', 'widgets'); ?>				
    <input type="text" id="lastfm-user" name="lastfm-user" value="<?php echo wp_specialchars($user, true); ?>" />			
  </label>
  <label for="lastfm-color" style="line-height:35px;display:block;">
    <?php _e('Color:', 'widgets'); ?>				
    <input type="text" id="lastfm-color" name="lastfm-color" value="<?php echo wp_specialchars($color, true); ?>" />			
  </label>
  <label for="lastfm-showcharts" style="line-height:35px;display:block;">
    <?php _e('Show charts:', 'widgets'); ?>				
    <input type="checkbox" id="lastfm-showcharts" name="lastfm-showcharts" <? if($show_charts) { echo 'checked="yes"'; } ?> value="1" />			
  </label>
  <label for="lastfm-showquilts" style="line-height:35px;display:block;">
    <?php _e('Show quilts:', 'widgets'); ?>				
    <input type="checkbox" id="lastfm-showquilts" name="lastfm-showquilts" <? if($show_quilts) { echo 'checked="yes"'; } ?> value="1" />			
  </label>			
  <input type="hidden" name="lastfm-submit" id="lastfm-submit" value="1" />		
</div>
<?php
	}
	// Tell Dynamic Sidebar about our new widget and its control
	register_sidebar_widget(array('lastfm', 'widgets'), 'widget_lastfm');
	register_widget_control(array('lastfm', 'widgets'), 'widget_lastfm_control');
}
// Delay plugin execution to ensure Dynamic Sidebar has a chance to load first
add_action('widgets_init', 'widget_lastfm_init');
?>