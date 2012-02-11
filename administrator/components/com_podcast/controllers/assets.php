<?php

defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

class PodcastControllerAssets extends JController
{
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