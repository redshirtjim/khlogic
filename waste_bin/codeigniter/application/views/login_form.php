<div id="login_form">
	<p>Login</p>
	<?php
	echo form_open('login/validate_credentials');
	echo form_input('email', 'E-mail');
	echo form_password('passw', 'Password');
	echo form_submit('submit', 'Login');
	echo anchor('login/forgot_pass', 'Forgot Password');
	?>
</div>