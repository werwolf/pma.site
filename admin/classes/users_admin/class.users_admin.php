<?php
require_once("admin/classes/iterator_main/class.iterator_main.php");
class users_admin extends iterator_main
{
    private $page = 1;
    const count_page = 20;

    public function  __construct($db,$page)
    {
        $this->db = $db;
        $this->page = $page;
    }

    public function getUsersCount($state)
    {
        $this->db->query("select `ID` from `Users` where `State` = '$state'");
        return $this->db->numRows();
    }
    
    public function getStudets()
    {
        $sql = "select `Users`.`ID` as `user`,`Users`.`Name`,`Users`.`Surname`,`Users`.`Patronymic`,".
               "`Groups`.`Title` as `Groupe` from `Users`,`Students`,`Groups` where ".
               "`Users`.`State` = 'S' and `Students`.`User_ID` = `Users`.`ID` and `Groups`.`ID` = `Students`.`Groupe_ID`".
               " limit ".($this->page - 1)*self::count_page.",".self::count_page;

        $this->db->query($sql);
        $this->iter_info = $this->db->assocAll();
        $this->end = count($this->iter_info)-1;
    }

    public function getStudentsFromGroups($groups)
    {
        $sql = "select `Users`.`ID` as `user`,`Users`.`Name`,`Users`.`Surname`,`Users`.`Patronymic` ".
               " from `Users`,`Students` where `Students`.`Groupe_ID` = $groups and `Users`.`ID` = `Students`.`User_ID`";

        $this->db->query($sql);
        $this->iter_info = $this->db->assocAll();
        $this->end = count($this->iter_info)-1;
    }
    
    public function getProfessors()
    {
        $sql = "select `Users`.`ID` as `user`,`Users`.`Name`,`Users`.`Surname`,`Users`.`Patronymic`".
               " from `Students`,`Users` where `Users`.`State` = 'P'".
               " limit ".($this->page - 1)*self::count_page.",".self::count_page;
               
        $this->db->query($sql);
        $this->iter_info = $this->db->assocAll();
        $this->end = count($this->iter_info)-1;
    }

    public function getProfessorsForCalendar()
    {
        $sql = "select `Users`.`ID` as `user`,`Users`.`Name`,`Users`.`Surname`,`Users`.`Patronymic`".
               " from `Users` where `Users`.`State` = 'P'";

        $this->db->query($sql);
        $this->iter_info = $this->db->assocAll();
        $this->end = count($this->iter_info)-1;
    }
    
    private function addUser($who_is)
    {
        $surname = $this->db->escape(Root::POSTString("surname"));
        $name = $this->db->escape(Root::POSTString("name"));
        $patronymic = $this->db->escape(Root::POSTString("patronymic"));
        $sex = $this->db->escape(Root::POSTString("sex"));
        $login = $this->db->escape(Root::POSTString("login"));
        $password = Root::POSTString("password");

        $sql = "insert into `Users` (`Name`,`Surname`,`Patronymic`,`Sex`,`Login`,`Password`,`State`) values (".
               "'$name','$surname','$patronymic','$sex','$login','".md5($password)."','$who_is')";
        
        $this->db->query($sql);

        $this->db->query("select `ID` from `Users` order by `ID` desc limit 0,1");
        $res = $this->db->assoc();

        return $res['ID'];
    }
    public function addStudent()
    {
        $res = $this->addUser("S");
        $group = $this->db->escape(Root::POSTString("group"));
        $state = $this->db->escape(Root::POSTString("state"));

        $sql = "insert into `Students` (`User_ID`,`Groupe_ID`,`Rank`) values (".$res.
               ",$group,'$state')";
        $this->db->query($sql);
    }

    public function addLector()
    {
        $res = $this->addUser("P");
        $lector = Root::POSTInt("lector");
        $subject = Root::POSTPure("subjects");        
        $subjects = implode("||",$subject);

        $sql = "insert into `Professors` (`User_ID`,`Lector`,`Subjects`) values (".
               "$res,$lector,'$subjects')";
        
        $this->db->query($sql);
    }

    public function deleteUser($id,$state)
    {
        $this->db->query("delete from `Users` where `ID` = $id");

        if($state == "students")
            $this->db->query("delete from `Students` where `User_ID` = $id");
        elseif($state == "lectors")
            $this->db->query("delete from `Professors` where `User_ID` = $id");
    }
}
class one_user_info
{
    private static $db;

    public static function init($db)
    {
        self::$db = $db;
    }

    public static function getUserInfo($id,$state)
    {
        if($state == "P")
            $sql = "select `Users`.*,`Professors`.* from `Users`,`Professors` where `Users`.`ID` = $id and `Professors`.`User_ID` = $id";
        else
            $sql = "select `Users`.*,`Students`.* from `Users`,`Students` where `Users`.`ID` = $id and `Students`.`User_ID` = $id";

        self::$db->query($sql);
        return self::$db->assoc();
    }

    public static function updatUser($id)
    {
        $name = self::$db->escape(Root::POSTString("name"));
        $surname = self::$db->escape(Root::POSTString("surname"));
        $patronymic = self::$db->escape(Root::POSTString("patronymic"));
        $email = self::$db->escape(Root::POSTString("email"));
        
        if(strlen(Root::POSTString("pass1")) > 0 && strlen(Root::POSTString("pass2")) > 0 && Root::POSTString("pass1") == Root::POSTString("pass2"))
        {
            $pass = self::$db->escape(Root::POSTString("pass1"));
        }
        elseif(strlen(Root::POSTString("pass1")) > 0 && strlen(Root::POSTString("pass2")) > 0 && Root::POSTString("pass1") != Root::POSTString("pass2"))
        {
            $pass = "error";
        }

        $sql = "update `Users` set `Name` = '$name',`Surname` = '$surname',`Patronymic` = '$patronymic',".
               "`Email` = '$email' ";

        if($pass != "")
            $sql .= ",`Password` = '".md5($pass)."' ";

        $sql .= " where `ID` = $id";
        self::$db->query($sql);

        if($pass == "error")
            return false;
        else
            return true;
    }
    public static function changeLectorInfo($lector)
    {
        $pass = self::updatUser($lector);

        $lector_is = Root::POSTInt("lector");
        if(count(Root::POSTPure("subjects")) > 1)
            $subjects = implode("||",Root::POSTPure("subjects"));
        else
        {
            $subjects = Root::POSTPure("subjects");
            $subjects = $subjects[0];
        }
        $sql = "update `Professors` set `Subjects` = '$subjects', `Lector` = $lector_is where `ID` = $lector";

        self::$db->query($sql);

        return $pass;
    }
    public static function changeStudentInfo($student)
    {
        $pass = self::updatUser($student);
     
        $state = self::$db->escape(Root::POSTString("state"));
        $groupe = Root::POSTInt("group");
        
        $sql = "update `Students` set `Rank` = '$state',`Groupe_ID` = $groupe where `User_ID` = $student";
        
        self::$db->query($sql);
        
        return $pass;
    }
}

?>
