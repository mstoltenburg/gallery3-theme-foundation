<?php defined("SYSPATH") or die("No direct script access.") ?>

<div id="g-user-profile">
	<h1>
		<img src="<?= $user->avatar_url(40, $theme->url("images/avatar.jpg", true)) ?>"
			 alt="<?= html::clean_attribute($user->display_name()) ?>"
			 class="g-avatar" width="40" height="40" />
		<?= t("User profile: %name", array("name" => $user->display_name())) ?>
	</h1>
	<div>
		<a class="button radius g-right" id="g-profile-return" href="#" onclick="history.go(-1); return false;">
			<?= t("Return") ?>
		</a>
		<? if ($contactable): ?>
		<a class="button secondary radius g-dialog-link" href="<?= url::site("user_profile/contact/{$user->id}") ?>">
			<?= t("Contact") ?>
		</a>
		<? endif ?>
		<? if ($editable): ?>
		<a class="button secondary radius g-dialog-link" href="<?= url::site("form/edit/users/{$user->id}") ?>">
			<?= t("Edit") ?>
		</a>
		<a class="button secondary radius g-dialog-link" href="<?= url::site("users/form_change_password/{$user->id}") ?>">
			<?= t("Change password") ?>
		</a>
		<a class="button secondary radius g-dialog-link" href="<?= url::site("users/form_change_email/{$user->id}") ?>">
			<?= t("Change email") ?>
		</a>
		<? endif ?>
	</div>
	<? foreach ($info_parts as $i => $info): ?>
	<div class="g-block">
		<h2><?= html::purify($info->title) ?></h2>
		<div class="g-block-content">
		<?= $info->view ?>
		</div>
	</div>
	<? endforeach ?>
</div>
