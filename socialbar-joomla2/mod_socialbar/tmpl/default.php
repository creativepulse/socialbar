<?php

/**
 * social bar
 *
 * @version 1.1
 * @author Creative Pulse
 * @copyright Creative Pulse 2011-2013
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @link http://www.creativepulse.gr
 */

// no direct access
defined('_JEXEC') or die('Restricted access');


$document = JFactory::getDocument();
if ($mod->instance_id() == 1) {
    $document->addStyleSheet('modules/mod_socialbar/tpl_default/mod.css');
}

echo
'<table id="mod_socialbar_' . $mod->instance_id() . '" class="mod_socialbar"><tr><td>
    <div class="mod_socialbar_tr">
        <div class="mod_socialbar_tc"></div>
        <div class="mod_socialbar_tc_body"></div>
    </div>
    <div class="mod_socialbar_mr"><div class="mod_socialbar_mc">
        <div class="mod_socialbar_vgap"></div>

        <div class="mod_socialbar_cnt">
            <img src="modules/mod_socialbar/tpl_default/socialbar.png" alt="Social Bar" />
        </div>
        <div class="mod_socialbar_vgap"></div>

        <div id="mod_socialbar_' . $mod->instance_id() . '_cnt" class="mod_socialbar_cnt">
';

foreach ($mod->html_elements as $element) {
    echo
'           <div class="mod_socialbar_element">
' . $element . '
            </div>
            <div class="mod_socialbar_vgap"></div>
';
}

echo '
        </div>

        <div class="mod_socialbar_cnt">
            <div id="mod_socialbar_' . $mod->instance_id() . '_btn_openclose" class="mod_socialbar_btn_close"></div>
        </div>

        <div class="mod_socialbar_vgap"></div>
    </div></div>
    <div class="mod_socialbar_br">
        <div class="mod_socialbar_bc_body"></div>
        <div class="mod_socialbar_bc"></div>
    </div>
</td></tr></table>
';

?>