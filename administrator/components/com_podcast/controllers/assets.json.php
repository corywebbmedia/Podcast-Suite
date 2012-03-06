<?php
/**
 * @author      Joseph LeBlanc - Cory Webb Media
 * @link        www.corywebbmedia.com
 * @copyright   Copyright 2012 Cory Webb Media. All Rights Reserved.
 * @category    cwm_podcast
 * @package
 */
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.controller');
jimport('podcast.helper');

class PodcastControllerAssets extends JController
{
	public function list_episode_assets()
	{
		$episode_id = JRequest::getInt('episode_id', 0);

		$db = JFactory::getDBO();
		$query = $db->getQuery(true);

		$query->select('podcast_asset_id, asset_enclosure_url, asset_duration, `default` AS asset_default, asset_enclosure_type, asset_enclosure_length')
			->from('#__podcast_assets_map')
			->join('LEFT', '#__podcast_assets USING(podcast_asset_id)')
			->where("enabled = '1'")
			->where("episode_id = '{$episode_id}'");

		$db->setQuery($query);
		echo json_encode($db->loadObjectList());
	}

	public function list_available_assets()
	{
		$page = JRequest::getInt('page', 0);
		$search = JRequest::getString('search', '');

		$db = JFactory::getDBO();
		$query = $db->getQuery(true);

		$query->select('SQL_CALC_FOUND_ROWS *')
			->from('#__podcast_assets')
			->where("enabled = '1'");

		if ($search) $query->where('asset_enclosure_url LIKE "%'.$search.'%"');

		$db->setQuery($query, $page * 10, 10);
		$db->query();

		$response = new stdClass();

		$response->items = $db->loadObjectList();

		$db->setQuery('SELECT FOUND_ROWS();');

		jimport('joomla.html.pagination');

		$pagination = new JPagination( $db->loadResult(), $page * 10, 10);
		$response->pagination->total = $pagination->{'pages.total'};
		$response->pagination->current = $pagination->{'pages.current'};
		$response->pagination->start = $pagination->{'pages.start'};
		$response->pagination->stop = $pagination->{'pages.stop'};
		$response->pagination->previous = ($pagination->{'pages.current'} > 1) ? $pagination->{'pages.current'} - 1 : 1;
		$response->pagination->next = ($pagination->{'pages.current'} < $pagination->{'pages.total'} - 1) ? $pagination->{'pages.current'} + 1 : $pagination->{'pages.total'};

		echo json_encode($response);
	}

	public function add_custom_asset()
	{
		$asset = JRequest::getVar('asset', '{}');

		$db = JFactory::getDBO();

		$db->setQuery(
				$db->getQuery(true)
				->insert('#__podcast_assets')
				->columns('asset_enclosure_url', 'asset_enclosure_length', 'asset_enclosure_type', 'asset_duration', 'asset_closed_captioned', 'storage_engine')
				->values($db->quote($asset['asset_enclosure_url']), $db->quote($asset['asset_enclosure_length']), $db->quote($asset['asset_enclosure_type']), $db->quote($asset['asset_duration']), $db->quote($asset['asset_closed_caption'], 'custom'))
		)->query();

		$result = $db->insertid();

		print $result;
	}

	public function create_folder()
	{
		JRequest::checkToken() or jexit( JText::_('JINVALID_TOKEN') );

		$folder = JRequest::getVar('folder', '');

		$storage = PodcastHelper::getStorage();

		if ($storage->createFolder($folder)) {
			$status = 'success';
		} else {
			$status = 'fail';
		}

		echo json_encode(array('status' => $status));
	}

	public function upload() {
		JRequest::checkToken('get') or die;

		$model = $this->getModel('asset');

		$storage = PodcastHelper::getStorage();

		$folder = JRequest::getVar('folder', PodcastHelper::getOptions()->get('folder', '/media/podcasts/'));
		$result = $storage->putFile($folder);

		if (is_array($result)) {
			$result = array_shift($result);
		}

		if ($result->result) {
			$asset = $model->store($result);

			if (!$asset) {
				$result->result = false;
				$result->message = 'Could not store in assets table';
			} else {
				$result->podcast_asset_id = $asset;
			}
		}

		echo json_encode($result);
	}
}