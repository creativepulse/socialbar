<?php

/*
Plugin Name: Social Bar
Plugin URI: http://www.creativepulse.gr/en/appstore/socialbar
Version: 1.2
Description: Social Bar helps users share your website in popular social networks
License: http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
Author: Creative Pulse
Author URI: http://www.creativepulse.gr
*/


class CpExt_SocialBar extends WP_Widget {

	function __construct() {
		$options = array('classname' => 'CpExt_SocialBar', 'description' => 'Social Bar helps users share your website in popular social networks');
		$this->WP_Widget('CpExt_SocialBar', 'Social Bar', $options);
	}

	function register_widget() {
		register_widget(get_class($this));
	}

	function widget($args, $instance) {
		$dir = dirname(__FILE__);
		require($dir . '/inc/widget.php');
	}

	function update($new_instance, $old_instance) {
		$fields = array('title', 'default_link_type', 'default_custom_url', 'elements', 'custom1', 'custom2', 'custom3', 'custom4', 'custom5', 'pos_x', 'start_y', 'min_y', 'layout');
		foreach ($fields as $field) {
			$old_instance[$field] = $new_instance[$field];
		}
		return $old_instance;
	}

	function form($instance) {
		$dir = dirname(__FILE__);
		require($dir . '/inc/form.php');
	}

}

add_action('widgets_init', array('CpExt_SocialBar', 'register_widget'));

?>