<?php defined("SYSPATH") or die("No direct script access.") ?>
<?

print($open);

// Not sure what to do with these, but at least show that we received them.
if ($class) {
	print "<!-- unused class in form.html.php: $class -->";
}
if ($title) {
	print $title;
}

if (!function_exists("DrawForm")) {
	function DrawForm($inputs, $level=1) {
		$prefix = str_repeat("	", $level);
		$haveGroup = false;
		// On the first level, make sure we have a group if not add the <ul> tag now
		if ($level == 1) {
			foreach ($inputs as $input) {
				$haveGroup |= $input->type == 'group';
			}
			if (!$haveGroup) {
				print "$prefix<div>\n";
			}
		}

		foreach ($inputs as $input) {
			if ($input->type == 'group') {
				print "$prefix<fieldset>\n";
				print "$prefix	<legend>{$input->label}</legend>\n";
				if ($level > 1) {
					print "$prefix	<div class=\"row\"><div class=\"row\">\n";
				} else {
					print "$prefix	<div>\n";
				}

				DrawForm($input->inputs, $level + 2);
				if ($level > 1) {
					print "$prefix	</div></div>\n";
				} else {
					print "$prefix	</div>\n";
				}

				// Since hidden fields can only have name and value attributes lets just render it now
				foreach ($input->hidden as $hidden) {
					print "$prefix	{$hidden->render()}\n";
				}
				print "$prefix</fieldset>\n";
			} else if ($input->type == 'script') {
				print $input->render();
			} else {
				if ($level > 3) {
					$rowClass = 'large-6 columns';
				} else {
					$rowClass = '';
				}
				if ($input->error_messages()) {
					print "$prefix<div class=\"$rowClass error\">\n";
				} else {
					print "$prefix<div class=\"$rowClass\">\n";
				}

				if ($input->label()) {
					print "$prefix	{$input->label()}\n";
				}
				print "$prefix	{$input->render()}\n";
				if ($input->message()) {
					print "$prefix	<p>{$input->message()}</p>\n";
				}
				if ($input->error_messages()) {
					foreach ($input->error_messages() as $error_message) {
						print "$prefix	<small class=\"g-error error\">\n";
						print "$prefix		$error_message\n";
						print "$prefix	</small>\n";
					}
				}
				print "$prefix</div>\n";
			}
		}
		if ($level == 1 && !$haveGroup) {
			print "$prefix</div>\n";
		}
	}
}

DrawForm($inputs);

print($close);
