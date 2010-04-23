<?php
class ratings extends Professor
{
//    protected  static $is_login = false;
//    protected  $user_info;
//    protected  static $secret = "bdbdes1./";
//    protected $id = 0;
    private $tablename;
    private $date_create;
    private $max_rating;
    private $sub_professor_id;

    public function  __construct($db,$subject,$groupe,$professor_id)
    {
        $this->db = $db;
        $this->$tablename = $subject + '_' + $groupe;
        $this->$professor_id = $professor_id;
//        $this->id = $id;
    }

    public function getRatingTable($table_id)
    {


    }

    public function setRatingTable()
    {



    }

    public function updateRatingTable($table_id)
    {


    }

    public function getRatingRecord($record_id)
    {



    }
    
    public function setRatingRecord()
    {

        

    }

    public function getAllRatingRecords()
    {


    }

    public function getMyGroups()
    {
        $sql = "select 'Professors`. from `Groups`".
               " where `Groupes`.`ID` = $this->id and `Professors`.`User_ID` = $this->id";

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
