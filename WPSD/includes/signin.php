<?php include('header.php'); ?>

<header>
	<h1 class="logo signin">WordPress Status Dashboard</h1>
</header>

<div class="form-wrapper signin">
	<div class="form">
		<h2>Sign In</h2>
		<form action="<?php echo $wpstatus_url; ?>" method="post" id="signIn">
			<?php // Are there any sign in errors to display?
			if (isset($signin_error) && $signin_error){
				echo '<p class="signin-error">Sorry, your username and/or password is incorrect.</p>';
			} ?>
			<input id="username" type="text" class="text blink" name="username" title="Username" value="Username" />
			<input id="password" type="password" class="text" name="password" value="password" />
			<input type="hidden" name="action" value="signin" />
			<a class="button right"><span class="signin">Sign In</span></a>
			<div class="cl"></div>
		</form>
	</div>
</div>

<?php include('footer.php'); ?>