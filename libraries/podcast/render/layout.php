<?php
defined( '_JEXEC' ) or die;

jimport('podcast.helper');

require JPATH_BASE . '/components/com_podcast/scripthelper.php';


class PodcastRenderException extends Exception {}

/**
 * This class mimics the PodcastViewEpisode class so that template files can
 * be reused.
 *
 * @package cwm_podcast
 * @author Joseph LeBlanc
 */
class PodcastRenderLayout
{
	public $type;
	public $layout_file;
	public $episode_id;
	public $podcast_asset_id;
	public $item;
	public $assets;
	public $asset;
	public $storage;

	public function __construct($type)
	{
		$this->type = $type;

		// must manually load the language file
		$language = JFactory::getLanguage();
		$language->load('com_podcast');
	}

	/**
	 * This function simulates the display() function of JView
	 *
	 * @return void
	 * @author Joseph LeBlanc
	 */
	public function seed_data()
	{
		JModel::addIncludePath(JPATH_BASE . '/components/com_podcast/models');

		$model = JModel::getInstance('Episode', 'PodcastModel');

		if (isset($this->episode_id)) {
			$this->item = $model->getItem($this->episode_id);
			$this->assets = $model->getAssets($this->episode_id);

			if (!count($this->assets)) {
				throw new PodcastRenderException("Error, no assets found for the episode!");
			}

			$this->asset = $this->assets[0];
		}

		if (isset($this->podcast_asset_id)) {
			$this->asset = $model->getAssetByID($this->podcast_asset_id);
		}

		$this->storage = PodcastHelper::getStorage();
	}

	public function set_layout_file()
	{
		if ($this->type == 'player') {

			if (strpos($this->asset->asset_enclosure_type, 'audio') !== false) {
				$this->layout_file = 'default_audio.php';
			} else if (strpos($this->asset->asset_enclosure_type, 'video') !== false) {
				$this->layout_file = 'default_video.php';
			} else {
				$this->layout_file = 'default_attachment.php';
			}

		} else {
			$this->layout_file = 'default.php';
		}
	}

	public function render()
	{
		$this->seed_data();
		$this->set_layout_file();

		ob_start();
		require $this->_get_template_file($this->layout_file);
		$contents = ob_get_contents();
		ob_end_clean();

		return $contents;
	}

	public function escape($var)
	{
		return htmlentities($var, ENT_COMPAT, 'UTF-8');
	}

	/**
	 * Function simulating JView
	 *
	 * @param string $name
	 * @return string
	 */
	public function loadTemplate($name)
	{
		ob_start();
		require $this->_get_template_file('default_' . $name . '.php');
		$contents = ob_get_contents();
		ob_end_clean();

		return $contents;
	}

	protected function _get_template_file($filename)
	{
		$template = JFactory::getApplication()->getTemplate();
		$override_path = JPATH_BASE . '/templates/' . $template . '/html/com_podcast/episode/' . $filename;

		if (JFile::exists($override_path)) {
			return $override_path;
		}

		return JPATH_BASE . '/components/com_podcast/views/episode/tmpl/' . $filename;
	}
}
