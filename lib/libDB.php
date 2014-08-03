<?php

Class libDB 
{
	const LOCALHOST_MODE = 1;
	const PRODUCT_MODE = 2;

	public static function getInstance()
	{
		static $oDB = null;

		if ($oDB === null) {
			if (self::getMode() === self::LOCALHOST_MODE) {
			  $oDB = new PDO('pgsql:host=localhost
			  ;dbname=bhbaek', 'bhbaek', 'bhbaek0215()' ); 
			} else {  
			  $oDB = new PDO('pgsql:host=ec2-107-22-163-140.compute-1.amazonaws.com
			  ;dbname=d5vv35pml3jn0', 'iqmdjhbfmwyghb', 'fzflA6soqDp0KNPowwztJ_FxOr' ); 
			}
		}

		return $oDB;
	}

	private static function getMode()
	{
		if ($_SERVER['HTTP_HOST'] === 'localhost') {
			return self::LOCALHOST_MODE;			
		} else {
			return self::PRODUCT_MODE;
		}
	}
	
	/**
	 * prevent new operation
	 */
	private function __construct()
	{
		// singleton pattern. use getInstance method! 
	}

	private function __clone()
	{
		// singleton pattern. use getInstance method!
	}

	private function __wakeup()
	{
		// singleton pattern. use getInstance method!
	}
}



?>