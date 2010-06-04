<?php

class Root{
	
	private static $POST = array();
	private static $FILES = array();

	public static function Redirect( $Location ){            
		header('Location: '.$Location);
		exit;
	}
	
	public static function Init(){
		self::$POST = $_POST;
		$_POST = array();
                self::$FILES = $_FILES;
                $_FILES = array();                
	}
	
	public static function POSTExists( $key ){
		return isset( self::$POST[$key] );
	}
	
	public static function POSTInt( $key ){
		if ( !isset( self::$POST[$key] ) ) return 0;
		return (int) self::$POST[$key];
	}
	
	public static function POSTString( $key ){
		if ( !isset( self::$POST[$key] ) ) return '';
		return trim(self::$POST[$key]);
	}
	
	public static function POSTHTML( $key ){
		if ( !isset( self::$POST[$key] ) ) return '';
		return  trim(self::$POST[$key]) ;
	}
	
	public static function POSTPure( $key ){
		if ( !isset( self::$POST[$key] ) ) return false;
		return  self::$POST[$key];
	}
	
	public static function POSTAllPure ()
	{
		return  self::$POST;
	}

        public static function POSTKillAll()
        {
                self::$POST="";
                self::$FILES="";
        }

        public static function FILESName($file)
        {  
            return self::$FILES[$file]['name'];
        }

        public static function FILESTmpName($file)
        {
            return self::$FILES[$file]['tmp_name'];
        }

        public static function FILESSize($file)
        {
            return self::$FILES[$file]['size'];
        }

        public static function FILESAllPure()
        {
            return self::$FILES;
        }
}

?>