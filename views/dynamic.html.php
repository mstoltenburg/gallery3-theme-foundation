<?php defined("SYSPATH") or die("No direct script access.") ?>
<div id="g-album-header">
	<div id="g-album-header-buttons">
		<?= $theme->dynamic_top() ?>
	</div>
	<h1><?= html::purify($title) ?></h1>
</div>

<ul id="g-album-grid" class="small-block-grid-2 large-block-grid-4">
	<? foreach ($children as $i => $child): ?>
	<li class="g-item <?= $child->is_album() ? "g-album" : "" ?>">
		<?= $theme->thumb_top($child) ?>
		<a href="<?= $child->url() ?>" class="th">
			<img id="g-photo-id-<?= $child->id ?>" class="g-thumbnail"
					 alt="photo" src="<?= $child->thumb_url() ?>"
					 width="<?= $child->thumb_width ?>"
					 height="<?= $child->thumb_height ?>" />
			<h2 class="g-caption"><span><?= html::purify($child->title) ?></span></h2>
			<ul class="g-caption g-metadata">
				<?= $theme->thumb_info($child) ?>
			</ul>
		</a>
		<?= $theme->thumb_bottom($child) ?>
	</li>
	<? endforeach ?>
</ul>
<?= $theme->dynamic_bottom() ?>

<?= $theme->paginator() ?>
