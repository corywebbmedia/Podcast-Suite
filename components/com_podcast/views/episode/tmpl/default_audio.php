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
$doc->addScript(JURI::root().'media/com_podcast/js/audio-js/audio.js');
$doc->addStyleSheet(JURI::root().'media/com_podcast/js/audio-js/audio-js.css');
$doc->addScriptDeclaration('window.onload = function(){ AudioJS.setup(); }');

?>
<audio class="audio-js" controls preload>
    <source src="<?php echo $this->storage->getAssetUrl($this->asset->asset_enclosure_url); ?>">
</audio>