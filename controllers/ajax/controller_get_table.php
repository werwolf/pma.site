<?php
if (!defined("entrypoint"))die;

$do = Root::POSTString("do");

switch ($do){
    case "get_my_tables":
        $rating = new Ratings($db,$user);
        $data = $rating->getMyTables();
        break;
    case "get_all_tables":
        $rating = new Ratings($db,$user);
        $data = $rating->getAllTables();
        break;
    case "get_data":
        $tablename = Root::POSTString("tablename");
        $rating = new Ratings($db,$user);
        $data = $rating->getData($tablename);
        break;
    case "get_rating_data":
        $group_id = Root::POSTString("group_id");
        $rating = new Ratings($db,$user);
        $data = $rating->getRatingData($group_id);
        break;
    case "save_data":
        $tablename = Root::POSTString("tablename");

        $data = Root::POSTString("data");
        $data = urldecode($data);
        $data = str_replace("\\","",$data);
        $data = json_decode($data);

        $title = Root::POSTString("title");
        $title = urldecode($title);
        $title = str_replace("\\","",$title);
        $title = json_decode($title);
        
        $temp = explode('_',$tablename);
        $group_id = $temp[1];
        $subject_id = $temp[2];

        $rating = new Ratings($db,$user,$group_id,$subject_id);
        $data=$rating->saveTable($data,$title);
        break;
    case "drop_table":
        $tablename = Root::POSTString("tablename");
        $rating = new Ratings($db,$user);
        $data=$rating->dropTable($tablename);
        break;
}
print json_encode($data);
?>