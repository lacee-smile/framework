<?php
namespace App\Core;

class Controller
{
    /*public $formName = null;
    public $formID = 0;
    public $AjaxHandler = null;*/
    protected $view = null;
	protected $model = null;
	protected $component = [];
	
	/*public function model($model)
	{
		require_once Model . $model . '.php';
        return new $model();
    }*/
    public function __construct()
    {
		if(CustomBackTrace) echo "Controller/Controller()</br>";
        echo "Controller";
        //$this -> view();
    }

    public function inject($injectable)
    {
		if(CustomBackTrace) echo "Controller/inject()</br>";
        $class = get_called_class();
        require_once Control.$class.D.$injectable.D.$injectable.".php";
        $className = $class.ucwords($injectable);
        $this -> view = new $className();
    }

	public function view()
	{
		if(CustomBackTrace) echo "Controller/view()</br>";
        $this -> inject("view");
    }

	public function moduls($moduls = [])
	{
		if(gettype($moduls) != 'array')
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

	/*public function CSS($files)
	{
		if(count($files) == 0)
		{
			ConsoleAlert('This function called with 0 parameter. Ignoring!');
		}
		elseif(gettype($files) == 'string')
		{
			include CSS . $files . ".php";
		}
		else
		foreach($files as $file)
        include CSS . $file . ".php";
	}
	public function JS($files)
	{
		echo '<script language="javascript" src="script/jQuery.js"></script>';
		if(count($files) == 0)
		{
			ConsoleAlert('This function called with 0 parameter. Ignoring!');
		}
		elseif(gettype($files) == 'string')
		{
			include JS . $files . ".php";
		}
		else
		foreach($files as $file)
		include JS . $file . ".php";
    }*/

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
		if(CustomBackTrace) echo "Controller/__destruct()</br>";
		//print_pre($this);
        $this -> view -> Render();
    }
}
?>