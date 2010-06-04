<?php
require_once("admin/classes/iterator_main/class.iterator_main.php");

class groups extends iterator_main
{
    public function getGroups()
    {
        $sql = "select `Title`,`ID`,`Extranumeral`,`Course` as `Kurs`".
               " from `Groups` order by `Course`,`Extranumeral`";
        $this->db->query($sql);
        $this->iter_info = $this->db->assocAll();
        $this->end = count($this->iter_info)-1;
    }

    public function deleteGroup($id)
    {
        $this->db->query("delete from `Groups` where `ID` = $id");
        $this->db->query("select `User_ID` from `Students` where `Groupe_ID` = $id");
        $res = $this->db->assocAll();
        $this->db->query("delete from `Students` where `Groupe_ID` = $id");

        if(count($res) > 0)
        {
            $sql = "delete from `Users` where ";
        
            for($i=0;$i<count($res);$i++)
            {
                $sql .= " `ID` = ".$res[$i]['User_ID'];
                if($i<count($res)-1)
                    $sql .=" or ";
            }

            $this->db->query($sql);
        }
    }

    public function editGroup($group)
    {
        $title = $this->db->escape(Root::POSTString("title"));
        $course = $this->getDateToDB(Root::POSTString("course"));
        $extranumeral = Root::POSTInt("extranumeral");

        $sql = "update `Groups` set `Title` = '$title',`Course` = '$course',".
               "`Extranumeral` = $extranumeral where `ID` = $group";

        $this->db->query($sql);
    }

    private function getDateToDB($date)
    {
        $return .= substr($date,6,4)."-";
        $return .= substr($date,3,2)."-";
        $return .= substr($date,0,2);

        return $return;
    }

    public function getCourse($date)
    {
        $ret = date("Y") - substr($date,0,4);

        if((date("m") - substr($date,5,2)) > 0)
                $ret++;
        
        return $ret;
    }

    public function addGroup()
    {
        $title = $this->db->escape(Root::POSTString("title"));
        $course = $this->getDateToDB(Root::POSTString("course"));
        $extranumeral = Root::POSTInt("extranumeral");

        $sql = "insert into `Groups` (`Title`,`Course`,`Extranumeral`) values (".
               "'$title','$course',$extranumeral)";
        
        $this->db->query($sql);
    }

    public function getDate($date_db)
    {        
        $date = substr($date_db,0,10);

        $return.= substr($date,8,2).".";
        $return.= substr($date,5,2).".";
        $return.= substr($date,0,4)." ";       

        return $return;
    }
    
    public function getGroupInfo($group)
    {
        $this->db->query("select * from `Groups` where `id` = $group");
        return $this->db->assoc();
    }
}
?>
