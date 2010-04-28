<?php
if (!defined("entrypoint"))die;

//files::initDB($db);
//$file_info = files::getFileInformation(Root::POSTInt("file_id"));
//
//if($file_info["Cover"] == "static/uploaded/covers/")
//    $file_info['Cover'] = "";
//
//print json_encode($file_info);

$tablename = Root::POSTString("tablename");

$col_number = 6;
$data_number = 10-2;

$data["title"]['stud_name']="FIO";
for($i=1; $i<$col_number; $i++) {
    $data["title"]['col'.$i] = "title".$i;
}


for($i=0; $i < $data_number; $i++) {
    $data["data"][$i]['stud_name']="Vasya".$i;
    for($j = 1; $j <= $col_number; $j++){
        $data["data"][$i]['col'.$j] = $i * 13;
    }
}

for($i=1; $i<$col_number; $i++) {
    $data["rating"]['col'.$i] = $i * 10;
}

print json_encode($data);
?>