<?php # - login_page.inc.php
// This page prints any errors associated with logging in
// and it creates the entire login page, including the form.

// Include the header:
//$page_title = 'Login';
//include ('include/header.html');

// Print any error messages, if they exist:
if (isset($errors) && !empty($errors)) {
	echo '<p class="error">';
	foreach ($errors as $msg) {
		echo " * $msg<br />\n";
	}
}

// Display the form:
?>

<form class="form-signin" role="form" action="index.php" method="post">
	<h2 class="form-signin-heading">Kingdom Hall Logic</h2>
	<input type="email" class="form-control" placeholder="Email address" name="email" value="<?php if(isset($_POST['email'])) {print $_POST['email'];}?>" required="" autofocus="">
	<input type="password" class="form-control" placeholder="Password" name="password" required="">
	<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
	<br>
	<a href=forgot_password.php?e=<?php if(isset($_POST['email'])) {print $_POST['email'];}?>>Forgot Password</a>
</form>

<!--	<label class="checkbox">
	<input type="checkbox" value="remember-me"> Remember me
	</label>


<!--
<div id="login" class="">
<form action="index.php" method="post">
	<table>
	<tr>
	<td><input type="text" placeholder="E-mail address" name="email" size="20" value="<?php if(isset($_POST['email'])) {print $_POST['email'];}?>" /></td>
	<td><input type="password" placeholder="Password" name="password" size="12" /></td>
	<td><input type="submit" name="submit" value=" Login " /></td></tr>
	<tr>
	<td></td>
	<td valign="top" align="center"><a href=forgot_password.php?e=<?php if(isset($_POST['email'])) {print $_POST['email'];}?>>Forgot Password</a></td>
	</tr>
	</table>
</form>
</div>
-->

<!--
<p><a href="register.php"><br>Register</a></p>
Eliminated the register ability because all application users should be created by an administrator
-->