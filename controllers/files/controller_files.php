<?php
if (!defined("entrypoint"))die;
require_once("classes/files/class.files.php");

files::init($db, $viewextensions,MAX_FILE_SIZE,FILE_UPLOAD_DIR);

$View->title = $labels['fileshare']['bc_title'];
?>
