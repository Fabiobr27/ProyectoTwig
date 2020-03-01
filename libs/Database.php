<?php

	
	// curso 2019/20

	require_once "Data.php" ;

	class Database 
	{
		private $pdo ;
		private $res ;

		/**
		 * realiza la conexión con el motor de bases de datos
		 */
		public function __construct()
		{
			global $data ;
			$this->pdo = new PDO("mysql:host=".$data["host"].";dbname=".$data["dbno"].";charset=utf8",$data["user"],$data["pass"])
						 or die("Error de conexión con la base de datos.") ;
		}

		/**
		 * cierra la conexión con la base de datos antes de que
		 * se destruya el objeto Database.
		 */
		public function __destruct()
		{
			$this->pdo = null ;
		}

		/**
		 * realiza una consulta en la base de datos
		 */
		public function query($sql)
		{
			$this->res = $this->pdo->query($sql) ;
		}

		/**
		 * devuelve un registro en formato de objeto
		 */
		public function getObject($cls = "StdClass")
		{
			return $this->res->fetchObject($cls) ;
		}

		/**
		 * devuelve el último ID
		 */
		public function lastId()
		{
			return $this->pdo->lastInsertId() ;
		}

	}