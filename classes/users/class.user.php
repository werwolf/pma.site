<?php
class user
{
    protected  $db;
    protected  $user_info;
    protected  $id = 0;
    protected  $isAdmin = false;
    protected  static $is_login = false;
    protected  static $secret = "bdbdes1./";
    
    public function  __construct($db,$id)
    {
        $this->db = $db;
        $this->id = $id;
    }

    public function getUserInformation()
    {        
    }
    public static function checkUser($login,$id,$secret,$db)
    {
        $ip_user = $_SERVER['REMOTE_ADDR'];
        $sql = "select `ID`,`State` from `Users` where `ID` = $id and `Login` = '$login' and".
               " `Session` = '$secret' and `IP_Login` = '$ip_user'";
               
        $db->query($sql);
        if($db->numRows() == 0)
                return false;
                
        $res = $db->assoc();
        self::$is_login = true;

        return $res;
    }
    public function isAdminCheck()
    {
        $sql = "select `id` from `Admins` where `User_ID` = ".$this->getUserId();        
        $this->db->query($sql);

        if($this->db->numRows() > 0)        
            $this->isAdmin = true;

        return $this->isAdmin;
    }
    public static function authentification($login,$pass,$db)
    {
        $sql = "select `ID` as `id` from `Users` where `Login` = '".$db->escape($login)."' and `Password` = '".md5($pass)."'";
       
        $db->query($sql);

        if($db->numRows() == 0)
                return false;
        
        $row = $db->assoc();
        $session = md5($login."_".$pass."_".self::$secret);
        $sql = "update `Users` set `Session` = '".$session."',`IP_Login` = '".$_SERVER['REMOTE_ADDR']."'".
               " where `id` = ".$row['id'];
       
        $db->query($sql);

        session_start();
        $_SESSION['userid'] = $row['id'];
        $_SESSION['user_login'] = $login;
        $_SESSION['hash_user'] = $session;

        return true;
    }
    public function getDate($date_db)
    {
        $date = substr($date_db,0,10);

        $return.= substr($date,8,2).".";
        $return.= substr($date,5,2).".";
        $return.= substr($date,0,4)." ";

        $time = substr($date_db,11,5);

        return $return.$time;
    }
    public function getUserSecret()
    {
        return $_SESSION['hash_user'];
    }
    public static function isLoged()
    {
        return self::$is_login;
    }
    public function Logout()
    {
        $sql = "update `Users` set `Session` = '',`IP_Login` = '' where `ID` = ".$this->getUserId();
        $this->db->query($sql);
        session_destroy();
    }
    public function getUserName()
    {
        return $this->user_info['Name'];
    }
    public function getUserSurname()
    {
        return $this->user_info['Surname'];
    }
    public function getUserPatronymic()
    {
        return $this->user_info['Patronymic'];
    }
    public function getUserSex()
    {
        return $this->user_info['Sex'];
    }
    public function getUserEmail()
    {
        return $this->user_info['Email'];
    }
    public function getUserBirthday()
    {
        return $this->user_info['Birthday'];
    }
    public function getUserContacts()
    {
        return $this->user_info['Contact'];
    }
    public function getUserPhone()
    {
        return $this->user_info['Phone'];
    }
    public function getUserPhoto()
    {
        return $this->user_info['Photo'];
    }
    public function getUserState()
    {
        return $this->user_info['State'];
    }
    public function getUserDescription()
    {
        return $this->user_info['Description'];
    }
    public function getUserLanguage()
    {
        return $this->user_info['Language'];
    }
    public function getUserId()
    {
        return $this->user_info["ID"];
    }
    public function isAdmin()
    {
        return $this->isAdmin;
    }
}

class Professor extends user
{
    private $subjects;
    public function getUserInformation()
    {
        $sql = "select `Users`.*,`Professors`.* from `Users`,`Professors`".
               " where `Users`.`ID` = $this->id and `Professors`.`User_ID` = $this->id";

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

    public function getProfessorSubjectsIds()
    {
        return explode("||",$this->user_info['Subjects']);
    }

    public function getProfessorSubjects()
    {
        return $this->subjects;
    }
    
    public function IsLector()
    {
        if($this->user_info['Lector'] == 0)
                return false;
        else
                return true;
    }
}
class Student extends user
{
    public function getUserInformation()
    {
        $sql = "select `Students`.`ID` as `Stud_ID`,`Students`.`Rank`,`Groups`.`Title`,`Groups`.`Course`,`Groups`.`Sheduler_Path`,`Groups`.`Extranumeral`,".
               "`Groups`.`ID` as `GroupID`,`Users`.* from `Users`,`Students`,`Groups` where `Users`.`ID` = $this->id and `Students`.`User_ID` = `Users`.`ID` and".
               " `Groups`.`ID` = `Students`.`Group_ID`";
             
        $this->db->query($sql);
        $this->user_info = $this->db->assoc();
    }

    public function getUserRank()
    {
        return $this->user_info['Rank'];
    }

    public function getUserGroupName()
    {
        return $this->user_info['Title'];
    }

    public function getUserShedulerPath()
    {
        return $this->user_info['Sheduler_Path'];
    }

    public function getUserExtranumeral()
    {
        if($this->user_info['Extranumeral'] == 0)
                return false;
        else
                return true;
    }

    public function getUserGroupId()
    {
        return $this->user_info['GroupID'];
    }
}
?>
