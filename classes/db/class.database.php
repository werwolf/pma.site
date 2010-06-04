<?
/**
 * Класс, занимающийся коннектом и общением с базой данных
 *
 */
class MySQLDatabase {
	/**
	 * Константа запроса к базе данных: SELECT
	 *
	 */
	const OP_SELECT = 1;
	/**
	 * Константа запроса к базе данных: INSERT
	 *
	 */
	const OP_INSERT = 2;
	/**
	 * Константа запроса к базе данных: UPDATE
	 *
	 */
	const OP_UPDATE = 3;
	/**
	 * Константа запроса к базе данных: DELETE
	 *
	 */
	const OP_DELETE = 4;
	/**
	 * Константа запроса к базе данных: неизвестный запрос
	 * (TRUNCATE, DESCRIBE TABLE и так далее)
	 *
	 */
	const OP_UNKNOWN = 0;
	
	/**
	 * Конфигурация подключения к базе данных
	 *
	 * @var MySQLConfiguration
	 */
	private $configuration;
	/**
	 * Указатель на соединение с MySQL
	 *
	 * @var resource
	 */
	private $conn;
	
	/**
	 * Флаг установки подключения
	 *
	 * @var bool
	 */
	private $connected = false;
	/**
	 * Флаг, определяющий, бросает ли класс Exceptions в
	 * случае возникновения ошибки
	 *
	 * @var bool
	 */
	private $throw_Exceptions = true;
	/**
	 * Переменная, в которой хранится тип последнего выполненого
	 * запроса к базе данных 
	 *
	 * @var unknown_type
	 */
	private $last_operation = self::OP_UNKNOWN;
	/**
	 * Указатель на результат запроса
	 *
	 * @var resource
	 */
	private $result = false;
	/**
	 * Время, затраченое на выполнение запросов
	 *
	 * @var int
	 */
	private $time = 0;
	/**
	 * Общее количество запросов к базе данных
	 *
	 * @var int
	 */
	private $queries = 0;
	/**
	 * Флаг, определяющий то, будет ли производится дамп запросов к базе данных
	 *
	 * @var bool
	 */
	private static $qd_flag = false;
	/**
	 * Массив с дампом запросов к базе
	 *
	 * @var array
	 */
	private static $queries_dump = array();
	
	/**
	 * Конструктор, принирмающий специальный объект-конфигуратор.
	 *
	 * @param MySQLConfiguration $cnf
	 */
	public function __construct( $cnf ){
		// Устанавливаем объект конфигуратор во внутреннюю
		// переменную
		$this->configuration = $cnf;
		
		//$this->stopExceptions();
	}
	/**
	 * Метод, включающий дамп запросов, посылаемых на базу данных
	 *
	 */
	public function EnableQueriesDump(){ self::$qd_flag = true; }
	/**
	 * Метод, возвращающий дамп запросов к базк данных
	 *
	 * @return array
	 */
	public static function GetQueriesDump(){ return self::$queries_dump; }
	
	/**
	 * Матод, запрещающий классу бросать Exception, а вместо того сразу отображать ошибку
	 *
	 */
	public function stopExceptions(){ $this->throw_Exceptions = false; }
	
	/**
	 * Функция, занимающаяся отображением ошибки.
	 * В зависимости от того, должен ли класс бросать Exception-ы или нет
	 * вызывает соответствующие методы
	 *
	 * @param string $message
	 * @param string $MySQL_message
	 * @param int $MySQL_error_code
	 * @param string $MySQL_SQL
	 */
	private function halt( $message, $MySQL_message, $MySQL_error_code, $MySQL_SQL ){
		// Если класс должен бросать Exception-ы -
		// бросаем специальный MySQLException с параметрами
		if ( $this->throw_Exceptions )
		{
			throw new MySQLException( $message, $MySQL_message, $MySQL_error_code, $MySQL_SQL );
		}
		// Ели нет - значит должны отобразить текстовую/HTML ошибку.
		// Решение о том, в каком формате отображать ошибку (текст/HTML)
		// принимается на основе того, установлен ли $_SERVER['SHELL'].
		// Если он установлен - считаем что скрипт выполняется из командной строки,
		// соответственно должны отобразить текстовую ошибку.
		// Если же его нет - считаем, что скрипт запущен из браузера, соответственно,
		// должны отобразить красивое HTML-сообщение об ошибке.
		if ( isset( $_SERVER['SHELL'] ) )
			$this->haltPLAIN( $message, $MySQL_message, $MySQL_error_code, $MySQL_SQL );
		else
			$this->haltHTML( $message, $MySQL_message, $MySQL_error_code, $MySQL_SQL );
		
		// На всякий пожарный умираем с ошибкой, если вдруг еще не умерли
		die( $message );
	}
	
