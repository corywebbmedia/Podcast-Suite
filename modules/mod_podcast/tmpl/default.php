<?php defined('_JEXEC') or die; ?>

<div class="podcast_latest<?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?>">
	 <?php if (count($items)) : ?>
	 <ul>
	 <?php foreach ($items as $item) : ?>
		 <li>
		 	<a href="<?php echo JRoute::_('index.php?option=com_podcast&view=episode&episode_id='.$item->episode_id); ?>"><?php echo htmlspecialchars($item->episode_title); ?></a>
		 	- <?php echo date($params->get('date_format', 'M j, Y') , strtotime($item->episode_pubDate)); ?>
		 </li>
	 <?php endforeach; ?>
	</ul>
	 <?php endif; ?>
</div>