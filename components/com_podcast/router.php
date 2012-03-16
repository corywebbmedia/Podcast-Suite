<?php
defined( '_JEXEC' ) or die;

function PodcastBuildRoute(&$query)
{
	$segments = array();

	if (isset($query['view']) && isset($query['episode_id'])) {
		if ($query['view'] == 'episode') {
			$segments[] = PodcastEpisodeGetAlias($query['episode_id']);
			unset($query['episode_id']);
			unset($query['view']);
		}
	}

	return $segments;
}

function PodcastParseRoute($segments)
{
	$vars = array();

	if (count($segments) == 1) {
		// URL alias oddity: first hyphen is replaced with colon
		$alias = JString::str_ireplace(':', '-', $segments[0]);

		$vars['episode_id'] = PodcastEpisodeAliasID($alias);
		$vars['view'] = 'episode';
	}

	return $vars;
}

function PodcastEpisodeGetAlias($id)
{
	$db = JFactory::getDbo();
	$query = $db->getQuery(true);

	$query->select('alias')
		->from('#__podcast_episodes')
		->where("episode_id = '{$id}'");

	$db->setQuery($query);

	return $db->loadResult();
}

function PodcastEpisodeAliasID($alias)
{
	$db = JFactory::getDbo();

	$alias = $db->getEscaped($alias);

	$query = $db->getQuery(true);

	$query->select('episode_id')
		->from('#__podcast_episodes')
		->where("alias = '{$alias}'");

	$db->setQuery($query);

	return $db->loadResult();
}