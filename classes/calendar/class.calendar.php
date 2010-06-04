<?php
require_once("admin/classes/iterator_main/class.iterator_main.php");

class calendar extends iterator_main
{
    private $dates_with_messages = array();
    private $from = "";

    public function makeCalendar($year, $month)
    {
          $wday = JDDayOfWeek(GregorianToJD($month, 1, $year), 0);

          if ($wday == 0) $wday = 7;

          $n = - ($wday - 2);
          $cal = array();

          for ($y=0; $y<6; $y++)
          {
                $row = array();
                $notEmpty = false;

                for ($x=0; $x<7; $x++, $n++)
                {
                    if (checkdate($month, $n, $year))
                    {
                        $row[] = $n;
                        $notEmpty = true;
                    }
                    else
                    {
                        $row[] = "";
                    }
                }
                if (!$notEmpty) break;

                $cal[] = $row;
            }
        $this->iter_info = $cal;
        $this->end = count($this->iter_info);
    }

    public function addMessage($userID,$date)
    {
        try
        {
            $sql = "insert into `MessageText` (`Text`,`Subject`) values (".
                   "'".$this->db->escape(Root::POSTString("text"))."','".$this->db->escape(Root::POSTString("subject"))."')";
        
            if(!$this->db->query($sql))
                    throw new Exception();

            if(!$this->db->query("select `ID` from `MessageText` order by `ID` desc limit 0,1"))
                    throw new Exception();
            
            $res = $this->db->assoc();

            $sql = "insert into `CalendarMessage` (`From`,`To`,`Date`,`Message_ID`) values (".
                   "$userID,$userID,'$date',".$res['ID'].")";

            if(!$this->db->query($sql))
                    throw new Exception();

            return true;
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    public function getDateWithMessages($date,$user_id)
    {
        $sql = "select `From`,Day(`Date`) as `Day` from `CalendarMessage` ".
               "where Month(`Date`) = ".$date['month']." and Year(`Date`) = ".$date['year'].
               " and `To` = $user_id";
        try
        {
            $this->db->query($sql);
        }
        catch(MySQLException $e)
        {
            return false;
        }

        $this->dates_with_messages = $this->db->assocAll();
    }

    public function isWithMessage($day)
    {
        $flag = true;

        for($i = 0;$i<count($this->dates_with_messages);$i++)
        {
            if($day == $this->dates_with_messages[$i]['Day'])
            {$flag = false;break;}
        }
        $this->from = $this->dates_with_messages[$i]['From'];
        
        if($flag)
            return false;
        else
            return true;
    }

    public function getMyMessagesByDate($date,$user_id)
    {     
        $sql = "select `MessageText`.`Text`,`MessageText`.`Subject` from `CalendarMessage`,`MessageText` ".
               "where `CalendarMessage`.`Date` = '$date' and `CalendarMessage`.`To` = $user_id".
               " and `MessageText`.`ID` = `CalendarMessage`.`Message_ID` and `CalendarMessage`.`From` = $user_id";
         
        try
        {
            $this->db->query($sql);
        }
        catch(MySQLException $e)
        {
            return false;
        }
        
        $this->iter_info = $this->db->assocAll();
        $this->end = count($this->iter_info);

        return true;
    }

    public function getInboxMessagesByDate($date,$user_id)
    {
        $sql = "select `MessageText`.`Subject`,`MessageText`.`Text`,`Users`.`Name`,`Users`.`Surname`,`Users`.`Patronymic`".
               " from `CalendarMessage`,`MessageText`,`Users` ".
               " where `CalendarMessage`.`Date` = '$date' and `CalendarMessage`.`To` = $user_id".
               " and `MessageText`.`ID` = `CalendarMessage`.`Message_ID` and `CalendarMessage`.`From` <> `CalendarMessage`.`To`".
               " and `Users`.`ID` = `CalendarMessage`.`From`";
        try
        {
            $this->db->query($sql);
        }
        catch(MySQLException $e)
        {
            return false;
        }

        $this->iter_info = $this->db->assocAll();
        $this->end = count($this->iter_info);

        return true;
    }
    public function getFrom()
    {
        return $this->from;
    }
}
?>
