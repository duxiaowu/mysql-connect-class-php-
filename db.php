<?php 
  //单例模式，构造函数必须为非PUBLIC
  class Db{
	  static private $_instance;//拥有一个保存类的实例静态成员变量$_instance
	  private $_dbConfig = array(
	  'host' => '127.0.0.7',
	  'user' =>'root',
	  'password' =>'root',
	  'database' =>'test'
	  ); 
   static private $_connectSource;
   static private $_mysqliSource;
   private function __construct(){

	}
  static public function getInstance(){
	  
    //拥有一个访问这个实例的公共静态方法
  if(!(self::$_instance instanceof self)){ //检查是否实例化，避免浪费资源
	        self::$_instance = new self();
  }
      return self::$_instance;
  }  
  public function mysqlConnect(){
  if(!self::$_connectSource){
  self::$_connectSource = mysql_connect($this->_dbConfig['host'],$this->_dbConfig['user'],$this->_dbConfig['password']);
  if(!self::$_connectSource){
	 throw new Exception("error:".mysql_error());
	   //die("error:".mysql_error());
  }
  mysql_select_db($this->_dbConfig['database'],self::$_connectSource);
  mysql_query("set names UTF8",self::$_connectSource);
  }
  return self::$_connectSource;
  }
  
    public function mysqliConnect($sql){//mysqli连接类型
	if(!self::$_connectSource){
	$mysqli = mysqli_init();//初始化mysql句柄.
    $mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 2);//设置超时时间
	$mysqli->real_connect($this->_dbConfig['host'],$this->_dbConfig['user'],$this->_dbConfig['password'], $this->_dbConfig['database']);
    $mysqli->query("set names UTF8",self::$_connectSource);
	self::$_mysqliSource = $mysqli->query($sql,self::$_connectSource);//执行sql语句
	}
    return self::$_mysqliSource;;
  }
  }


  