	/**
	 * Отображение ошибки в HTML-формате. 
	 *
	 * @param string $message
	 * @param string $MySQL_message
	 * @param int $MySQL_error_code
	 * @param string $MySQL_SQL
	 */
	private function haltHTML( $message, $MySQL_message, $MySQL_error_code, $MySQL_SQL ){
		// Вываливаем HTML-код сообщения об ошибке с указанием сообщения, кода
		// ошибки, сообщения об ошибке от MySQL и запроса, который и породил
		// ошибку. После этого вываливаемся.
		echo '<div style="color: red; font: bold 20px monospace; border-bottom: 1px solid red;">database error</div>';
		echo '<table border=0 style="font: normal 12px monospace;">';
		echo '<tr><td valign="top">Текст сообщения:</td><td>'.$message.'</td></tr>';
		echo '<tr><td valign="top">Код ошибки MySQL:</td><td>'.$MySQL_error_code.'</td></tr>';
		echo '<tr><td valign="top">Текст ошибки MySQL:</td><td>'.$MySQL_message.'</td></tr>';
		echo '<tr><td valign="top">SQL запрос:</td><td>'.$MySQL_SQL.'</td></tr>';
		echo '</table>';
		exit;
	}
	
	/**
	 * Отображение ошибки в текстовом формате. 
	 *
	 * @param string $message
	 * @param string $MySQL_message
	 * @param int $MySQL_error_code
	 * @param string $MySQL_SQL
	 */
	private function haltPLAIN( $message, $MySQL_message, $MySQL_error_code, $MySQL_SQL ){
		// Вываливаем текстовое сообщения об ошибке с указанием сообщения, кода
		// ошибки, сообщения об ошибке от MySQL и запроса, который и породил
		// ошибку. После этого НЕ вываливаемся, а продолжаем работу.
		// Все равно вывалимся в halt-е в конце.
		echo "\n===== MySQL error =====\n";
		echo "<message>          : $message\n";
		echo "<mysql error code> : $MySQL_error_code\n";
		echo "<mysql message>    : $MySQL_message\n";
		echo "<SQL>:\n $MySQL_SQL\n\n";
	}
	
	/**
	 * Подключение к базе данных
	 *
	 */
	private function connect(){
		// Если вдруг внезапно флаг того, что мы не подключены
		// не стоит - просто вывалится из функции
		if ( $this->connected ) return;	// уже подключены, странно...
		
		// Устанавливаем подключение к базе данных,
		// используя объект конфига, который был передан
		// конструктору при создании объекта.
		$this->conn = @mysql_connect( 
			$this->configuration->getServer(), 
			$this->configuration->getUser(), 
			$this->configuration->getPassword(), 
			true );
		
		// Если  подключиться не удалось - значит
		// надо вывалить сообщение об ошибке и вывалиться самому.
		if ( false === $this->conn ){
			// Не удалось подключиться
			$this->halt( 'Connect to database failed', mysql_error(), mysql_errno(), '' );
		}
		
		// Выбираем базу данных и, если не получилось - вываливаемся
		// с ошибкой.
		$result = mysql_select_db( $this->configuration->getDatabase(), $this->conn );
		if ( false === $result ){
			// Не удалось выбрать базу данных
			$this->halt( 'Error while selecting data base', mysql_error( $this->conn ), mysql_errno( $this->conn ), '' );
		}
		
		// Меняем кодировку. К этому моменту считается, что подключение
		// прошло успешно. Теперь посылаем два запроса к базе данных,
		// устанавливающие кодировку подключения.
		// NB: запросы на изменение кодировки посылаются тогда и только тогда,
		// когда в конфигурационном объекте непусто соответствующее поле
		if ( '' != $this->configuration->getEncoding() ){
			// Указываем, в какой кодировке мы будем общаться с сервером
			mysql_query( 'set character_set_connection='.$this->configuration->getEncoding(), $this->conn);
			// Указываем, в какой кодировке мы будем общаться с сервером
			mysql_query( 'set names '.$this->configuration->getEncoding(), $this->conn);
		}
		
		// всё окей
		$this->connected = true;
	}
	
