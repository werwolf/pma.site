<?php
class mail
{
    private $db;
    private $page=0;
    private $count=0;
    private $mails = array();
    private $user;

    public function  __construct($db,$user)
    {
        $this->db = $db;
        $this->user = $user;        
    }

    public function initInputOutput($page,$count)
    {
        $this->page = $page;
        $this->count = $count;        
    }
    public function getMailsCount()
    {
        return count($this->mails);
    }
    public function getInputMails()
    {
        if($this->page == 0 || $this->count == 0)
                return false;
        
        $sql = "select `Message`.*,`MessageText`.* ,`Users`.`Name`,`Users`.`Surname`,`Users`.`Patronymic` ".
               "from `Message`,`MessageText`,`Users` ".
               " where `Message`.`Text_ID` = `MessageText`.`ID`  and `Users`.`ID`= `Message`.`From` and ".
               "`Message`.`Whom` = ".$this->user." order by `Message`.`Date_Create` desc ".
               " limit ".($this->page-1)*$this->count.",".$this->count;
        
        $this->db->query($sql);
        $this->mails = $this->db->assocAll();
    }

    public function getOneMailParam($mail,$param)
    {
        if($mail < count($this->mails))
          return $this->mails[$mail][$param];
        else
          return false;
    }
}
?>
