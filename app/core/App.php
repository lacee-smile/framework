<?php
use Smile\Loader;
use App\Core\Error;
use App\Smile\Helper;
use Smile\Object\Application;
// register_shutdown_function('ErrorHandler');
// function ErrorHandler()
// {
//     Error::addPhpError(error_get_last());
// }

spl_autoload_register( function ($className) {
    (new Loader())->searchClassByName($className);
});
class App
{
	public $controller = "admin";
	protected $method = "index";
    protected $params = [];

	public function __construct()
	{
		$url = self::parseUrl();
		$helper = new Helper();
		//$helper->teszt();
		//die();
		$application = new Application();
		if($appFile = file_exists(self::getAppFile($url[0])))
		{
			$application->setApplication($appFile);
			unset($url[0]);
        }
		require_once self::getAppFile($this -> controller);
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
    
    private static function getAppFile($fileName)
    {
        return AppDir.$fileName.D.'App.php'; // vagy ez vagy az app.php a mappán belül
    }
}
?>