	/**
	 * Экранирование строк
	 *
	 * @param string $text
	 * @return string
	 */
	public function escape( $text ){
		if ( !$this->connected ) $this->connect();	// Устанавливаем подключение 
		if ( get_magic_quotes_gpc() ){				// Проверка на включенные  magic_quotes_GPC
			$text = stripslashes( $text );
		}
		
		return mysql_real_escape_string( $text, $this->conn );
	}
	
	/**
	 * Выполнение SQL запроса
	 *
	 * @param string $SQL
	 * @return resource
	 */
	public function query( $SQL ){
		// Если до сих пор не подключены - выполнить подключение
		if ( !$this->connected ) $this->connect();	// Устанавливаем подключение 
		
		// Очищаем предыдущий запрос, если, конечно,
		// есть что очищать, то есть, последний запрос был
		// SELECT
		if ( $this->last_operation == self::OP_SELECT ){
			@mysql_free_result( $this->result );
		}
		
		// Определяем тип запроса: первые 6 символов 
		// команды, переведенные в верхний регистр -
		// собственно, тип, который и проверяем.
		$operation = strtoupper(substr( trim( $SQL ), 0, 6 ));
		switch ( $operation ){
			// 'SELECT' - устанавливаем переменную, хранящую
			// тип последней операции в OP_SELECT
			case 'SELECT':
				$this->last_operation = self::OP_SELECT;
				break;
			// Для 'INSERT', 'UPDATE', 'DELETE'
			case 'INSERT':
				$this->last_operation = self::OP_INSERT;
				break;
			case 'UPDATE':
				$this->last_operation = self::OP_UPDATE;
				break;
			case 'DELETE':
				$this->last_operation = self::OP_DELETE;
				break;
			// Если первые 6 символов не совпали ни с одним из
			// вышеперечисленных запросов, примеру - 'TRUNCA'(от 'TRUNCATE')
			default:
				$this->last_operation = self::OP_UNKNOWN;
		}
		// Засекаем время выполнения запроса к баз данных и
		// выполняем запрос.
		$start = microtime( true );
		$this->result = mysql_query( $SQL, $this->conn );
		 // Выполняем запрос
		// Проверяем, не призошло ли какой ошибки. Если таки произошла - 
		// дропаемся с ошибкой/эксепшеном.
		if ( false === $this->result ){
			// Запрос неудачен
			$this->halt( 'SQL query failed', mysql_error( $this->conn ), mysql_errno( $this->conn ), $SQL );
		}
		// Если запрос был удачен - прибавляем затраченное на исполнение время
		// (microtime( true ) - $start) к переменной, хранящей общее время
		// исполнения запросов к базе данных.
		$this->time += microtime( true ) - $start;
		// Инкрементируем количество выполненых команд.
		$this->queries++;
		// Если установлен флаг дампа запросов - добавляем
		// еще одну запись в массив дампа - массив с двумя полями:
		// 'time' - время, потраченое на выполнение запроса
		// 'SQL' - собственно, сам запрос
		if ( self::$qd_flag ){
			self::$queries_dump[] = array(
				'time'=>microtime( true ) - $start,
				'SQL'=>$SQL
			);
		}
		// Возвращаем ресурс-указатель на результат запроса (В случае,
		// если тип запроса это подразумевает) или true, в остальных случаях.
		// Вариант возврата false не учитывается:  $this->result===false
		// перехватывается раньше.
		return $this->result;
		
	}
	
