<?php
if (!defined("entrypoint"))die;

files::initDB($db);
$file_info = files::getFileInformation(Root::POSTInt("file_id"));

if($file_info["Cover"] == "static/uploaded/covers/")
    $file_info['Cover'] = "";

print json_encode($file_info);

?>
