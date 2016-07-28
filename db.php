<?php 
	require dirname(__FILE__)."/dbconfig.php";//引入配置文件

	class db{
		public $conn=null;

		public function __construct($config){//构造方法 实例化类时自动调用 
				$this->conn=mysql_connect($config['host'],$config['username'],$config['password']) or die(mysql_error());//连接数据库
				mysql_select_db($config['database'],$this->conn) or die(mysql_error());//选择数据库
				mysql_query("set names ".$config['charset']) or die(mysql_error());//设定mysql编码
		}
		
		/**
		**根据传入sql语句 查询mysql结果集
		**/
		public function getResult($sql){
			$resource=mysql_query($sql,$this->conn) or die(mysql_error());//查询sql语句
			$res=array();
			while(($row=mysql_fetch_assoc($resource))!=false){
				$res[]=$row;
			}
			return $res;
		}
		/**
		** 根据传入年级数 查询每个年级的学生数据
		**/
		public function getDataByGrade($grade){
			$sql="select username,score,class from user where grade=".$grade." order by score desc";
			$res=self::getResult($sql);
			return $res;
		}
		/*
		 ** input 数据表名， 进程名， 时间， 比率
		 */
		public function insertData($sheet, $process, $time, $rate){
		    // 错误写法 INSERT INTO '$sheet'
		    
		    $sql = "INSERT INTO $sheet ".
		  		    "(process, time, rate) ".
		  		    "VALUES ".
		  		    "('$process', '$time', '$rate')";
		    //TODO 
		    
		    $result = mysql_query($sql, $this->conn);
		    if (! $result){
		        die("error!!:".mysql_error());
		    }
		    
		}
		/*
		 * 新建一个数据表
		 */
		public function newTable($tableName){
		    $sql = "CREATE TABLE $tableName( ".
		  		    "id INT NOT NULL AUTO_INCREMENT, ".
		  		    "process VARCHAR(255) NOT NULL, ".
		  		    "time TIME NOT NULL, ".
		  		    "rate FLOAT NOT NULL, ".
		  		    "software VARCHAR(255) NOT NULL, ".
		  		    "PRIMARY KEY (id)); ";
		    $result = mysql_query($sql, $this->conn);
		    
		    if (! $result)
		    {
		        die('数据表创建失败:'.mysql_error());
		    }
		    echo "数据表".$tableName."创建成功";
		}

		/**
		** 查询所有的年级
		**/
		public function getAllGrade(){
			$sql="select distinct(grade) from user  order by grade asc";
			$res=$this->getResult($sql);
			return $res;
		}

		/**
		**根据年级数查询所有的班级
		**/
		public function getClassByGrade($grade){
			$sql="select distinct(class) from user where grade=".$grade." order by class asc";
			$res=$this->getResult($sql);
			return $res;
		}

		/**
		**根据年级数班级数查询学生信息
		**/
		public function getDataByClassGrade($class,$grade){
			$sql="select username,score from user where class=".$class." and grade=".$grade." order by score desc";
			$res=$this->getResult($sql);
			return $res;
		}
	}
?>