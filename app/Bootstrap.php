<?php

class Bootstrap
{
	public $app = "home";
	protected $method = "index";
	protected $params = [];
	private $init = 'initialize';

	public function __construct()
	{
		// grant module exists
		global $applist;
		$url = self::parseUrl();
		if(in_array($url[0], $applist))
		{
			$this -> app = $url[0];
		}
		
		// load module files
		//$this -> autoloader($this -> app);


		$route = Dispatcher::class;
		var_dump($route);
		die();
		//$this -> app = new App();
		new Controller();
	
		

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