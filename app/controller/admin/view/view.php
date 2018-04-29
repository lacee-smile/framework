<?php
use App\Core\View as MainView;

class adminView extends MainView
{
    public function adminView()
    {
        if(CustomBackTrace) echo "adminView/adminView()</br>";
    }
}
?>