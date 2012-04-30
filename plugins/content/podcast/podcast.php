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

		// Unfortunately, PHP 5.2 does not allow static callbacks, so we must
		// string replace manually.
		preg_match('/\{podcast_(media) (\d+)\}/', $row->text, $matches);

		if (count($matches)) {
			$row->text = JString::str_ireplace($matches[0], $this->callbackMatchProcess($matches), $row->text);
		}

		preg_match('/\{podcast_(episode) (\d+)\}/', $row->text, $matches);

		if (count($matches)) {
			$row->text = JString::str_ireplace($matches[0], $this->callbackMatchProcess($matches), $row->text);
		}

		return true;
	}

	public function callbackMatchProcess($matches)
	{
		try {
			if ($matches[1] === 'episode') {
				$layout = new PodcastRenderLayout('full');
				$layout->episode_id = $matches[2];
			} else if ($matches[1] === 'media') {
				$layout = new PodcastRenderLayout('media');
				$layout->podcast_asset_id = $matches[2];
			}
		} catch (PodcastRenderException $e) {
			return $e->getMessage();
		}

		return $layout->render();
	}
}