	/**
	 * Метод выполняет операцию UPDATE как надстройка над методом query,
	 * позволяющая значиельно упростить процесс апдейта
	 * Примечание: можно также неявно задавать лимит строк, которые будут обновлены,
	 * с помощью указания 'LIMIT n' как окнец строки параметра $condition.
	 *
	 * @param string $table
	 * @param string $condition
	 * @param array $array Ассоциативный массив, в котором ключи - поля. а значения - новые значения полей
	 * @param boolean $proc_keys Флаг "окантовки" полей в "`"
	 * @param boolean $proc_values Флаг "окантовки" значений в "'"
	 * @param boolean $escape_values Флаг экранирования значений
	 * @return resource
	 */
	public function update( $table, $condition, $array, $proc_keys = true, $proc_values = true, $escape_values = true ){
		// Массив, в котором будут храниться пары `поле`="значение"
		// для последующего преобразования в строку и подстановку в
		// результирующий запрос к базе данных
		$values = array();
		// Пробегаемся по массиву полей-значений
		foreach ( $array as $k=>$v ){
			// Если стоит Флаг "окантовки" полей в "`" - 
			// "обрамляем" поля в "`"
			if ( $proc_keys ) $k = '`'.$this->escape($k).'`';
			// Если стоит Флаг экранирования значений - 
			// экранируем значения
			if ( $escape_values ) $v = $this->escape( $v );
			// Если стоит Флаг "окантовки" значений в "'" - 
			// "обрамляем" значения в "'"
			if ( $proc_values ) $v = "'$v'";
			// Добавляем еще один элемент в массив с парами
			// `поле`="значение"
			$values[] = "$k=$v";
		}
		// Конструируем запрос с учетом указанной в параметрах метода таблицы,
		// условия обновления и вышесконструированного массива пар `поле`="значение", котрый
		// "имплодим" по ", "
		$SQL = 'UPDATE `'.$table.'` SET '.implode( ', ', $values ).' WHERE '.$condition;
		
		// Возвращаем результат выполнения метода query
		return $this->query( $SQL );
	}

	/**
	 * Операция INSERT
	 *
	 * @param string $table
	 * @param array $array
	 * @param array $array Ассоциативный массив, в котором ключи - поля. а значения - новые значения полей
	 * @param boolean $proc_keys Флаг "окантовки" полей в "`"
	 * @param boolean $proc_values Флаг "окантовки" значений в "'"
	 * @param boolean $escape_values Флаг экранирования значений
	 * @return resource
	 */
	public function insert($table, $array, $proc_keys = true, $proc_values = true, $escape_values = true ){
		// Массив значений
		$values = array();
		// Массив ключей
		$keys = array();
		// Пробегаемся по предоставленномув параметрах
		// массиву полей-значений
		foreach ( $array as $k=>$v ){
			// Если стоит Флаг "окантовки" полей в "`" - 
			// "обрамляем" поля в "`"
			if ( $proc_keys ) $k = '`'.$this->escape($k).'`';
			// Если стоит Флаг экранирования значений - 
			// экранируем значения
			if ( $escape_values ) $v = $this->escape( $v );
			// Если стоит Флаг "окантовки" значений в "'" - 
			// "обрамляем" значения в "'"
			if ( $proc_values ) $v = "'$v'";
			// Добавляем новый элемент в массив полей
			$keys[] = $k;
			// Добавляем новый элемент в массив значений
			$values[] = $v;
		}
		// Конструируем запрос с учетом указанной в параметрах метода таблицы,
		//  и вышесконструированных массивов полей и значений, котрые
		// "имплодим" по ", "
		$SQL = 'INSERT INTO `'.$table.'`('.implode(', ', $keys).') VALUES ('.implode(', ', $values).')';
		// Возвращаем результат выполнения метода query
		return $this->query( $SQL );
	}
	
	/**
	 * Метод убирает лишние экранирующие символы из массива
	 *
	 * @param array $array
	 * @return array
	 */
	private function unescape_array( $array ){
		// Пробегаемся по массиву
		foreach ( $array as $key=>$value ){
			// Каждый элемент массива прогоняем через stripslashes
			$array[$key] = stripslashes( $value );
		}
		// Возвращаем массив с удаленными экранирующими слэшами
		return $array;
	}
	
