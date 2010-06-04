<?php
if (!defined("entrypoint"))die;

$do = Root::POSTString("do");
$lang = config::getDefaultLanguage();

switch ($do){
    case "init":
        $rating = new ratings($db,$user,$lang);
    	$data = $rating->getMagic();
        break;
    case "create_table":
        //$data = 'werwolf';break;
        $group_id = Root::POSTString("group_id");
        $subject_id = Root::POSTString("subject_id");
        $max_rating = Root::POSTString("max_rating");
        $rating = new ratings($db,$user,$lang,$group_id,$subject_id,$max_rating);
        $data = $rating->createTable();		
		break;
}
print json_encode($data);
?>