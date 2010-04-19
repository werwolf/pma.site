<?php
class ViewSingleton{

	private static $instance = false;
	private $data = array();

	public static function getInstance(){
		if ( self::$instance === false ) self::$instance = new self();
		return self::$instance;
	}

	private function __construct(){
		// nothing
	}

	public function __set( $key, $value ){
		$this->data[$key] = $value;
	}

	public function __get( $key ){
		if ( !isset( $this->data[$key] ) ) return 'ERR::'.$key;
		return $this->data[$key];
	}

	public function keyExists($key)
	{
		return isset($this->data[$key]);
	}

	public function SetByRef( $key, &$value )
	{
		$this->data[$key] = &$value;
	}

	public function ACAItem($key,$value,$arrkey = null)
	{
		if (!is_array($this->data[$key])) return;

		if (isset($arrkey))
		{
			$this->data[$key][$arrkey] = $value;
		}
		else
		{
			$this->data[$key][] = $value;
		}
	}
}
?>
