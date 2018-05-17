<?php

use App\Smile\Frame;

class Bootstrap extends Frame
{
	public $app = "home";
	protected $method = "index";
	protected $params = [];
	private $init = 'initialize';

	public function __construct()
	{
		$url = self::parseUrl();
		
		if(!$url[0])
		{
			echo "index page";
		}

		$this -> app = $url[0];
		unset($url[0]);

		// global $applist;
		// if(!in_array($this -> app, $applist)
		// 				or
		// !self::getAppFile($this -> app))
		// {
		// 	$this -> pageNotFound();
		// }
		
		require_once self::getAppFile($this -> app);
		
		$this -> autoloader($this -> app);

		$this -> app = new App();

		if(method_exists($this -> app, $this -> init))
		{
			$app = $this -> app;
			$func = $this -> init;
			$app -> $func();
			$app = $func = null;
			unset($app, $func);
		}

		if(isset($url[1]))
		{
			if(method_exists($this -> app, $url[1]))
			{
				$this -> method = $url[1];
				unset($url[1]);
			}
        }
		$this -> params = $url ? array_values($url) : [];
		call_user_func_array([$this -> app, $this -> method], $this -> params);
		if(DEBUG)
		{
			print_c('DEBUG BACKTRACE:', true);
			print_c(debug_backtrace());
		}
	}
	protected static function parseUrl()
	{
		if(isset($_GET["url"]))
		{
			return $url = explode("/",filter_var(rtrim($_GET["url"],"/"), FILTER_SANITIZE_URL));
		}
    }
    
    private static function getAppFile($fileName)
    {
		$file = AppDir.$fileName.D.'App.php';
        return file_exists($file) ? $file : false;
    }
}