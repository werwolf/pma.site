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
    $data["title"]['col'.$i] = "колонка".$i;
}


for($i=0; $i < $data_number; $i++) {
    $data["data"][$i]['stud_name']="Вася".$i;
    for($j = 1; $j <= $col_number; $j++){
        $data["data"][$i]['col'.$j] = $i * 13;
    }
}

for($i=1; $i<$col_number; $i++) {
    $data["rating"]['col'.$i] = $i * 10;
}

print json_encode($data);

///////////////////////////////////////////////////////////
//function json_safe_encode($var)
//{
//   return json_encode(json_fix_cyr($var));
//}
//
//function json_fix_cyr($var)
//{
//   if (is_array($var)) {
//       $new = array();
//       foreach ($var as $k => $v) {
//           $new[json_fix_cyr($k)] = json_fix_cyr($v);
//       }
//       $var = $new;
//   } elseif (is_object($var)) {
//       $vars = get_object_vars($var);
//       foreach ($vars as $m => $v) {
//           $var->$m = json_fix_cyr($v);
//       }
//   } elseif (is_string($var)) {
//       $var = iconv('cp1251', 'utf-8', $var);
//   }
//   return $var;
//}
///////////////////////////////////////////////////////////
?>