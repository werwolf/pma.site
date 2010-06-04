<?php
class ratings {
    private $tablename;
    private $lang;
    private $group_id;
    private $subject_id;
    private $db;
    private $professor_id;
    private $max_rating;

    public function  __construct($db,$user,$lang,$group_id=null,$subject_id=null,$max_rating=0) {
        $this->db = $db;
        $this->lang = $lang;
        $this->professor_id = $user->getUserID();
        $this->group_id = $group_id;
        $this->subject_id = $subject_id;
        $this->tablename = "rating_".$group_id."_".$subject_id."_".$this->professor_id;
        $this->max_rating = $max_rating;
    }

    public function createTable($sub_professor_id=0) {
        if($sub_professor_id == 0) $sub_professor_id = $this->id;
        if($this->seekTable()) return false;
        $sql="SELECT `ID` FROM `Ratings` WHERE `Tablename`='$this->tablename'";
        if(!$this->db->query($sql)) return false;
        if(count($this->db->assocAll()) == 0) {
            $sql = "INSERT INTO `Ratings` (`Tablename`, `Date_create`, `Professor_ID`, `Group_ID`, `SubProf_ID`, `Subject_ID`, `max_rating`, `Col_Caption`) ";
            $sql.= "VALUES ('$this->tablename', '".date("Y-m-d")."', '$this->professor_id', '$this->group_id', '0', '$this->subject_id', '$this->max_rating', 'робота1');";
            if(!$this->db->query($sql)) return false;
        } else {
            $sql = "UPDATE `Ratings` SET `Date_create`='".date("Y-m-d")."', `Max_Rating`='$this->max_rating', `Col_Caption`='робота1' WHERE `Tablename`='$this->tablename' ";
            if(!$this->db->query($sql)) return false;
        }

        $sql = "CREATE TABLE `$this->tablename` (";
        $sql.= "`stud_name` varchar(60) CHARSET utf8 COLLATE utf8_general_ci NOT NULL ,";
        $sql.= "`col1` int(6) NOT NULL DEFAULT '0', ";
        $sql.= "`rating` float(6) NOT NULL DEFAULT '0', PRIMARY KEY (`stud_name`) )";

        if (!$this->db->query($sql)) return false;

        $sql = "INSERT INTO `$this->tablename` (`stud_name`) VALUES ";
        $IDs = $this->getStudentsIDs($this->group_id);
        if(count($IDs) == 0) return true; //
        for($i = 0; $i < count($IDs); $i++)
            $sql.=$i<count($IDs)-1 ? "('".$IDs[$i]["User_ID"]."')," : "('".$IDs[$i]["User_ID"]."'),('max_rating')";

        return $this->db->query($sql);
    }

    public function dropTable($tablename=null) {
        if (!isset($tablename)) $tablename=$this->tablename;
        if(!$this->db->query("DROP TABLE IF EXISTS `$tablename`")) return false;
        if(!$this->db->query("DELETE FROM `Ratings` WHERE `Tablename`='$tablename'")) return false;
        return true;
    }

