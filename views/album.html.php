<?php defined("SYSPATH") or die("No direct script access.") ?>
<? // @todo Set hover on AlbumGrid list items for guest users ?>
<div id="g-info">
	<?= $theme->album_top() ?>
	<h1><?= html::purify($item->title) ?></h1>
	<div class="g-description"><?= nl2br(html::purify($item->description)) ?></div>
</div>

<ul id="g-album-grid" class="small-block-grid-2 large-block-grid-4">
<? if (count($children)): ?>
	<? foreach ($children as $i => $child): ?>
		<? if ($child->is_album()): ?>
			<? $item_class = "g-album"; ?>
		<? elseif ($child->is_movie()): ?>
			<? $item_class = "g-movie"; ?>
		<? else: ?>
			<? $item_class = "g-photo"; ?>
		<? endif ?>
	<li id="g-item-id-<?= $child->id ?>" class="g-item <?= $item_class ?>">
		<?= $theme->thumb_top($child) ?>
		<a href="<?= $child->url() ?>" class="th">
			<? if ($child->has_thumb()): ?>
			<?= $child->thumb_img(array("class" => "g-thumbnail")) ?>
			<? endif ?>
			<h2 class="g-caption"><span class="<?= $item_class ?>"><?= html::purify($child->title) ?></span></h2>
			<ul class="g-caption g-metadata">
				<?= $theme->thumb_info($child) ?>
			</ul>
		</a>
		<?= $theme->thumb_bottom($child) ?>
		<?= $theme->context_menu($child, "#g-item-id-{$child->id} .g-thumbnail") ?>
	</li>
	<? endforeach ?>
<? else: ?>
	<? if ($user->admin || access::can("add", $item)): ?>
	<? $addurl = url::site("uploader/index/$item->id") ?>
	<li><?= t("There aren't any photos here yet! <a %attrs>Add some</a>.",
						array("attrs" => html::mark_clean("href=\"$addurl\" class=\"g-dialog-link\""))) ?></li>
	<? else: ?>
	<li><?= t("There aren't any photos here yet!") ?></li>
	<? endif; ?>
<? endif; ?>
</ul>
<?= $theme->album_bottom() ?>

<?= $theme->paginator() ?>
