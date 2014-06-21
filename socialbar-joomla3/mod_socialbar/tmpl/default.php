<?php

/**
 * Social Bar
 *
 * @version 1.3
 * @author Creative Pulse
 * @copyright Creative Pulse 2011-2014
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @link http://www.creativepulse.gr
 */


// no direct access
defined('_JEXEC') or die('Restricted access');


$document = JFactory::getDocument();
if ($widget->load_libraries(basename(__FILE__))) {
    $document->addStyleSheet('modules/mod_socialbar/tmpl/default.css');
}

$iname = 'cpwdg_socialbar_' . $widget->view_id(true);

echo '
<div id="' . $iname . '" class="cpwdg_socialbar">
';

foreach ($widget->html_elements as $element) {
    echo
'   <div class="cpwdg_socialbar_element">
' . $element . '
    </div>
';
}

echo
'</div>
';

$document->addScriptDeclaration('document.cpwdg_socialbar_conf.push({iname: "' . $widget->json_esc($iname) . '", pos_x: "' . $widget->json_esc($widget->pos_x) . '", start_y: ' . $widget->start_y . ', min_y: ' . $widget->min_y . '});');

?>