    public function saveTable($data,$title) {
        $data = $this->object_to_array($data);
        $title = $this->object_to_array($title);
        $rating_data=array();
        foreach($data as $i=>$one)
            $rating_data[$i]=0;
        foreach($data as $i=>$one)
            foreach($one as $j=>$two)
                if($j!="stud_name") $rating_data[$i]+=$two;
        for($i=0;$i<count($rating_data)-1;$i++)
            if ($rating_data[count($rating_data)-1]!=0)
                $rating_data[$i]=$rating_data[$i]/$rating_data[count($rating_data)-1];

        $sql="SELECT `Max_Rating` FROM `Ratings` WHERE `Tablename`='$this->tablename'";
        if(!$this->db->query($sql))return false;
        $max_rating=$this->db->assocAll();
        $this->max_rating=$max_rating[0]["Max_Rating"];

        $this->dropTable();
        $this->createTable();

        $sql="ALTER TABLE `$this->tablename`";
        for ($i=1;$i<count($title);$i++) {
            $sql.=" ADD COLUMN `col".($i+1)."` int(6) DEFAULT '0' NOT NULL after `col".$i."`,";
        }
//        $sql.=" ADD COLUMN `rating` float(6) DEFAULT '0' NOT NULL after `col".$i."`";
        $sql = substr($sql,0,-1);
        if(!$this->db->query($sql))return false;
        foreach($data as $num=>$one) {
            $sql="UPDATE `$this->tablename` SET ";
            $i=1;
            foreach($title as $two) {
                $sql.="`col".$i."`='".$one[$two["name"]]."',";
                $i+=1;
            }
            $sql.="`rating`='".$rating_data[$num]."'";
//            $sql=substr($sql,0,-1);
            $sql.=" WHERE `stud_name`='".$one["stud_name"]."'";
            if(!$this->db->query($sql))return false;
        }

        $col_caption="";
        foreach($title as $one)
            $col_caption.=$one["label"]."||";
        $col_caption=substr($col_caption,0,-2);
        $sql="UPDATE `Ratings` SET `Col_Caption`='$col_caption' WHERE `Tablename`='$this->tablename'";
        if(!$this->db->query($sql))return false;
        return true;
    }

    public function seekTable($tablename=null) {
        if (!isset($tablename)) $tablename=$this->tablename;
        $this->db->query("SHOW TABLES FROM `".MYSQL_BASE."`");
        $result = $this->db->assocAll();
        for ($i=0;$i<count($result);$i++) {
            if ($tablename==$result[$i]["Tables_in_".MYSQL_BASE]) {
                return true;
            }
        }
        return false;
    }

    public function getStudentsIDs($group_id = null) {
        if (!isset($group_id)) $group_id = $this->group_id;
        $sql = "SELECT `User_ID` FROM `Students` WHERE `Group_ID` = '$group_id'";
        if(!$this->db->query($sql)) return false;
        return $this->db->assocAll();
    }

    public function getStudentsName($group_id=null) {
        if (!isset($group_id)) $group_id=$this->group_id;
        $IDs = $this->getStudentsIDs($group_id);
        $sql = "SELECT `Name`,`Surname`,`Patronymic` FROM `Users` WHERE ";
        for($i=0;$i<count($IDs);$i++)
            $sql.=$i<count($IDs)-1 ? "`ID` = '".$IDs[$i]["User_ID"]."' OR " : "`ID` = '".$IDs[$i]["User_ID"]."'";
        if(!$this->db->query($sql))return false;
        return $this->db->assocAll();
    }

//    public function getAllGroups() {
//        $sql="SELECT `ID`,`Title` FROM `Groups`";
//        if(!$this->db->query($sql))return false;
//        return $this->db->assocAll();
//    }

    public function getMagic() {
        $sql = "SELECT `ID`,`SP` FROM `Groups` WHERE (`SP` LIKE '% $this->professor_id') OR (`SP` LIKE '% $this->professor_id||%')";

        if(!$this->db->query($sql))return false;
        $this->magic = $this->db->assocAll();
        foreach($this->magic as &$one) {
            $one["SP"] = explode("||", $one["SP"]);
        }

        $res = array();
        $g_temp = array();

        foreach($this->magic as &$one) {
            foreach($one["SP"] as &$two) {
                $two=explode(" ", $two);
                if ($two[1] == $this->professor_id && !$this->seekTable("rating_".$one["ID"]."_".$two[0]."_".$two[1])) {
                    $res[$two[0]]["groups"][]["group_id"]=$one["ID"];
                    if (!in_array($one["ID"],$g_temp)) $g_temp[] = $one["ID"];
                }
            }
        }
        if (count($res) == 0) return false;

        $sql = "SELECT `ID`,`Title` FROM `Groups` WHERE ";
        for($i = 0; $i < count($g_temp); $i++) {
            if($i < count($g_temp)-1)
                $sql.="`ID` = '".$g_temp[$i]."' OR ";
            else
                $sql.="`ID` = '".$g_temp[$i]."'";
        }
        if(!$this->db->query($sql)) return false;
        $g_temp = $this->db->assocAll();

        $sql = "SELECT `ID`,`Title_$this->lang` AS `Title` FROM `Subjects` WHERE ";
        foreach($res as $subject_id=>$some) {
            $sql.="`ID` = '".$subject_id."' OR ";
        }
        $sql = substr($sql,0,-4);
        if(!$this->db->query($sql)) return false;
        $s_temp = $this->db->assocAll();


        foreach($res as $subject_id=>&$some) {
            foreach($s_temp as $two) {
                if($subject_id == $two["ID"]) $some["subject_title"] = $two["Title"];
            }
            foreach($some["groups"] as &$one) {
                foreach($g_temp as $two) {
                    if($one["group_id"] == $two["ID"]) $one["group_title"] = $two["Title"];
                }
            }
        }
        ksort($res);
        return $res;
    }

