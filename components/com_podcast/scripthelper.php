<?php
/**
 * @author      Joseph LeBlanc - Cory Webb Media
 * @link        www.corywebbmedia.com
 * @copyright   Copyright 2012 Cory Webb Media. All Rights Reserved.
 * @category    cwm_podcast
 * @package
 */

defined( '_JEXEC' ) or die;

class PodcastScripthelper
{
	public function init_player($settings)
	{
		self::init_jquery();

		$doc = JFactory::getDocument();

		$doc->addScript(JURI::root() . 'media/com_podcast/js/jplayer/jquery.jplayer.min.js');

		// TODO: migrate this into a proper JavaScript file and bootstrap the
		// object.
		$doc->addScriptDeclaration('
		jQuery(document).ready(function(){
			  jQuery("#jquery_jplayer_' . $settings['podcast_asset_id'] . '").jPlayer({
				ready: function () {
				  jQuery(this).jPlayer("setMedia", {
					' . $settings['extension'] . ': "' . $settings['asset_url'] . '",
					poster: "' . $settings['poster'] . '"
				  });
				},
				swfPath: "' . JURI::root() . 'media/com_podcast/js/jplayer",
				supplied: "' . $settings['extension'] . '",
				cssSelectorAncestor: "#jp_container_' . $settings['podcast_asset_id'] . '"
			  });
			});
		');

	}

	public function init_jquery()
	{
		if (self::jquery_already_loaded()) {
			return true;
		}

		$doc = JFactory::getDocument();
		$doc->addScript('http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js');

		// Important: must be added as a separate file so that the ordering is
		// correct. Otherwise, <script>s floating in the <head> section can
		// call MooTools before jQuery.noConflict() is called and you still
		// conflict.
		//
		// http://www.designvsdevelop.com/jquery-in-joomla-i-was-wrong/
		//
		$doc->addScript(JURI::root() . 'media/com_podcast/js/jplayer/jquery_no_conflict.js');

		return true;
	}

	public function jquery_already_loaded()
	{
		$document = JFactory::getDocument();

		$head_data = $document->getHeadData();

		foreach (array_keys($head_data['scripts']) as $script) {
			if (stristr($script, 'jquery')) {
				return true;
			}
		}

		return false;
	}
}
