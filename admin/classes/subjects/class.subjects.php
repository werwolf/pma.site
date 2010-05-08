<?php
require_once("admin/classes/iterator_main/class.iterator_main.php");
class subjects extends iterator_main
{
    public function getSubjects()
    {
        $this->db->query("select * from `Subjects`");
        $this->iter_info = $this->db->assocAll();
        $this->end = count($this->iter_info)-1;
    }

    public function deleteSubject($subject)
    {
        $this->db->query("delete from `Subjects` where `ID` = $subject");
    }

    public function addSubject()
    {
        $langs = config::getAvailableLanguages();
        $semester = Root::POSTPure('semesters');

        $sql = "insert into `Subjects` (`Semester`,";

        for($i = 0;$i < count($langs); $i++)
        {
            $sql .= "Title_".$langs[$i];
            
            if($i<count($langs)-1)
                $sql .= ",";
        }

        $sql .= ") values ('".implode("||",$semester)."',";

        for($i = 0;$i < count($langs); $i++)
        {
            $sql .= "'".$this->db->escape(Root::POSTString('Title_'.$langs[$i]))."'";
            if($i<count($langs)-1)
                $sql .= ",";
        }

        $sql .=")";

        $this->db->query($sql);
    }

    public function getSubjectInfo($subject)
    {
        $sql = "select * from `Subjects` where `ID` = $subject";
        $this->db->query($sql);
        return $this->db->assoc();
    }

    public function editSubject($subject)
    {
        $langs = config::getAvailableLanguages();
        $semester = Root::POSTPure('semesters');

        $sql = "update `Subjects` set `Semester` = '".implode("||",$semester)."',";

        for($i=0;$i<count($langs);$i++)
        {
            $sql .= " `Title_".$langs[$i]."` = '".$this->db->escape(Root::POSTString("Title_".$langs[$i]))."'";
            if($i < count($langs) - 1)
                $sql .= ",";
        }

        $sql .= " where `ID` = $subject";

        $this->db->query($sql);
    }
 }
?>
