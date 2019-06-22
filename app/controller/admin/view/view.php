<?php
use App\Core\View as MainView;

class adminView extends MainView
{
    public function __construct()
    {
        if(CustomBackTrace) echo "adminView/adminView()</br>";
    }
}
?>