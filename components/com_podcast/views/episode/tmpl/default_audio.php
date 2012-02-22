<?php

/**
 * @author      Jeremy Wilken - Cory Webb Media
 * @link        www.corywebbmedia.com
 * @copyright   Copyright 2012 Cory Webb Media. All Rights Reserved.
 * @category    cwm_podcast
 * @package     
 */

defined('_JEXEC') or die;

$doc = JFactory::getDocument();
$doc->addScript('http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js');
$doc->addScript(JURI::root().'media/com_podcast/js/jplayer/jquery.jplayer.min.js');
$doc->addStyleSheet(JURI::root().'media/com_podcast/js/jplayer/skins/blue.monday/jplayer.blue.monday.css');

$extension = $this->storage->getAssetExtension($this->asset->asset_enclosure_url);

$doc->addScriptDeclaration('
jQuery.noConflict();
jQuery(document).ready(function(){
      jQuery("#jquery_jplayer_'.$this->item->episode_id.'").jPlayer({
        ready: function () {
          jQuery(this).jPlayer("setMedia", {
            '.$extension.': "'.$this->storage->getAssetUrl($this->asset->asset_enclosure_url).'"
          });
        },
        swfPath: "'.JURI::root().'media/com_podcast/js/jplayer",
        supplied: "'.$extension.'",
        cssSelectorAncestor: "#jp_container_'.$this->item->episode_id.'"
      });
    });
');

?>

<div id="jquery_jplayer_<?php echo $this->item->episode_id; ?>" class="jp-jplayer"></div>
  <div id="jp_container_<?php echo $this->item->episode_id; ?>" class="jp-audio">
    <div class="jp-type-single">
      <div class="jp-gui jp-interface">
        <ul class="jp-controls">
          <li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
          <li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
          <li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
          <li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
          <li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
          <li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
        </ul>
        <div class="jp-progress">
          <div class="jp-seek-bar">
            <div class="jp-play-bar"></div>
          </div>
        </div>
        <div class="jp-volume-bar">
          <div class="jp-volume-bar-value"></div>
        </div>
        <div class="jp-time-holder">
          <div class="jp-current-time"></div>
          <div class="jp-duration"></div>
          <ul class="jp-toggles">
            <li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
            <li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>
          </ul>
        </div>
      </div>
      <div class="jp-no-solution">
        <span>Update Required</span>
        To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
      </div>
    </div>
  </div>