	/**
	 * Возвращает одну ассоциативную строку результата
	 *
	 * @param boolean $force_unescape
	 * @return array
	 */
	public function assoc( $force_unescape = true ){
		// Если последняя операция не может возвратить результ,
		// то есть не SELECT и не "неизвестная операция" (Пример - DESCRIBE TABLE),
		// то вываливаемся с ошибкой
		if ( $this->last_operation != self::OP_SELECT && $this->last_operation != self::OP_UNKNOWN ) $this->halt( 'Last operation wasnt an SELECT', '', '', '' );
		// Получаем одну строчку результата как ассоциативный массив
		// по предоставленному ресурсу-указателю на результат
		$row = mysql_fetch_assoc( $this->result );
		// Если установлен флаг удаления экранирующих символов и
		// полученный результат - масив ('TRUNCATE' расценивается как
		// "неизвестная операция", но не возвращает никакого результата),
		// то вызываем функцию удаления экранирующих символов с
		// этим массивом в параметрах
		if ( $force_unescape && is_array( $row ) ) $row = $this->unescape_array( $row );
		// Возвращаем (не)разэкранированный ассоциативный массив, содержащий первую строчку результата
		return $row;
	}
	
	/**
	 * Возврящает оставшиеся строки в виде двухмерного ассоциативного массива
	 *
	 * @param boolean $force_unescape
	 * @return array
	 */
	public function assocAll( $force_unescape = true ){
		if ( $this->last_operation != self::OP_SELECT && $this->last_operation != self::OP_UNKNOWN ) $this->halt( 'Last operation wasnt an SELECT', '', '', '' );
		
		$result = array();
		while ( $row = mysql_fetch_assoc( $this->result ) ){
			if ( $force_unescape ) $row = $this->unescape_array( $row );
			$result[] = $row;
		}
		
		return $result;
	}
	
	/**
	 * Возвращает количество строк в ответе
	 *
	 * @return integer
	 */
	public function numRows(){
		if ( $this->last_operation != self::OP_SELECT && $this->last_operation != self::OP_UNKNOWN ) $this->halt( 'Last operation wasnt an SELECT', '', '', '' );
		
		return mysql_num_rows( $this->result );
	}
	
	public function affectedRows()
	{
		if ( $this->last_operation != self::OP_UPDATE ) $this->halt( 'Last operation wasnt an UPDATE', '', '', '' );
		
		return mysql_affected_rows( $this->conn );
	}
	
	/**
	 * Возвращает TRUE, если результат последнего SELECT запроса пустой
	 *
	 * @return boolean
	 */
	public function isEmpty(){
		// Возвращаем true, если результат последнего SELECT запроса пустой
		if ( 0 === $this->numRows() ) return true;
		// Иначе - возвращаем false
		return false;
	}
	
	/**
	 * Возвращаем id последнего запроса INSERT
	 */
	public function insertId(){
		// Если последний запрос был не INSERT - вываливаемся
		// с ошибкой и сообщением об этом
		if ( $this->last_operation != self::OP_INSERT ) $this->halt( 'Last operation wasnt an INSERT', '', '', '' );
		// Если таки INSERT и не вывалились строчкой ранее -
		// возвращаем id последнего запроса
		return mysql_insert_id( $this->conn );
	}
	
	/**
	 * Возвращает количество использованных запросов к БД
	 *
	 * @return integer
	 */
	public function getQueriesCount(){ return $this->queries; }
	
}

/**
 * Класс, объект которого используется для конфигурации класса
 * базы данных
 *
 */
class MySQLConfiguration{
	/**
	 * Адрес сервера, к которому будем подключаться
	 *
	 * @var string
	 */
	private $server;
	/**
	 * Название базы данных, с которой будем работать
	 *
	 * @var string
	 */
	private $database;
	/**
	 * Логин пользователя, под которым осуществляется вход
	 *
	 * @var string
	 */
	private $user;
	/**
	 * Пароль пользователя, под которым осуществляется вход
	 *
	 * @var string
	 */
	private $password;
	/**
	 * Кодировка, в которой будем общаться с сервером
	 *
	 * @var string
	 */
	private $encoding = 'utf8';
	
