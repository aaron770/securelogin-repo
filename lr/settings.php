<?php

include 'core/init.php';
protect_page();
include 'includes/overall/header.php'; 

if (empty($_POST) === false) {
	$required_fields = array('first_name', 'email');
	foreach ($_POST as $key=>$value) {
		if (empty($value) && in_array($key, $required_fields) === true) {
			$errors[] = 'Fields marked with an asterisk are required';
			break 1;
		}
	}

	if (empty($errors) === true) {
		if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
			$errors[] = 'A valid email address is required';
		} elseif (email_exists($_POST['email']) === true && $user_data['email'] !== $_POST['email']) {
			$errors[] = 'Sorry that email \'' . $_POST['email'] . '\' is already taken.';
		}
	
	}
}
?>
<h1>Settings</h1>

<?php
if (isset($_GET['success']) === true && empty($_GET['success']) === true) {
	echo "You're detailes have been updated";
} else {
if (empty($_POST) === false && empty($errors) === true) {
   $allow_email = ($_POST['allow_email'] == 'on') ? 1: 0;$update_data = array(
   			'first_name'   => $_POST['first_name'],
   			'last_name'    => $_POST['last_name'],
   			'email'        => $_POST['email'],
            'allow_email'  => $allow_email = ($_POST['allow_email'] == 'on') ? 1 : 0
   			);
	update_user($session_user_id, $update_data);
	header('Location: settings.php?success');
	exit();

} elseif (empty($errors) === false) {
	echo output_errors($errors);
}
?>
<form action="" method="post">
   					<ul >
   						<li >
   							First name*: <br>
   							<input type="text" name="first_name" value="<?php echo trim($user_data['first_name']); ?>">
   						</li>
   						<li >
   							Last name: <br>
   							<input type="text" name="last_name" value="<?php echo trim($user_data['last_name']); ?>">
   						</li>
   						<li>
   							Email: <br>
   							<input type="text" name="email" value="<?php echo trim($user_data['email']); ?>">
   						</li>
                     <li>
                         <br>
                        <input type="checkbox" name="allow_email" <?php if ($user_data['allow_email'] == 1) {echo "checked=checked";} ?>>Would you like to receive emails from us.
                     </li>
   						<li>
   							 <br>
   							<input type="submit" value="Update">
   						</li>
                     
   					</ul>
   					</form>
<?php
}
include 'includes/overall/footer.php'; ?>