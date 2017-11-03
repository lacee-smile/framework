<?php

class Controller
{
	public function model($model)
	{
		
		require_once '../app/model/' . $model . '.php';
		return new $model();
	}

	public function view($view, $data = [])
	{
		require_once '../app/view/' . $view . '.php';
	}

	public function moduls($moduls = [])
	{
		foreach($moduls as $module)
		{
			require_once "../app/moduls/" . $module . ".php";
		}
	}
}
?>