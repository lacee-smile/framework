<?php
namespace App\Core;

abstract class Controller
{
	public $view = null;
	protected $model = null;
	protected $component = [];
	
	/*public function model($model)
	{
		require_once Model . $model . '.php';
        return new $model();
    }*/

	public function view(string $filename = "view")
	{
		if(!$filename) return;
		$class = get_called_class();
		$file = AppDir.$class.D."view".D.$filename.".php";
		if(!file_exists($file))
			$filename = $class;	// if called not exists, set the classname as default
        require_once AppDir.$class.D."view".D.$filename.".php";
        $className = $class.ucwords($filename);
        $this -> view = new $className();
	}

	public function js()
	{
        $this -> inject("javascript");
    }

	public function moduls($moduls = [])
	{
		if(!is_array($moduls))
		{
			require_once Modul . $moduls . ".php";
			return new $moduls();
		}
        else
        {
			foreach($moduls as $modul)
			{
				require_once Modul . $modul . ".php";
			}
		}
	}

	public function getQueryArray()
	{
		// ajaxhoz a teljes form adatok egy sztringként érkeznek. ezt formázza associatív tömbbé
		/*
		példa:
		jstől -> fullname=teljes%20n%C3%A9v&username=fekhaszn%C3%A1l%C3%B3n%C3%A9v&password=asd&office=1&beosztas=2
		retrun -> Array
			(
			    [fullname] => teljes%20n%C3%A9v
			    [username] => fekhaszn%C3%A1l%C3%B3n%C3%A9v
			    [password] => asd
			    [office] => 1
			    [beosztas] => 2
			)
		*/
		$TempArr = explode("&",$_POST['queryString']);
		$ret = array();
		foreach($TempArr as $param)
		{
			$tempVar = explode("=",$param);
			$ret[$tempVar[0]] = $tempVar[1];
		}
		unset($TempArr, $tempVar, $param);
		return $ret;
	}
    public function __destruct()
    {
        $this -> view -> Render();
    }
}
?>