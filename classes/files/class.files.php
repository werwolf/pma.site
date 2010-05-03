<?php
class files
{
    private static $db;
    private static $viewextensions;
    private static $max_file_size;
    private static $uploaded_dir;

    public static function init($db,$viewextensions,$max_size)
    {
        self::$db = $db;
        self::$viewextensions = $viewextensions;
        self::$max_file_size = $max_size;        
    }
    public static function initDB($db)
    {
        self::$db = $db;
    }
    public static function setDirectory($dir)
    {
        self::$uploaded_dir = $dir;
    }
    public static function checkExtension($file)
    {
       if (count(self::$viewextensions) != 0)
       {  
          if(strlen($file) == 0)
                   return false;

          $file_ext = strtolower(self::getExtension($file));
          
          foreach (self::$viewextensions as $ext)
          {
               if ($file_ext == $ext)
                  return true;
               
          }
          return false;
       }
       else  
       {
          return true;
       }
    }
    public static function checkPicture($extens,$pict)
    {  
        if(strlen($pict) != 0)
        {
            $pict_exten = strtolower(self::getExtension(trim($pict)));
           
            foreach($extens as $ext)
            {
                if($pict_exten == $ext)
                         return true;
            }
            return false;
        }
        else
        {
            return true;
        }
    }
    public static function checkFileSize($size)
    {
        if($size > self::$max_file_size) return false;
        else return true;
    }

    public static function getExtension($filename)
    {
       return end(explode(".",$filename));
    }

    public static function getFileName($file)
    {
        $parts = explode(".".self::getExtension($file), $file);
        return $parts[0];
    }

    public static function checkFileExists($file)
    {
        if(file_exists(self::$uploaded_dir.$file))
        {            
            $extension = self::getExtension($file);$i = 0;
            $filename = self::getFileName($file);
            
            while(true)
            {
                if(!file_exists(self::$uploaded_dir.$filename.$i.".".$extension))
                {
                    $file = $filename.$i.".".$extension;
                    break;
                }
                $i++;
            }
            return $file;
        }
        else
        {
            return $file;
        }
    }
    public static function isFileOnServer($filename)
    {
        if(file_exists($filename))
            return true;
        else
            return false;
    }
    public static function uploadFile($file,$newFileName)
    {
        if(!copy($file,self::$uploaded_dir.$newFileName)){
            return false;}
        else
            return true;
    }
    public static function getFilesPage($page,$count,$order)
    {
        $sql = "select `Files`.`Title` as `File`,`Files`.`Filepath`,`Files`.`Semester`,`Files`.`Description`,`Files`.`ID`,".
               "`Subjects`.`Title`  as `Subject` from `Files`,`Subjects` where `Files`.`Subject_ID` = `Subjects`.`ID` ".$order." ".
               " limit ".($page-1)*$count.",$count";
        
        self::$db->query($sql);

        return self::$db->assocAll();
    }
    public static function getSubjects()
    {
        $sql = "select `Title`,`ID` from `Subjects` order by `Title`";
        self::$db->query($sql);
        return self::$db->assocAll();
    }
    public static function getFilesCount($params)
    {
        $sql = "select count(*) as `count` from `Files` $params";
        self::$db->query($sql);
        $result = self::$db->assoc();
        return $result['count'];
    }
    public static function getFileInformation($id)
    {
        $sql = "select `Files`.`Title` as `File`,`Files`.`Filepath`,`Files`.`Semester`,`Files`.`Description`,`Files`.`ID`,".
               "`Subjects`.`Title`  as `Subject`,`Files`.`Cover`,`Users`.`Name`,`Users`.`Surname`,`Users`.`Patronymic` ".
               "from `Files`,`Subjects`,`Users` where `Files`.`Subject_ID` = `Subjects`.`ID` ".
               " and `Files`.`ID` = $id and `Users`.`ID` = `Files`.`Master`";

        self::$db->query($sql);
        return self::$db->assoc();
    }
    public static function deleteFile($file)
    {
        unlink(self::$uploaded_dir.$file);
    }
    public static function getUserPhoto($file)
    {
        return end(explode("/",$file));
    }
}
?>
