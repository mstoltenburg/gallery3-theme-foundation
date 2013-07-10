<?php defined("SYSPATH") or die("No direct script access.") ?>
<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"  <?= $theme->html_attributes() ?> lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"  <?= $theme->html_attributes() ?> lang="en" > <!--<![endif]-->
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width" />
		<? $theme->start_combining("script,css") ?>
		<title>
			<? if ($page_title): ?>
				<?= $page_title ?>
			<? else: ?>
				<? if ($theme->item()): ?>
					<?= html::purify($theme->item()->title) ?>
				<? elseif ($theme->tag()): ?>
					<?= t("Photos tagged with %tag_title", array("tag_title" => $theme->tag()->name)) ?>
				<? else: /* Not an item, not a tag, no page_title specified.  Help! */ ?>
					<?= html::purify(item::root()->title) ?>
				<? endif ?>
			<? endif ?>
		</title>
		<link rel="shortcut icon"
					href="<?= url::file(module::get_var("gallery", "favicon_url")) ?>"
					type="image/x-icon" />
		<link rel="apple-touch-icon-precomposed"
					href="<?= url::file(module::get_var("gallery", "apple_touch_icon_url")) ?>" />
		<? if ($theme->page_type == "collection"): ?>
		<? if (($thumb_proportion = $theme->thumb_proportion($theme->item())) != 1): ?>
				<? $new_width = round($thumb_proportion * 213) ?>
				<? $new_height = round($thumb_proportion * 240) ?>
				<style type="text/css">
				.g-view #g-content #g-album-grid .g-item {
					width: <?= $new_width ?>px;
					height: <?= $new_height ?>px;
					/* <?= $thumb_proportion ?> */
				}
				</style>
			<? endif ?>
		<? endif ?>

		<?= $theme->script("vendor/custom.modernizr.js") ?>
		<?= $theme->script("json2-min.js") ?>
		<?= $theme->script("jquery.js") ?>
		<?= $theme->script("jquery.form.js") ?>
		<?= $theme->script("jquery-ui.js") ?>
		<?= $theme->script("gallery.common.js") ?>
		<? /* MSG_CANCEL is required by gallery.dialog.js */ ?>
		<script type="text/javascript">
		var MSG_CANCEL = <?= t('Cancel')->for_js() ?>;
		</script>
		<?= $theme->script("gallery.ajax.js") ?>
		<?= $theme->script("gallery.dialog.js") ?>
		<?= $theme->script("superfish/js/superfish.js") ?>
		<?= $theme->script("jquery.localscroll.js") ?>

		<? /* These are page specific but they get combined */ ?>
		<? if ($theme->page_subtype == "photo"): ?>
		<?= $theme->script("jquery.scrollTo.js") ?>
		<?= $theme->script("gallery.show_full_size.js") ?>
		<? elseif ($theme->page_subtype == "movie"): ?>
		<?= $theme->script("flowplayer.js") ?>
		<? endif ?>

		<?= $theme->head() ?>

		<? /* Theme specific CSS/JS goes last so that it can override module CSS/JS */ ?>
		<?= $theme->script("ui.init.js") ?>
		<?= $theme->css("superfish/css/superfish.css") ?>
		<?= $theme->css("screen.css") ?>
		<? if (locales::is_rtl()): ?>
		<?= $theme->css("screen-rtl.css") ?>
		<? endif; ?>
		<!--[if lte IE 8]>
		<link rel="stylesheet" type="text/css" href="<?= $theme->url("css/fix-ie.css") ?>"
					media="screen,print,projection" />
		<![endif]-->

		<!-- LOOKING FOR YOUR CSS? It's all been combined into the link below -->
		<?= $theme->get_combined("css") ?>

		<!-- LOOKING FOR YOUR JAVASCRIPT? It's all been combined into the link below -->
		<?= $theme->get_combined("script") ?>
	</head>

	<body <?= $theme->body_attributes() ?>>
		<?= $theme->page_top() ?>
		<div class="g-view">
			<?= $theme->site_status() ?>
			<div id="g-header" class="row">
				<div id="g-banner">
					<? if ($header_text = module::get_var("gallery", "header_text")): ?>
					<?= $header_text ?>
					<? else: ?>
					<a id="g-logo" class="g-left" href="<?= item::root()->url() ?>" title="<?= t("go back to the Gallery home")->for_html_attr() ?>">
						<img width="107" height="48" alt="<?= t("Gallery logo: Your photos on your web site")->for_html_attr() ?>" src="<?= url::file("lib/images/logo.png") ?>" />
					</a>
					<? endif ?>
					<?= $theme->user_menu() ?>
					<?= $theme->header_top() ?>

					<!-- hide the menu until after the page has loaded, to minimize menu flicker -->
					<div id="g-site-menu" style="visibility: hidden">
						<?= $theme->site_menu($theme->item() ? "#g-item-id-{$theme->item()->id}" : "") ?>
					</div>
					<script type="text/javascript"> $(document).ready(function() { $("#g-site-menu").css("visibility", "visible"); }) </script>

					<?= $theme->header_bottom() ?>
				</div>

				<? if (!empty($breadcrumbs)): ?>
				<ul class="g-breadcrumbs">
					<? foreach ($breadcrumbs as $breadcrumb): ?>
					 	<?= $breadcrumb->last ? '<li class="current">' : "<li>" ?>
						<? if (!$breadcrumb->last): ?> <a href="<?= $breadcrumb->url ?>"><? endif ?>
						<?= html::clean(text::limit_chars($breadcrumb->title, module::get_var("gallery", "visible_title_length"))) ?>
						<? if (!$breadcrumb->last): ?></a><? endif ?>
					 </li>
					<? endforeach ?>
				</ul>
				<? endif ?>
			</div>
			<div id="bd" class="row">
				<div class="large-9 columns">
					<div id="g-content">
						<?= $theme->messages() ?>
						<?= $content ?>
					</div>
				</div>
				<div id="g-sidebar" class="large-3 columns">
					<? if (!in_array($theme->page_subtype, array("login", "error"))): ?>
					<?= new View("sidebar.html") ?>
					<? endif ?>
				</div>
			</div>

			<footer id="g-footer" class="row">
				 <div class="large-12 columns">
					<hr>
					<?= $theme->footer() ?>
					<div class="row">
						<div class="large-6 columns">
							<? if ($footer_text = module::get_var("gallery", "footer_text")): ?>
							<p><?= $footer_text ?></p>
							<? endif ?>
						</div>
						<div class="large-6 columns">
							<? if (module::get_var("gallery", "show_credits")): ?>
							<ul id="g-credits" class="right">
								<?= $theme->credits() ?>
							</ul>
							<? endif ?>
						</div>
					</div>
				</div>
			</footer>
		</div>
		<?= $theme->page_bottom() ?>
	</body>
</html>
