<?php
    /**
     * @author Mubashier CMS - www.Mubashier.com
     */
    include dirname(__FILE__).'/lib/engine.php';
        $Mubashier = new Mubashier();
            $Mubashier->start();

$langs = array(
        1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        3 => 'The uploaded file was only partially uploaded',
        4 => 'No file was uploaded',
        6 => 'Missing a temporary folder',
        7 => 'Failed to write file to disk',
        8 => 'A PHP extension stopped the file upload',

);

foreach ($langs as $k => $v) {
    $Mubashier->db->langs()->insert(array(
        'pkg' => 'UPLOAD',
        'var_key' => 'upload_err_'.$k,
        'en' => $v,

    ));
}
