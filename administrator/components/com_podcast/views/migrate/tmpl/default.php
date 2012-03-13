<?php
defined( '_JEXEC' ) or die;

JHTML::_('behavior.mootools');

$document = JFactory::getDocument();
$document->addScript(JURI::root() . 'media/com_podcast/js/admin/migrate.js');
$document->addScriptDeclaration("MigratePodcast.token = '" . JUtility::getToken() . "';");

?>
<form action="index.php?option=com_podcast" method="post" name="adminForm">
	<div class="width-60 fltlft">
		<fieldset class="adminform">
			<legend>Migrate Podcast Suite 1.5 to Podcast Suite 2.0*</legend>

			<p>This migration tool is designed to import the data from a Joomla 1.5 site running Podcast Suite 1.5. To ensure this tool works correctly, make sure that the Joomla 1.5 site is running on the same server as this Joomla 2.5 site.</p>

			<p>Once the migration begins, it will scrape the information from the old site and create entries for each podcast episode. The main podcast feed will be imported from the old site and recreated as a feed in Podcast Suite 2.0. Any category-based feeds will need to be recategorized under separate feeds.</p>

			<p>This process is designed to be run only one time on a fresh installation of Podcast Suite. If you need to run the import again, be sure to reinstall Podcast Suite 2.0 so that any old and erroneous information is removed.</p>

		</fieldset>
	</div>

	<div class="width-40 fltrt">
		<fieldset class="adminform">
			<legend>Actual Migration Over HERE*</legend>

			<label for="path_to_old_joomla_site">Path to Joomla 1.5 site</label><input type="text/submit/hidden/button" name="path_to_old_joomla_site" value="" id="path_to_old_joomla_site" size="70">

			<input type="button" name="thebigscarybutton" value="Are You Absolutely Sure You Want To Do This???" id="thebigscarybutton" />

		</fieldset>

		<fieldset class="adminform">
			<legend>Migration Status*</legend>

			<ul id="migration_statuses">
			</ul>
		</fieldset>
	</div>
</form>