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
defined( '_JEXEC' ) or die( 'Restricted access' );


if (!class_exists('Mod_SocialBar')) {
    
    class Mod_SocialBar {

        function instance_id($new = false) {
            static $num = 0;

            if ($new) {
                $num++;
            }

            return $num;
        }

        function prepare($params) {
            $id = $this->instance_id(true);
            
            $this->html_elements = array();


            // find default link url
            switch ($params->get('default_link_type', '')) {
                case 'home':
                    $default_url = JURI::base();
                    break;

                case 'custom':
                    $default_url = trim($params->get('default_custom_url', ''));
                    break;

                case 'active':
                default:
                    $default_url = 'http' . (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) != 'off' ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            }
            
            
            // prepare custom html elements
            $document =& JFactory::getDocument();
            $custom_elements = array();
            for ($i = 1; $i <= 5; $i++) {
                $st = trim($params->get('custom' . $i, ''));
                $st = preg_replace('/\[\s*TITLE\s*\]/i', htmlspecialchars($document->title), $st);
                $st = preg_replace('/\[\s*LINK\s*\]/i', $default_url, $st);
                $custom_elements['custom' . $i] = $st;
            }

            // process elements
            $elements = $params->get('elements', '');
            $elements = str_replace("\r", '', $elements);
            $elements = explode("\n", $elements);
            foreach ($elements as $element) {
                $e = explode('::', $element);
                $pars = array();
                for ($i = 1, $len = count($e); $i < $len; $i++) {
                    $p = explode('=', $e[$i], 2);
                    if (!empty($p[0])) {
                        $pars[strtolower(trim($p[0]))] = empty($p[1]) ? true : trim($p[1]);
                    }
                }

                $url = isset($pars['url']) ? $pars['url'] : $default_url;

                $html = '';
                $cmd = strtolower($e[0]);
                switch ($cmd) {
                    case 'html':
                        $html = (string) @$pars['txt'];
                        break;

                    case 'custom1':
                    case 'custom2':
                    case 'custom3':
                    case 'custom4':
                    case 'custom5':
                        $html = $custom_elements[$cmd];
                        break;

                    case 'email':
                        $html =
'<a href="mailto:?subject=' . rawurlencode($document->title) . '&amp;body=' . rawurlencode($url) . '"><img src="modules/mod_socialbar/tpl_default/btn_email.png"></a>
';
                        break;

                    case 'rss':
                        $html =
'<a href="' . $pars['url'] . '"><img src="modules/mod_socialbar/tpl_default/btn_rss.png"></a>
';
                        break;

                    case 'link':
                        $html = '<a href="' . $url . '">';

                        if (!empty($pars['img'])) {
                            $html .= '<img src="' . $pars['img'] . '" alt="" />';
                        }

                        if (!empty($pars['txt'])) {
                            $html .= $pars['txt'];
                        }

                        $html .= '</a>';

                        break;

                    case 'facebook-share':
                        $html =
'<a name="fb_share" type="button" share_url="' . htmlspecialchars($url) . '"></a> 
<script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script>
';
                        break;

                    case 'facebook-like-count':
                        $html =
'<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
<fb:like href="' . htmlspecialchars($url) . '" layout="box_count" show_faces="false" width="55"></fb:like>
';
                        break;

                    case 'twitter':
                        $html =
'<a href="http://twitter.com/share" class="twitter-share-button" data-url="' . htmlspecialchars($url) . '" data-count="none">Tweet</a>
<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
';
                        break;

                    case 'twitter-count':
                        $html =
'<a href="http://twitter.com/share" class="twitter-share-button" data-url="' . htmlspecialchars($url) . '" data-count="vertical">Tweet</a>
<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
';
                        break;

                    case 'stumble':
                        $html =
'<script src="http://www.stumbleupon.com/hostedbadge.php?s=6&amp;r=' . htmlspecialchars($url) . '"></script>
';
                        break;

                    case 'stumble-count':
                        $html =
'<script src="http://www.stumbleupon.com/hostedbadge.php?s=5&amp;r=' . htmlspecialchars($url) . '"></script>
';
                        break;

                }

                if ($html != '') {
                    $this->html_elements[] = $html;
                }
            }

            // output javascript calls
            if ($id == 1) {
                $document->addScript('modules/mod_socialbar/js/mod_socialbar.js');
                $document->addScriptDeclaration('document.mod_socialbar_conf = [];');
            }
            $document->addScriptDeclaration('document.mod_socialbar_conf.push({ iname: "mod_socialbar_' . $id . '", idx: ' . $id . ', start_y: ' . intval($params->get('start_y', 0)) . ', min_y: ' . intval($params->get('min_y', 0)) . ' })');
        }
    }
}

?>