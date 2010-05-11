<?php
class ratings //extends Professor
{
    private $tablename;
    //private $date_create;
    private $max_rating;
    //private $sub_professor_id;
    private $table = array();
    //private $names;

    public function  __construct($db,$user,$group_id=null,$subject_id=null,$max_rating=0)
    {
        $this->db = $db;
//        $this->id = $id;
        $this->professor_id = $user->getUserID();
        $this->group_id = $group_id;
        $this->subject_id = $subject_id;
        $this->tablename = "rating_".$group_id."_".$subject_id."_".$this->professor_id;
        $this->max_rating = $max_rating;
    }

    public function createTable($sub_professor_id=0)
    {
        if($sub_professor_id == 0) $sub_professor_id = $this->id;
//        $sql="START TRANSACTION";
//        $this->db->query($sql);
        $sql="INSERT INTO `Ratings` (`Tablename`, `Date_create`, `Professor_ID`, `Group_ID`, `SubProf_ID`, `Subject_ID`, `max_rating`, `Col_Caption`) ";
        $sql.="VALUES ('$this->tablename', '".date("Y-m-d")."', '$this->professor_id', '$this->group_id', '0', '$this->subject_id', '$this->max_rating', 'col1');";
        $this->db->query($sql);
        $sql="CREATE TABLE `$this->tablename` (";
        $sql.="`stud_name` varchar(60) CHARSET utf8 COLLATE utf8_general_ci NOT NULL ,";
        $sql.="`col1` int(6) NOT NULL DEFAULT '0' )";
        // COMMIT
        if ($this->db->query($sql)) {
        	$sql="INSERT INTO `$this->tablename` (`stud_name`) VALUES ";
	        $IDs = $this->getStudentsIDs($this->group_id);
	        for($i=0;$i<count($IDs);$i++)
	        	$sql.=$i<count($IDs)-1 ? "('".$IDs[$i]["User_ID"]."')," : "('".$IDs[$i]["User_ID"]."'),('max_rating')";
	        return $this->db->query($sql);
        } else return 0;
    }

    public function dropTable()
    {
	    return $this->db->query("DROP TABLE IF EXISTS `$this->tablename`");
    }

    public function updateTable()
    {
        $this->dropTable();
        return $this->createTable();
    }

    public function seekTable()
        {
	    $this->db->query("SHOW TABLES FROM `".MYSQL_BASE."`");
	    $result = $this->db->assocAll();
	    for ($i=0;$i<count($result);$i++) {
	        if ($this->tablename==$result[$i]["Tables_in_".MYSQL_BASE]) {
	            return true;
	        }
        }
	    return false;
    }

    public function getStudentsIDs($group_id=null)
    {
    	if (!isset($group_id)) $group_id=$this->group_id;
        $sql = "SELECT `User_ID` FROM `Students` WHERE `Group_ID` = '$group_id'";
        $this->db->query($sql);
        return $this->db->assocAll();
    }

    public function getStudentsName($group_id=null)
    {
    	if (!isset($group_id)) $group_id=$this->group_id;
        $IDs = $this->getStudentsIDs($group_id);
        $sql = "SELECT `Name`,`Surname`,`Patronymic` FROM `Users` WHERE ";
        for($i=0;$i<count($IDs);$i++)
            $sql.=$i<count($IDs)-1 ? "`ID` = '".$IDs[$i]["User_ID"]."' OR " : "`ID` = '".$IDs[$i]["User_ID"]."'";
        $this->db->query($sql);
        return $this->db->assocAll();
    }

    public function getAllGroups() {
    	$sql="SELECT `ID`,`Title` FROM `Groups`";
        $this->db->query($sql);
    	return $this->db->assocAll();
    }
// хз че там дальше))



    public function getRecord($record_id)
    {
        $sql = "select * from `Ratings` where `Ratings`.`ID` = $record_id";
        $this->db->query($sql);
        //$this->RatingRecords = $this->db->assoc();
    }
    
    public function setRecord($subject_id)
    {

        

    }

    public function getAllRecords()
    {
        $sql = "select * from `Ratings` where `Ratings`.`Professor_ID` = $this->id";
        $this->db->query($sql);
        $this->RatingRecords = $this->db->assoc();
    }

    public function getMyGroups()
    {
        $sql = "select 'Professors` from `Groups` where".
               " `Groups`.`ID` = $this->id and `Professors`.`User_ID` = $this->id";

        $this->db->query($sql);
        $this->user_info = $this->db->assoc();

        $subject = $this->getProfessorSubjectsIds();

        $sql = "select `Title` from `Subjects` where ";
        for($i=0;$i<count($subject);$i++)
        {
            if($i<count($subject)-1)
                $sql.="`ID` = ".$subject[$i]." or ";
            else
                $sql.="`ID` = ".$subject[$i];
        }
        $this->db->query($sql);
        $this->subjects = $this->db->assocAll();
    }
}

//
//class Professor extends user
//{
//    private $subjects;
//    public function getUserInformation()
//    {
//        $sql = "select `Users`.*,`Professors`.* from `Users`,`Professors`".
//               " where `Users`.`ID` = $this->id and `Professors`.`User_ID` = $this->id";
//
//        $this->db->query($sql);
//        $this->user_info = $this->db->assoc();
//
//        $subject = $this->getProfessorSubjectsIds();
//
//        $sql = "select `Title` from `Subjects` where ";
//        for($i=0;$i<count($subject);$i++)
//        {
//            if($i<count($subject)-1)
//                $sql.="`ID` = ".$subject[$i]." or ";
//            else
//                $sql.="`ID` = ".$subject[$i];
//        }
//        $this->db->query($sql);
//        $this->subjects = $this->db->assocAll();
//    }
//
//    public function getProfessorSubjectsIds()
//    {
//        return explode("||",$this->user_info['Subjects']);
//    }
//
//    public function getProfessorSubjects()
//    {
//        return $this->subjects;
//    }
//
//    public function IsLector()
//    {
//        if($this->user_info['Lector'] == 0)
//                return false;
//        else
//                return true;
//    }
//}

?>
