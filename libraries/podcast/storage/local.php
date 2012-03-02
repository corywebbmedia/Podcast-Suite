<?php

/**
 * @author      Jeremy Wilken - Cory Webb Media
 * @link        www.corywebbmedia.com
 * @copyright   Copyright 2012 Cory Webb Media. All Rights Reserved.
 * @category    cwm_podcast
 * @package
 */

defined('_JEXEC') or die;

jimport('podcast.storage');
jimport('joomla.filesystem.folder');

class PodcastStorageLocal extends PodcastStorage
{
    protected $type = 'local';
    protected $tree = array();

    public function getAssetUrl($path)
    {
        // trim any preceding slashes
        $path = trim($path, '/\\');

        return JURI::root().$path;
    }

    public function getFolders($path = '', $tree = true)
    {
        if ($path == '') {
            $path = PodcastAsset::getOptions()->get('root', JPATH_ROOT.'/media/podcasts/');
        }

        $folders = $this->retrieveTree($path);

        return $folders;
    }

	public function getRoot()
	{
		return PodcastAsset::getOptions()->get('root', JPATH_ROOT.'/media/podcasts/');
	}

	public function putFile($folder)
    {
        $result = new stdClass();
        $result->result = false;
        $result->message = 'Loading...';

        // HTTP headers for no cache etc
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        // Settings

		if (!$folder) {
			$folder = PodcastAsset::getOptions()->get('folder', '/media/podcasts/');
		}

		if (!in_array(substr($folder, 0, 1), array('/','\/'))) $folder = '/'.$folder;
		if (!in_array(substr($folder, -1, 1), array('/','\/'))) $folder = $folder.'/';

        $targetDir        = JPath::clean(JPATH_ROOT . $folder);
        $cleanupTargetDir = true; // Remove old files
        $maxFileAge       = 5 * 3600; // Temp file age in seconds
        // 5 minutes execution time
        @set_time_limit(5 * 60);

        // Get parameters
        $chunk    = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
        $chunks   = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
        $fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : '';

        // Clean the fileName for security reasons
        $fileName = preg_replace('/[^\w\._]+/', '_', $fileName);

        // Make sure the fileName is unique but only if chunking is disabled
        if ($chunks < 2 && file_exists($targetDir . $fileName))
        {
            $ext        = strrpos($fileName, '.');
            $fileName_a = substr($fileName, 0, $ext);
            $fileName_b = substr($fileName, $ext);

            $count = 1;
            while (file_exists($targetDir . $fileName_a . '_' . $count . $fileName_b))
                $count++;

            $fileName = $fileName_a . '_' . $count . $fileName_b;
        }

        $filePath = $targetDir . $fileName;

        // Create target dir
        if (!file_exists($targetDir))
            @mkdir($targetDir);

        // Remove old temp files
        if ($cleanupTargetDir && is_dir($targetDir) && ($dir = opendir($targetDir)))
        {
            while (($file = readdir($dir)) !== false)
            {
                $tmpfilePath = $targetDir . $file;

                // Remove temp file if it is older than the max age and is not the current file
                if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge) && ($tmpfilePath != "{$filePath}.part"))
                {
                    @unlink($tmpfilePath);
                }
            }

            closedir($dir);
        }
        else
        {
            $result->message = 'Failed to open temp directory.';
            return $result;
        }



        // Look for the content type header
        if (isset($_SERVER["HTTP_CONTENT_TYPE"]))
            $contentType = $_SERVER["HTTP_CONTENT_TYPE"];

        if (isset($_SERVER["CONTENT_TYPE"]))
            $contentType = $_SERVER["CONTENT_TYPE"];

        // Handle non multipart uploads older WebKit versions didn't support multipart in HTML5
        if (strpos($contentType, "multipart") !== false)
        {
            if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name']))
            {
                // Open temp file
                $out = fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
                if ($out)
                {
                    // Read binary input stream and append it to temp file
                    $in = fopen($_FILES['file']['tmp_name'], "rb");

                    if ($in)
                    {
                        while ($buff = fread($in, 4096))
                            fwrite($out, $buff);
                    }
                    else
                    {
                        $result->message = 'Failed to open input stream.';
                        return $result;
                    }

                    fclose($in);
                    fclose($out);
                    @unlink($_FILES['file']['tmp_name']);
                }
                else
                {
                    $result->message = 'Failed to open output stream.';
                    return $result;
                }
            }
            else
            {
                $result->message = 'Failed to move uploaded file.';
                return $result;
            }
        }
        else
        {
            // Open temp file
            $out = fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
            if ($out)
            {
                // Read binary input stream and append it to temp file
                $in = fopen("php://input", "rb");

                if ($in)
                {
                    while ($buff = fread($in, 4096))
                        fwrite($out, $buff);
                }
                else
                {
                    $result->message = 'Failed to open input stream.';
                    return $result;
                }

                fclose($in);
                fclose($out);
            }
            else
            {
                $result->message = 'Failed to open output stream.';
                return $result;
            }
        }

        // Check if file has been uploaded
        if (!$chunks || $chunk == $chunks - 1)
        {
            // Strip the temp .part suffix off
            rename("{$filePath}.part", $filePath);

			jimport('getid3.getid3.getid3');

            $getid3 = new getID3;
            $info = $getid3->analyze($filePath);

            $result->result = true;
            $result->message = 'Success';
            $result->enclosure_length = (isset($info['filesize']) ? $info['filesize'] : 0);
            $result->enclosure_type = (isset($info['mime_type']) ? $info['mime_type'] : '');
            $result->enclosure_duration = (isset($info['playtime_string']) ? $info['playtime_string'] : '');
            $filePath = str_replace('\\', '/', $filePath);
            $result->enclosure_url = $folder.basename($filePath);
			$result->storage_engine = $this->type;
        }

        return $result;
    }

    public function retrieveTree($path)  {

        $dir = @opendir($path);

        if ($dir) {
            while (($element = readdir($dir)) !== false) {
                if (is_dir($path.'/'.$element) && $element != '.' && $element != '..') {
                    $array[$element] = $this->retrieveTree($path.'/'.$element);
                }
            }
            closedir($dir);
        }

        return (isset($array) ? $array : false);
    }

}