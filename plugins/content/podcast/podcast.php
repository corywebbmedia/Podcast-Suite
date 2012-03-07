<?php
defined( '_JEXEC' ) or die;

class plgContentPodcast extends JPlugin
{
	function onContentPrepare($context, &$row, &$params, $page = 0)
	{
		// Performance check: don't process content without the tag
		if (JString::strpos($row->text, '{podcast') === false) {
			return true;
		}

		jimport('podcast.render.layout');

		$row->text = preg_replace_callback('/\{podcast_(episode) (\d+)\}/', 'plgContentPodcast::callbackMatchProcess', $row->text);
		$row->text = preg_replace_callback('/\{podcast_(player) (\d+)\}/', 'plgContentPodcast::callbackMatchProcess', $row->text);

		return true;
	}

	public function callbackMatchProcess($matches)
	{
		if ($matches[1] === 'episode') {
			$layout = new PodcastRenderLayout('full', $matches[2]);
		} else if ($matches[1] === 'player') {
			$layout = new PodcastRenderLayout('player', $matches[2]);
		}

		return $layout->render();
	}
}
