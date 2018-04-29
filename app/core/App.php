<?php

use App\Core\Error;

// register_shutdown_function('ErrorHandler');
// function ErrorHandler()
// {
//     Error::addPhpError(error_get_last());
// }

class App
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
			exit(255);
		}

		$this -> app = $url[0];
		unset($url[0]);

		if(!file_exists(self::getAppFile($this -> app)))
		{
			Error::pageNotFound($this -> app, "file must be in ". self::getAppFile($this -> app));
		}
		
		require_once self::getAppFile($this -> app);
		$appName = $this -> app . "App";
		$this -> app = new $appName();

		if(method_exists($this -> app, $this -> init))
		{
			$app = $this -> app;
			$func = $this -> init;
			$app -> $func();
			$app = $func = null;
			unset($app, $func);
			//$this -> app -> $this -> $init();
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
        return AppDir.$fileName.D.'App.php';
    }
}