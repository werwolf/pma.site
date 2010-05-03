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
    private $table = array();
    private $names;

//    public function  __construct($db,$subject,$group,$professor_id)
//    {
//        $this->db = $db;
//        $this->$tablename = $subject + '_' + $group;
//        $this->$professor_id = $professor_id;
//        $this->id = $id;
//    }

    public function getStudentsIDs($group_id)
    {
        $sql = "select 'Students'.'Users_ID' from 'Students' where 'Group_ID' = $group_id";
        $this->db->query($sql);
        return $this->db->assoc();
    }

    public function getStudentsName($group_id)
    {
        $this->table['id'] = getStudentsIDs($group_id);

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

    public function getRatingTable($table_id)
    {


    }

    public function setRatingTable($subject_id, $group_id, $sub_professor_id)
    {
        if($sub_professor_id == 0) $sub_professor_id = $this->id;
        //$this->table['users'] =

        $this->table['users'] = 'Max_rating';

        $sql = "";
        $this->db->query($sql);
        
    }

    public function updateRatingTable($table_id)
    {


    }

    public function getRatingRecord($record_id)
    {
        $sql = "select * from `Ratings` where `Ratings`.`ID` = $record_id";
        $this->db->query($sql);
        //$this->ratingRecords = $this->db->assoc();
    }
    
    public function setRatingRecord($subject_id)
    {

        

    }

    public function getAllRatingRecords()
    {
        $sql = "select * from `Ratings` where `Ratings`.`Professor_ID` = $this->id";
        $this->db->query($sql);
        $this->ratingRecords = $this->db->assoc();
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
