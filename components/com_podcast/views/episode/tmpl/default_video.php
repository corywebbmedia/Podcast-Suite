<?php
/**
 * @author		Jeremy Wilken - Cory Webb Media
 * @link		www.corywebbmedia.com
 * @copyright	Copyright 2012 Cory Webb Media. All Rights Reserved.
 * @category	cwm_podcast
 * @package
 */
defined('_JEXEC') or die;

$doc = JFactory::getDocument();
$doc->addScript('http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js');
$doc->addScript(JURI::root() . 'media/com_podcast/js/jplayer/jquery.jplayer.min.js');
$doc->addStyleSheet(JURI::root() . 'media/com_podcast/js/jplayer/skins/blue.monday/jplayer.blue.monday.css');

$extension = $this->storage->getAssetExtension($this->asset->asset_enclosure_url);

$doc->addScriptDeclaration('
jQuery.noConflict();
jQuery(document).ready(function(){
	  jQuery("#jquery_jplayer_' . $this->item->episode_id . '").jPlayer({
		ready: function () {
		  jQuery(this).jPlayer("setMedia", {
			' . $extension . ': "' . $this->storage->getAssetUrl($this->asset->asset_enclosure_url) . '",
			poster: "' . JURI::root() . $this->item->item_image . '"
		  });
		},
		swfPath: "' . JURI::root() . 'media/com_podcast/js/jplayer",
		supplied: "' . $extension . '",
		cssSelectorAncestor: "#jp_container_' . $this->item->episode_id . '"
	  });
	});
');
?>

<div id="jp_container_<?php echo $this->item->episode_id; ?>" class="jp-video">
	<div class="jp-type-single">
		<div id="jquery_jplayer_<?php echo $this->item->episode_id; ?>" class="jp-jplayer"></div>
		<div class="jp-gui">
			<div class="jp-video-play">
				<a href="javascript:;" class="jp-video-play-icon" tabindex="1"><?php echo JText::_('COM_PODCAST_PLAYER_VIDEO_PLAY') ?></a>
			</div>
			<div class="jp-interface">
				<div class="jp-progress">
					<div class="jp-seek-bar">
						<div class="jp-play-bar"><span class="jp-play-icon"></span></div>
					</div>
				</div>
				<div class="jp-current-time"></div>
				<div class="jp-duration"></div>
				<div class="jp-controls-holder">
					<ul class="jp-controls">
						<li><a href="javascript:;" class="jp-play" tabindex="1"><?php echo JText::_('COM_PODCAST_PLAYER_VIDEO_PLAY') ?></a></li>
						<li><a href="javascript:;" class="jp-pause" tabindex="1"><?php echo JText::_('COM_PODCAST_PLAYER_VIDEO_PAUSE') ?></a></li>
						<li><a href="javascript:;" class="jp-stop" tabindex="1"><?php echo JText::_('COM_PODCAST_PLAYER_VIDEO_STOP') ?></a></li>
						<li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute"><?php echo JText::_('COM_PODCAST_PLAYER_VIDEO_MUTE') ?></a></li>
						<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute"><?php echo JText::_('COM_PODCAST_PLAYER_VIDEO_UNMUTE') ?></a></li>
						<li>
							<div class="jp-volume-bar">
								<div class="jp-volume-bar-value"></div>
							</div>
						</li>
						<li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume"><?php echo JText::_('COM_PODCAST_PLAYER_VIDEO_MAXVOLUME') ?></a></li>
						<li><a href="javascript:;" class="jp-full-screen" tabindex="1" title="full screen"><?php echo JText::_('COM_PODCAST_PLAYER_VIDEO_FULLSCREEN') ?></a></li>
						<li><a href="javascript:;" class="jp-restore-screen" tabindex="1" title="restore screen"><?php echo JText::_('COM_PODCAST_PLAYER_VIDEO_RESTORESCREEN') ?></a></li>
						<li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat"><?php echo JText::_('COM_PODCAST_PLAYER_VIDEO_REPEAT') ?></a></li>
						<li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off"><?php echo JText::_('COM_PODCAST_PLAYER_VIDEO_REPEATOFF') ?></a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="jp-no-solution">
			<span><?php echo JText::_('COM_PODCAST_PLAYER_VIDEO_UPDATEREQUIRED') ?></span>
			<?php echo JText::_('COM_PODCAST_PLAYER_VIDEO_UPDATEREQUIRED_DESC') ?>
		</div>
	</div>
</div>