    public function getMyTables() {
        $sql="SELECT r.`Tablename` AS `tablename`,s.`Title_$this->lang` AS `subject`,g.`Title` AS `group` FROM `Ratings` AS r, `Subjects` AS s, `Groups` AS g WHERE ";
        $sql.="r.`Tablename` LIKE '%_$this->professor_id' AND r.`Group_ID`=g.`ID` AND r.`Subject_ID`=s.`ID` ORDER BY s.`ID`,g.`ID`";
        if(!$this->db->query($sql))return false;
        $res = $this->db->assocAll();
        foreach($res as $i=>$one) {
            if(!$this->seekTable($one["tablename"])) unset($res[$i]);
        }
        if (count($res)==0) return false;
        return $res;
    }

    public function getAllTables() {
        $sql="SELECT r.`Tablename` AS `tablename`,s.`Title_$this->lang` AS `subject`,g.`Title` AS `group` FROM `Ratings` AS r, `Subjects` AS s, `Groups` AS g WHERE ";
        $sql.="r.`Group_ID`=g.`ID` AND r.`Subject_ID`=s.`ID` ORDER BY g.`ID`,s.`ID`";
        if(!$this->db->query($sql))return false;
        $res = $this->db->assocAll();
        foreach($res as $i=>$one) {
            if(!$this->seekTable($one["tablename"])) unset($res[$i]);
        }
        if (count($res)==0) return false;
        return $res;
    }

    public function cmp($a, $b) {
        if ($b["stud_name"] == "max_rating") {
            return -1;
        } elseif ($a["stud_name"] == "max_rating") {
            return 1;
        } else return strcmp($a["stud_name"], $b["stud_name"]);
    }

    public function getData($tablename = null) {
        if (!isset($tablename)) $tablename=$this->tablename;
        $res = array();

        $sql = "SELECT `Col_Caption` FROM `Ratings` WHERE `Tablename`='$tablename'";
        if(!$this->db->query($sql))return false;
        $res["title"] = $this->db->assocAll();
        $res["title"] = explode("||",$res["title"][0]["Col_Caption"]);

        $sql="SELECT * FROM `$tablename`";
        if(!$this->db->query($sql)) return false;
        $res["data"]=$this->db->assocAll();
        if (count($res["data"]) == 0) return false;

        $sql = "SELECT `ID`,CONCAT(`Surname`,' ',`Name`) AS `stud_name` FROM `Users` WHERE ";
        foreach($res["data"] as $one) {
            $sql.="`ID` = '".$one["stud_name"]."' OR ";
        }
        $sql = substr($sql,0,-27);
        if(!$this->db->query($sql))return false;

        $temp = $this->db->assocAll();
        foreach($res["data"] as &$one) {
            $one["stud_id"]=$one["stud_name"];
            foreach($temp as $two)
                if($one["stud_id"] == $two["ID"]) $one["stud_name"]=$two["stud_name"];
        }
        usort($res["data"], array("ratings", "cmp"));
        return $res;
    }

