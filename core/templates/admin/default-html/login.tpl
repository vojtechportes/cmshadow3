<?php global $Path; ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="robots" content="noindex, nofollow">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php foreach ($return["Styles"] as $style) { ?>
			<link rel="stylesheet" type="text/css" href="<?php echo BASE_PATH.$style; ?>">
		<?php } ?>
	</head>
	<body class="<?php echo str_replace('/', '--', substr(strtolower($Path), 1)); ?> login">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<div class="form-login">
						<div class="header">
							<h1>{_'forms_login_heading'}</h1>
						</div>
						<?php print_slot("main", $return["Content"]); ?>
					</div>
				</div>
			</div>
		</div>
		<?php foreach ($return["Scripts"] as $script) { ?>
			<script src="<?php echo BASE_PATH.$script; ?>"></script>
		<?php } ?>
	</body>
</html>