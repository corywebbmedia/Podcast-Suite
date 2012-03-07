<?php
defined( '_JEXEC' ) or die;

jimport('podcast.helper');

require JPATH_BASE . '/components/com_podcast/scripthelper.php';


/**
 * This class mimics the PodcastViewEpisode class so that template files can
 * be reused.
 *
 * @package cwm_podcast
 * @author Joseph LeBlanc
 */
class PodcastRenderLayout
{
	public $layout_file;
	public $episode_id;
	public $item;
	public $assets;
	public $storage;

	public function __construct($file, $episode_id)
	{
		$this->layout_file = $file;
		$this->episode_id = $episode_id;
		$this->seed_data();
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

		$this->item = $model->getItem($this->episode_id);
		$this->assets = $model->getAssets($this->episode_id);
		$this->asset = $this->assets[0];
		$this->storage = PodcastHelper::getStorage();
	}

	public function render()
	{
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
		$override_path = JPATH_BASE . '/' . $template . '/html/com_podcast/episode/' . $filename;

		if (JFile::exists($override_path)) {
			return $override_path;
		}

		return JPATH_BASE . '/components/com_podcast/views/episode/tmpl/' . $filename;
	}
}
