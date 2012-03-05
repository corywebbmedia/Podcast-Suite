<?php
/**
 * @author      Joseph LeBlanc - Cory Webb Media
 * @link        www.corywebbmedia.com
 * @copyright   Copyright 2012 Cory Webb Media. All Rights Reserved.
 * @category    cwm_podcast
 * @package
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

class PodcastControllerAssets extends JControllerAdmin
{
	protected $text_prefix = 'COM_PODCAST_ASSETS';

	public function delete()
	{
		JRequest::checkToken() or die(JText::_('JINVALID_TOKEN'));
		
		$cid = JRequest::getVar('cid', array(), '', 'array');
		$removed = false;
		
		if (!is_array($cid) || count($cid) < 1)
		{
			JError::raiseWarning(500, JText::_($this->text_prefix . '_NO_ITEM_SELECTED'));
		}
		else
		{
			$db = JFactory::getDBO();
			for ($i = 0; $i < count($cid); $i++)
			{
				$id = $cid[$i];
				$db->setQuery($db->getQuery(true)->select('episode_id')->from('#__podcast_assets_map')->where('podcast_asset_id = "'.$id.'"'));
				$db->query();
				if ($db->getNumRows())
				{
					$removed = true;
					unset($cid[$i]);
				}
			}
			
			if (count($cid))
			{
					// Get the model.
				$model = $this->getModel();

				// Make sure the item ids are integers
				jimport('joomla.utilities.arrayhelper');
				JArrayHelper::toInteger($cid);

				// Remove the items.
				if ($model->delete($cid))
				{
					if ($removed) $this->setMessage(JText::plural($this->text_prefix . '_N_ITEMS_DELETED_IN_USE', count($cid)));
					else $this->setMessage(JText::plural($this->text_prefix . '_N_ITEMS_DELETED', count($cid)));
				}
				else
				{
					$this->setMessage($model->getError());
				}
			}
			else
			{
				$this->setMessage(JText::_('COM_PODCAST_ASSETS_IN_USE'));
			}
		}

		$this->setRedirect(JRoute::_('index.php?option=' . $this->option . '&view=' . $this->view_list, false));
	}
	
	public function getModel($name = 'Asset', $prefix = 'PodcastModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);

		return $model;
	}

	public function getAssets($ajax = true)
	{
		$model = $this->getModel('assets');
		$assets = $model->getItems();
		$total = $model->getTotal();
		$pagination = $model->getPagination();

		if ($ajax)
		{
			$response = new stdClass();
			$response->list = $assets;
			$response->pagination = $pagination;

			echo json_encode($response);

			JFactory::getApplication()->close();
		}
	}
}