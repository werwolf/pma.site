<?php
class misc
{
    private static $db;
    public static function init($db)
    {
        self::$db = $db;
    }

    public static function getQuote($count,$lang)
    {
        $rand_quote = rand(1,$count);
        $sql = "select `quote_$lang`,`auther_$lang` from `Quotes` limit ".($rand_quote-1).",1";
        self::$db->query($sql);
        
        return self::$db->assoc();
    }
}
?>
