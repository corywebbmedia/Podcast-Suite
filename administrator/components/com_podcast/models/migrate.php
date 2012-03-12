<?php
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.model');

class PodcastModelMigrate extends JModel
{
	public $path;
	protected $old_config;
	protected $old_db;

	public function get_old_joomla_config()
	{
		if (!isset($this->old_config)) {
			$path = JPath::clean($this->path);

			$old_config = file_get_contents($path . '/configuration.php');
			$old_config = JString::str_ireplace('JConfig', 'JConfigold', $old_config);
			$old_config = JString::str_ireplace('<?php', '', $old_config);

			// Yes, I know. eval() is evil. Goats have been sacrificed to bring
			// you this code. I promise not to use it again for a long, long time.
			eval($old_config);

			$this->old_config = new JConfigold;
		}

		return $this->old_config;
	}

	public function get_old_joomla_db()
	{
		if (!isset($this->old_db)) {
			jimport('joomla.database.database.mysql');

			$config = $this->get_old_joomla_config();

			$this->old_db = JDatabase::getInstance(array(
				'host' => $config->host,
				'user' => $config->user,
				'password' => $config->password,
				'database' => $config->db,
				'prefix' => $config->dbprefix
			));
		}

		return $this->old_db;
	}

	public function import_feeds()
	{
		$db = $this->get_old_joomla_db();

		$query = $db->getQuery(true);

		$query->select("params")
				->from("#__components")
				->where("link = 'option=com_podcast'");

		$db->setQuery($query);
		$params = $db->loadResult();

		jimport('joomla.registry.format');
		$formatter = JRegistryFormat::getInstance('INI');
		$params = $formatter->stringToObject($params);

		$row = JTable::getInstance('feed', 'PodcastTable');
		$row->feed_title = $params->title;
		$row->feed_link = JURI::root(); // not defined in earlier versions, may want to change this
		$row->feed_language = JFactory::getLanguage()->getDefault(); // not defined earlier, defaulting to default
		$row->feed_copyright = $params->copyright;
		$row->feed_subtitle = $params->itSubtitle;
		$row->feed_author = $params->itAuthor;
		$row->feed_block = $params->itBlock;
		$row->feed_explicit = $params->itExplicit;
		$row->feed_keywords = $params->itKeywords;
		$row->feed_summary = $params->description;
		$row->feed_owner_name = $params->itOwnerName;
		$row->feed_owner_email = $params->itOwnerEmail;
		$row->feed_image = $params->itImage;
		$row->feed_category1 = $params->itCategory1;
		$row->feed_category2 = $params->itCategory2;
		$row->feed_category3 = $params->itCategory3;

		return $row->store();
	}
}
