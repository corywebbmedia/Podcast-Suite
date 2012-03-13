<?php

/**
 * @author      Jeremy Wilken - Cory Webb Media
 * @link        www.corywebbmedia.com
 * @copyright   Copyright 2012 Cory Webb Media. All Rights Reserved.
 * @category    cwm_podcast
 * @package     
 */

defined('_JEXEC') or die;

?>
<a href="<?php echo $this->storage->getAssetUrl($this->asset->asset_enclosure_url); ?>"><?php echo $this->asset->asset_enclosure_url; ?></a>