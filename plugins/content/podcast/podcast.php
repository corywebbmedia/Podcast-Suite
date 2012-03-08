<?php
defined( '_JEXEC' ) or die;

// TODO: the player parameter needs some work because the "standalone" layouts
// currently rely on an episode being present.
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
		try {
			if ($matches[1] === 'episode') {
				$layout = new PodcastRenderLayout('full');
				$layout->episode_id = $matches[2];
			} else if ($matches[1] === 'player') {
				$layout = new PodcastRenderLayout('player');
				$layout->podcast_asset_id = $matches[2];
			}
		} catch (PodcastRenderException $e) {
			return $e->getMessage();
		}

		return $layout->render();
	}
}
