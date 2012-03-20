<?php
defined( '_JEXEC' ) or die;

JHTML::_('behavior.mootools');

$document = JFactory::getDocument();
$document->addScript(JURI::base() . 'components/com_migratepodcast/views/migrate/tmpl/migrate.js');
$document->addScriptDeclaration("MigratePodcast.token = '" . JUtility::getToken() . "';");

?>
<form action="index.php?option=com_podcast" method="post" name="adminForm">
	<div class="width-60 fltlft">
		<fieldset class="adminform">
			<legend>Migrate Podcast Suite 1.5 to Podcast Suite 2.0</legend>

			<p>This migration tool is designed to import the data from a Joomla 1.5 site running Podcast Suite 1.5. To ensure this tool works correctly, make sure that the Joomla 1.5 site is running on the same server as this Joomla 2.5 site.</p>

			<p>Once the migration begins, it will scrape the information from the old site and create entries for each podcast episode. Podcast files residing on the same server will be copied over as well. The main podcast feed will be imported from the old site and recreated as a feed in Podcast Suite 2.0. Any category-based feeds will need to be recategorized under separate feeds.</p>

			<p>This process is designed to be run only one time on a fresh installation of Podcast Suite. If you need to run the import again, be sure to reinstall Podcast Suite 2.0 so that any old and erroneous information is removed.</p>

		</fieldset>
	</div>

	<div class="width-40 fltrt">
		<fieldset class="adminform">
			<legend>Start Migration</legend>

			<label for="path_to_old_joomla_site">Path to Joomla 1.5 site</label><input type="text/submit/hidden/button" name="path_to_old_joomla_site" value="" id="path_to_old_joomla_site" size="70">

			<p>&nbsp;</p>

			<p><em>To find the path to your old Joomla site, log into the backend of that site and go to Help &gt; System Info &gt; Configuration File. The value for $tmp_path and $log_path are usually close: remove /logs or /tmp from the end of the path and you will typically have the correct one.</em></p>

			<input type="button" name="thebigscarybutton" value="BEGIN MIGRATION" id="thebigscarybutton" />

		</fieldset>

		<fieldset class="adminform">
			<legend>Migration Status</legend>

			<ul id="migration_statuses">
			</ul>
		</fieldset>
	</div>
</form>