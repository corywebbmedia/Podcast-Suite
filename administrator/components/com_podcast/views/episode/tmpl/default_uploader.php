<?php 
defined('_JEXEC') or die;

$doc = JFactory::getDocument();
$doc->addScript('http://bp.yahooapis.com/2.4.21/browserplus-min.js');
$doc->addScript(JURI::root().'media/com_podcast/js/plupload/plupload.js');
$doc->addScript(JURI::root().'media/com_podcast/js/plupload/plupload.gears.js');
$doc->addScript(JURI::root().'media/com_podcast/js/plupload/plupload.silverlight.js');
$doc->addScript(JURI::root().'media/com_podcast/js/plupload/plupload.flash.js');
$doc->addScript(JURI::root().'media/com_podcast/js/plupload/plupload.browserplus.js');
$doc->addScript(JURI::root().'media/com_podcast/js/plupload/plupload.html4.js');
$doc->addScript(JURI::root().'media/com_podcast/js/plupload/plupload.html5.js');

$max_upload = (int)(ini_get('upload_max_filesize'));
$max_post = (int)(ini_get('post_max_size'));
$memory_limit = (int)(ini_get('memory_limit'));
$upload_mb = min($max_upload, $max_post, $memory_limit);

?>

<div id="upload">
    <div id="filelist"></div>
    <br />
    <a id="pickfiles" href="javascript:;">[Select files]</a> 
    <a id="uploadfiles" href="javascript:;">[Upload files]</a>
</div>

<script type="text/javascript">

var uploader = new plupload.Uploader({
	runtimes : 'gears,html5,flash,silverlight,browserplus',
	browse_button : 'pickfiles',
	container: 'upload',
	ax_file_size : '20mb',
	url : 'index.php?option=com_podcast&task=asset.upload&<?php echo JUtility::getToken() ?>=1',
	flash_swf_url : '<?php echo JURI::root()?>media/com_podcast/js/plupload/plupload.flash.swf',
	silverlight_xap_url : '<?php echo JURI::root() ?>media/com_podcast/js/plupload/plupload.silverlight.xap'
});

uploader.bind('FilesAdded', function(up, files) {
    for (i = 0; i < files.length; i++) {
        $('filelist').innerHTML += '<div id="' + files[i].id + '">' + files[i].name + ' (' + plupload.formatSize(files[i].size) + ') <b></b></div>';
    }
});

uploader.bind('UploadProgress', function(up, file) {
	$(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
});

$('uploadfiles').onclick = function() {
	uploader.start();
	return false;
};

uploader.init();
</script>