<?php
use App\Core\Error;
// register_shutdown_function('ErrorHandler');
// function ErrorHandler()
// {
//     Error::addPhpError(error_get_last());
// }

class App
{
	public $controller = "home";
	protected $method = "index";
    protected $params = [];

	public function __construct()
	{
        $url = self::parseUrl();
		if(file_exists(self::getControlFile($url[0])))
		{
			$this -> controller = $url[0];
			unset($url[0]);
        }
		require_once self::getControlFile($this -> controller);
        $this -> controller = new $this -> controller;
		if(isset($url[1]))
		{
			if(method_exists($this -> controller, $url[1]))
			{
				$this -> method = $url[1];
				unset($url[1]);
			}
        }
		$this -> params = $url ? array_values($url) : [];
		call_user_func_array([$this -> controller, $this -> method], $this -> params);
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
    
    private static function getControlFile($fileName)
    {
        return Control.$fileName.D.$fileName.'.php'; // vagy ez vagy az app.php a mappán belül
    }
}
?>