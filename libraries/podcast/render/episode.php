<?php
defined( '_JEXEC' ) or die;

class PodcastRenderEpisode
{
	public function player($episode_id)
	{
		$model = JModel::getInstance('Episode', 'PodcastModel');

		return 'stub ' . $episode_id;
	}

	public function full_episode($episode_id)
	{
		return 'stub ' . $episode_id;
	}
}