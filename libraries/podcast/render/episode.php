<?php
defined( '_JEXEC' ) or die;

jimport('podcast.render.layout');

class PodcastRenderEpisode
{
	public function player($episode_id)
	{
		// TODO: detect audio/video here?
		$layout = new PodcastRenderLayout('default_audio.php', $episode_id);

		return $layout->render();
	}

	public function full_episode($episode_id)
	{
		// TODO: detect audio/video here?
		$layout = new PodcastRenderLayout('default.php', $episode_id);

		return $layout->render();
	}
}