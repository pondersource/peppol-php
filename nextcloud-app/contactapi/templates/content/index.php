<?php
 echo '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">
	<label>Name:</label>
	<input type="text" value="'.$_POST["txtFamily"].'" name="txtName">
	<label>Family:</label>
	<input type="text" value="'.$_POST["txtFamily"].'" name="txtFamily">
	<button type="submit" name="submit">Ok</button>

</form>';

// p($_['txtName']);*/

