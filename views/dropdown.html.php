<?php defined("SYSPATH") or die("No direct script access.") ?>
<? if (!$menu->is_empty()): // Don't show the menu if it has no choices ?>
<? if ($menu->is_root): ?>

<ul<?= $menu->css_id ? " id='$menu->css_id'" : "" ?><?= $menu->css_class ? " class='$menu->css_class'" : "" ?>>
  <? foreach ($menu->elements as $element): ?>
  <?= $element->render() ?>
  <? endforeach ?>
</ul>

<? else: ?>

<li>
  <a href="#" data-dropdown="dd-<?= $menu->css_id ?>" class="small button dropdown secondary radius">
    <?= $menu->label->for_html() ?>
  </a>
  <ul id="dd-<?= $menu->css_id ?>" class="f-dropdown" data-dropdown-content>
    <? foreach ($menu->elements as $element): ?>
    <?= $element->render() ?>
    <? endforeach ?>
  </ul>
</li>

<? endif ?>
<? endif ?>
