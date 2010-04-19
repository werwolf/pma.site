<?php
class config
{
    private static $db;
    private static $default_lang = "ua";
    private static $available_langs = array();
    private static $message_per_page = 0;
    private static $count_of_new_news = 0;

    public static function init($db)
    {
        self::$db = $db;
    }

    public static function loadConfig()
    {
        self::$db->query("select * from `configs`");

        while($row = self::$db->assoc())
        {
            switch($row['key'])
            {
                case 'language_default':
                        self::$default_lang = $row['value'];
                break;
                case 'languages':
                        preg_match_all("/(.*?){2}\|\|/",$row['value'],$temp);                        
                        self::$available_langs = $temp[1];
                break;
                case 'message_per_page':
                        self::$message_per_page = $row['value'];
                break;
                case 'new_news':
                        self::$count_of_new_news = $row['value'];
                break;
            }
        }        
    }

    public static function getDefaultLanguage()
    {
        return self::$default_lang;
    }

    public static function getMessagesPerPage()
    {
        return self::$message_per_page;
    }

    public static function getCountNewNews()
    {
        return self::$count_of_new_news;
    }

    public static function isInAvailableLang($lang)
    {
        $flag = false;
        
        for($i = 0;$i < count(self::$available_langs); $i++)
        {
            if(self::$available_langs[$i] == $lang)
            {
                  $flag = true;break;
            }
        }
        return $flag;
    }

    public static function setDefaultLanguage($lang)
    {
        self::$default_lang = $lang;
    }

    public static function getLanguagesFlags($URL)
    {
        $index = 0;
        foreach(self::$available_langs as $langs)
        {
            if($langs != self::$default_lang)
            {
                $return[$index]['lang'] = $langs;
                $return[$index]['url'] = "/".$langs.substr($URL,3);
                $index++;
            }
        }

        return $return;
    }
}
?>
