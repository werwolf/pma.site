<?php
if (!defined("entrypoint"))die;

$do = Root::POSTString("do");

switch ($do) {
    case "get_groups":
        $rating = new ratings($db);
        $data = $rating->getAllGroups();
        break;
    case "create_table":
        $subject_id = Root::POSTString("subject_id");
        $group_id = Root::POSTString("group_id");
        $professor_id = Root::POSTString("professor_id");
        $max_rating = Root::POSTString("max_rating");
        $rating = new ratings($db,$group_id,$subject_id,$professor_id,$max_rating);
        if ($rating->seekTable()) {
            $data=-1;
        } else {
            $data=$rating->createTable(0);
        }
        break;
}
print json_encode($data);
?>