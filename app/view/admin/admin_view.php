<?php
class admin_view extends Controller
{
	public function __construct()
	{
		$this -> CSS(array("userglobal","admin"));
		/*print_c(__FUNCTION__,true);
		echo "<form method='post' id='addOffice'>";*/
	}

	public function AddNewUserForm($offices = [])
	{
		global $formName, $formID;
		$formID = 1;
		$formName = "NewUser";
		$html = "<form method='post' id='$formName'>";
		$html .= "<input type='text' name='fullname' placeholder='Teljes név'/>
		<input type='text' name='username' placeholder='Felhasználónév'/>
		<input type='text' name='password' placeholder='Jelszó'/>
		<div class='combo'><label>Iroda</label>
        <select name='office'>";
        foreach($offices as $office)
        {
			$html .= "<option value=" . $office['id'] . ">" . $office['neve'] . "</option>";
        }
		$html .= "
		</select></div>
		<div class='combo'><label>Beosztás</label>
		<select name='beosztas'>
		<option value=1>Felhasználó</optrion>
		<option value=2>Főnök</optrion>
		<option value=3>Admin</optrion>
		</select></div>
		<input type='button' value='Hozzáad' class='smt-btn' name='send'>";
		echo $html;
	}

	public function AddNewOfficeForm()
	{
		global $formName, $formID;
		$formID = 2;
		$formName = "NewOffice";
		$html = "<form method='post' id='$formName'>";
		$html .= '<input type="text" name="name" placeholder="Iroda neve"/>
		<input type="text" name="address" placeholder="Iroda címe"/>
		'.$this->CheckBoxTemplate("cteszt").'
		<input type="button" value="Hozzáad" name="send"/>';
		echo $html;
	}

	public function RemoveUserForm()
	{
		// need session preload names and usernames
		global $formName, $formID;
		$formID = 3;
		$formName = "RemoveUser";
		$html = "<form method='post' id='$formName'>";
		$html = '
		<input type="textfield" name="username" placeholder="Felhasználónév"/>
		<input type="textfield" name="name" placeholder="Teljes név"/>
		<input type="button" value="Töröl" name="send"/>';
		echo $html;

	}

	protected function CheckBoxTemplate($name)
	{
		$str = "
			<label>Use default configuration<input type='checkbox' name='".$name."' id='".$name."id' class='defconfig'/>
			<label class='checkbox_custom' for='".$name."id'>
				<div class='checkboxhidder'></div>
				<div class='pipesort'></div>
				<div class='pipelong'></div>
			</label></label>
			";
		return $str;
	}

	public function __destruct()
	{
        echo '</form>';
        $this -> view('logoutbutton');
		$this -> JS("admin");
	}
}
?>