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
    case "save_data":
        $tablename = Root::POSTString("tablename");
        $data = Root::POSTString("data");
        $title = Root::POSTString("title");
        $data = urldecode($data);
        $title = urldecode($title);
        $data = str_replace("\\","",$data);
        $title = str_replace("\\","",$title);
        $data = json_decode($data);
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