    public function getRatingData($group_id) {
        if (!isset($group_id)) $group_id = $this->group_id;
        $res = array();

        $sql="SELECT r.`Tablename` AS `tablename`,s.`Title_$this->lang` AS `subject`,g.`ID` AS `group` FROM `Ratings` AS r, `Subjects` AS s, `Groups` AS g WHERE ";
        $sql.="r.`Group_ID`=g.`ID` AND r.`Subject_ID`=s.`ID` ORDER BY g.`ID`,s.`ID`";
        if(!$this->db->query($sql))return false;
        $temp = $this->db->assocAll();
        foreach($temp as $i=>$one) {
            if(!$this->seekTable($one["tablename"]) || $one["group"]!=$group_id) unset($temp[$i]);
        }

        if (count($temp)==0) return false;

        $IDs = $this->getStudentsIDs($group_id);
        foreach($IDs as $i=>$one) $res["data"][$i]["stud_name"]=$one["User_ID"];
        $i=1;

        foreach($temp as $one) {
            $res["title"][$i-1]=$one["subject"];

            $sql="SELECT `rating` FROM `".$one["tablename"]."`";
            if(!$this->db->query($sql))return false;
            $temp=$this->db->assocAll();
            foreach($temp as $j=>$two) $res["data"][$j]["col".$i]=$two["rating"];
            if (count($res["data"])==0) return false;
            $i++;
        }
        $res["data"][count($res["data"])-1]["stud_name"]="max_rating";

        $sql = "SELECT `ID`,CONCAT(`Surname`,' ',`Name`) AS `stud_name` FROM `Users` WHERE ";
        foreach($res["data"] as $one) {
            $sql.="`ID` = '".$one["stud_name"]."' OR ";
        }
        $sql=substr($sql,0,-27);

        if(!$this->db->query($sql))return false;
        $temp = $this->db->assocAll();
        foreach($res["data"] as &$one) {
            $one["stud_id"]=$one["stud_name"];
            foreach($temp as $two)
                if($one["stud_id"]==$two["ID"]) $one["stud_name"]=$two["stud_name"];
        }
        usort($res["data"], array("ratings", "cmp"));
        return $res;
    }

    public function object_to_array($data) {
        if(is_array($data) || is_object($data)) {
            $result = array();
            foreach($data as $key => $value) {
                $result[$key] = $this->object_to_array($value);
            }
            return $result;
        }
        return $data;
    }

// хз че там дальше))

// reserve methods

//    public function getRecord($record_id)
//    {
//        $sql = "select * from `Ratings` where `Ratings`.`ID` = $record_id";
//        if(!$this->db->query($sql))return false;
//        //$this->RatingRecords = $this->db->assoc();
//    }
//
//    public function setRecord($subject_id)
//    {
//
//
//
//    }
//
//    public function getAllRecords()
//    {
//        $sql = "select * from `Ratings` where `Ratings`.`Professor_ID` = $this->id";
//        if(!$this->db->query($sql))return false;
//        $this->RatingRecords = $this->db->assoc();
//    }
//
//    public function getMyGroups()
//    {
//        $sql = "select 'Professors` from `Groups` where".
//               " `Groups`.`ID` = $this->id and `Professors`.`User_ID` = $this->id";
//
//        if(!$this->db->query($sql))return false;
//        $this->user_info = $this->db->assoc();
//
//        $subject = $this->getProfessorSubjectsIds();
//
//        $sql = "select `Title_$this->lang` from `Subjects` where ";
//        for($i=0;$i<count($subject);$i++)
//        {
//            if($i<count($subject)-1)
//                $sql.="`ID` = ".$subject[$i]." or ";
//            else
//                $sql.="`ID` = ".$subject[$i];
//        }
//        if(!$this->db->query($sql))return false;
//        $this->subjects = $this->db->assocAll();
//    }
}

?>
