<?php defined("SYSPATH") or die("No direct script access.") ?>
<? if (!$menu->is_empty()): // Don't show the menu if it has no choices ?>
<? if ($menu->is_root): ?>

<ul <?= $menu->css_id ? "id='$menu->css_id'" : "" ?> class="<?= $menu->css_class ?>">
	<? foreach ($menu->elements as $element): ?>
	<?= $element->render() ?>
	<? endforeach ?>
</ul>

<? else: ?>

<li class="has-dropdown">
	<a href="#">
		<?= $menu->label->for_html() ?>
	</a>
	<ul class="dropdown">
		<? foreach ($menu->elements as $element): ?>
		<?= $element->render() ?>
		<? endforeach ?>
	</ul>
</li>

<? endif ?>
<? endif ?>
