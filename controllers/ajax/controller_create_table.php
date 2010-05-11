<?php
if (!defined("entrypoint"))die;

$do = Root::POSTString("do");

switch ($do) {
    case "get_groups":
        $rating = new ratings($db,$user);
        $data = $rating->getAllGroups();
        break;
    case "create_table":
        $subject_id = Root::POSTString("subject_id");
        $group_id = Root::POSTString("group_id");
        $max_rating = Root::POSTString("max_rating");
        $rating = new ratings($db,$user,$group_id,$subject_id,$max_rating);
        if ($rating->seekTable()) {
            $data=-1;
        } else {
            $data=$rating->createTable();
        }
        break;
}
print json_encode($data);
?>