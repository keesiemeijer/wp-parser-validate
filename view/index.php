<?php
if ( ! isset( $content ) || ! isset( $validation ) ) {
	// Bail if directly run from the view directory.
	return;
}
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>Validate Documentation</title>
		<link rel="stylesheet" href="./view/style.css" type="text/css">
		<meta name="description" content="WordPress Documentation Validator" />
	</head>
	<body>
		<div class="content">
			<div class="content-header">
				<h1>WordPress PHP Documentation Validator</h1>
				<p>Check if your code follows the WordPress <a href="https://make.wordpress.org/core/handbook/best-practices/inline-documentation-standards/php/">PHP Documentation Standards</a>.</p>
				<p>See <a href="https://github.com/keesiemeijer/wp-parser-validate/wiki/What-is-validated">what's validated.</a></p>
				<p><strong>Note</strong>: your code is validated as a file and should have PHP tags (<code>&lt;?php ?></code>) where needed.</p>
			</div>

			<?php if ( $validation ) : ?>
				<div class="validation-errors"><?php echo $validation; ?></div>
			<?php endif; ?>

			<form method="post" action="">
				<p>
					<label for="code">Validate Code:</label>
					<textarea id="code_content" placeholder="Paste code to validate here." cols="70" rows="30" name="code_content" wrap="off"><?php echo $content ?></textarea></p>
				<p>
					<input type="submit" name="validate_code" value="Validate Documentation" >
				</p>
			</form>
			<div class="content-footer">
				<p>WordPress PHP Documentation Validator by <a href="https://github.com/keesiemeijer">keesiemeijer</a> using the <a href="https://github.com/WordPress/phpdoc-parser">WP Parser</a>.</p>
				<p><a href="https://github.com/keesiemeijer/wp-parser-validate">GitHub repository</a></p>
			</div>
		</div>
		<script type='text/javascript' src='./view/line-number.js'></script>
	</body>
</html>
