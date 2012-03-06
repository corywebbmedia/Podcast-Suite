<?php
defined( '_JEXEC' ) or die;

/**
 * While this is far from the way I'd prefer to implement this, it is the
 * lesser evil when compared with code duplication
 *
 * @param array $folders
 * @param boolean $root
 * @return void
 */
function setupPodcastHelperFolders($folders, $root = true)
{
	foreach ($folders as $node => $children)
	{
		if (is_array($children))
		{
			echo '<li><a href="#">'.$node.'</a>';
			echo '<ul>';
			setupPodcastHelperFolders($children, false);
			echo '</ul>';
			echo '</li>';
		}
		else
		{
			echo '<li><a href="#">'.$node.'</a></li>';
		}
	}
}

setupPodcastHelperFolders($this->folders);