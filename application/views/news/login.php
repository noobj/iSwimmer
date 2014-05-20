<?php 
	echo validation_errors();
	echo form_open('news/login');
	
?>
<h1>---Login---</h1>
account:
<input type="input" name="account" /><br />
password:
<input type="password" name="password" /><br />

<input type="submit" name="submit" value="Confirm" />

</form>

