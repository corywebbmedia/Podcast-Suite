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
}
