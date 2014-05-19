<?php

/**
 * Social Bar
 *
 * @version 1.2
 * @author Creative Pulse
 * @copyright Creative Pulse 2011-2014
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @link http://www.creativepulse.gr
 */


$instance = wp_parse_args(
	(array) $instance,
	array(
		'title' => '',
		'default_link_type' => 'active',
		'default_custom_url' => '',
		'elements' => '',
		'custom1' => '',
		'custom2' => '',
		'custom3' => '',
		'custom4' => '',
		'custom5' => '',
		'pos_x' => '',
		'start_y' => '',
		'min_y' => '',
		'layout' => '',
	)
);

$default_name = '';
$layouts = array();
$path = $dir . '/widget_layouts';
if ($dp = @opendir($path)) {
	while (false !== ($file = readdir($dp))) {
		if (preg_match('/^(.*)\.php$/', $file, $m)) {
			if (strtolower($m[1]) == 'default') {
				$default_name = $m[1];
			}
			else {
				$layouts[] = $m[1];
			}
		}
	}
	closedir($dp);

	sort($layouts);
}
else {
	echo __('Error: Unable to open widget layouts directory');
	return;
}

if ($default_name) {
	array_unshift($layouts, $default_name);
	if (empty($instance['layout'])) {
		$instance['layout'] = $default_name;
	}
}

echo
'<p><label for="' . $this->get_field_id('title') . '">' . __('Title') . ':</label>
	<input class="widefat" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . esc_attr($instance['title']) . '" />
</p>

<p><label for="' . $this->get_field_id('default_link_type') . '">' . __('Default link type') . ':</label>
	<select class="widefat" id="' . $this->get_field_id('default_link_type') . '" name="' . $this->get_field_name('default_link_type') . '">
		<option value="active">' . __('Active URL') . '</option>
		<option value="home">' . __('Home URL') . '</option>
		<option value="custom">' . __('Custom URL') . '</option>
	</select>
</p>

<p><label for="' . $this->get_field_id('default_custom_url') . '">' . __('Default custom URL') . ':</label>
	<input class="widefat" id="' . $this->get_field_id('default_custom_url') . '" name="' . $this->get_field_name('default_custom_url') . '" type="text" value="' . esc_attr($instance['default_custom_url']) . '" />
</p>

<p><label for="' . $this->get_field_id('elements') . '">' . __('Elements') . ':</label>
	<textarea class="widefat" id="' . $this->get_field_id('elements') . '" name="' . $this->get_field_name('elements') . '" rows="8">' . esc_textarea($instance['elements']) . '</textarea>
</p>

<p><label for="' . $this->get_field_id('custom1') . '">' . __('Custom 1') . ':</label>
	<textarea class="widefat" id="' . $this->get_field_id('custom1') . '" name="' . $this->get_field_name('custom1') . '" rows="3">' . esc_textarea($instance['custom1']) . '</textarea>
</p>

<p><label for="' . $this->get_field_id('custom2') . '">' . __('Custom 2') . ':</label>
	<textarea class="widefat" id="' . $this->get_field_id('custom2') . '" name="' . $this->get_field_name('custom2') . '" rows="3">' . esc_textarea($instance['custom2']) . '</textarea>
</p>

<p><label for="' . $this->get_field_id('custom3') . '">' . __('Custom 3') . ':</label>
	<textarea class="widefat" id="' . $this->get_field_id('custom3') . '" name="' . $this->get_field_name('custom3') . '" rows="3">' . esc_textarea($instance['custom3']) . '</textarea>
</p>

<p><label for="' . $this->get_field_id('custom4') . '">' . __('Custom 4') . ':</label>
	<textarea class="widefat" id="' . $this->get_field_id('custom4') . '" name="' . $this->get_field_name('custom4') . '" rows="3">' . esc_textarea($instance['custom4']) . '</textarea>
</p>

<p><label for="' . $this->get_field_id('custom5') . '">' . __('Custom 5') . ':</label>
	<textarea class="widefat" id="' . $this->get_field_id('custom5') . '" name="' . $this->get_field_name('custom5') . '" rows="3">' . esc_textarea($instance['custom5']) . '</textarea>
</p>

<p><label for="' . $this->get_field_id('pos_x') . '">' . __('Position X') . ':</label>
	<input class="widefat" id="' . $this->get_field_id('pos_x') . '" name="' . $this->get_field_name('pos_x') . '" type="text" value="' . esc_attr($instance['pos_x']) . '" />
</p>

<p><label for="' . $this->get_field_id('start_y') . '">' . __('Opening Y position') . ':</label>
	<input class="widefat" id="' . $this->get_field_id('start_y') . '" name="' . $this->get_field_name('start_y') . '" type="text" value="' . esc_attr($instance['start_y']) . '" />
</p>

<p><label for="' . $this->get_field_id('min_y') . '">' . __('Minimum Y position') . ':</label>
	<input class="widefat" id="' . $this->get_field_id('min_y') . '" name="' . $this->get_field_name('min_y') . '" type="text" value="' . esc_attr($instance['min_y']) . '" />
</p>

<p><label for="' . $this->get_field_id('layout') . '">' . __('Layout') . ':</label>
	<select class="widefat" id="' . $this->get_field_id('layout') . '" name="' . $this->get_field_name('layout') . '">
';

foreach ($layouts as $layout) {
	echo
'		<option value="' . htmlspecialchars($layout) . '"' . ($instance['layout'] == $layout ? ' selected="selected"' : '') . '>' . htmlspecialchars($layout) . '</option>
';
}

echo
'	</select>
</p>
';

?>