	/**
	 * Конструктор
	 *
	 * @param string $server
	 * @param string $database
	 * @param string $user
	 * @param string $password
	 */
	public function __construct( $server, $database, $user, $password ){
		// Устанавливаем параметры во внутренние переменные класса
		// Сервер
		$this->server = $server;
		// Имя базы данных
		$this->database = $database;
		// Логин пользователя
		$this->user = $user;
		// Пароль пользователя
		$this->password = $password;
	}
	
	/**
	 * Устанавливает кодировку, в которой
	 * потом будем общаться с сервером баз данных
	 *
	 * @param string $value
	 */
	public function setEncoding( $value ){ $this->encoding = $value; }
	
	public function getServer(){ return $this->server; }
	public function getDatabase(){ return $this->database; }
	public function getUser(){ return $this->user; }
	public function getPassword(){ return $this->password; }
	public function getEncoding(){ return $this->encoding; }
}

class MySQLException extends ASException {
	
	private $MYSQL_message;
	private $MYSQL_error_code;
	private $MYSQL_SQL;
	private $admin_info;
	
	private $MYSQL_error = '';
	
	public function __construct( $message, $MYSQL_message, $MYSQL_error_code, $MYSQL_SQL ){
		global $user;
		$this->MYSQL_message = $MYSQL_message;
		$this->MYSQL_error_code = $MYSQL_error_code;
		$this->MYSQL_SQL = $MYSQL_SQL;
		$this->MYSQL_error = mysql_error();
		if (!is_object($user)||!$user->isAdmin())
		{
			$MYSQL_SQL = $message = '';
		}
		else
		{
			$this->admin_info = true;
		}
		parent::__construct( "Ошибка работы с базой данных!", $message, $MYSQL_SQL );
	}
	
	public function halt()
	{
		//if (!headers_sent())header ('Content-Type: text/html; charset=UTF-8');
		//throw new self('','','','');
		if ($this->admin_info)
		{
			echo $this->getPrettyTrace();
		}
		else
		{
			
		}
		die;
	}
	
	public function inline ()
	{
		$r = "<b class='error_inline'>".i18n::getFull('cab_u_errors','error_general')." ".i18n::getFull('cab_u_errors','error_el_navail')."</b>";
		if ($this->admin_info)
		{
			$r .= $this->getPrettyTrace();
		}
		return $r;
	}
	
	private function getPrettyTrace()
	{
		$r = '';
		$r .= "<h3>SQL:</h3><div style='border:2px solid red;padding:10px;'>";
		$r .= "<b>".$this->MYSQL_SQL."</b><br><br>";
		$r .= $this->MYSQL_error." (".$this->MYSQL_error_code.")";//mysql_error();
		$r .= "</div><h3>Trace:</h3>";
		$r .= "<div style='background-color:#fff0f0;border:2px dashed red;padding:10px;'>";//.str_replace("\n",'<br><br>',$this->getTraceAsString());
		$r .= "<ol style='margin-left:13px;'>";
		$trace = $this->getTrace();
		//$t = array();
		foreach ($trace as $line)
		{
			$r .= "<li>{$line['file']} ({$line['line']}):<br>{$line['class']}{$line['type']}{$line['function']}(";
			foreach ($line['args'] as $k=>$a)
			{
				$r .= ($k?'':'<br>')."&nbsp;&nbsp;&nbsp;".(is_string($a)?"\"$a\"":(is_int($a)?(int)$a:(is_float($a)?(double)$a:(is_object($a)?'Object':$a)))).($k?' ,':'')."<br>";
			}
			$r .= ")<br></li>";
		}
		$r .= "</ol>";
		$r .= "</div>";
		return $r;
	}
}

class ASException extends exception
{
	public function __construct($sysmessage,$message,$sql)
	{
		parent::__construct($sysmessage."<br>".$message,0);
	}
}
?>