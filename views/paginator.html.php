<?php defined("SYSPATH") or die("No direct script access.") ?>
<?
// This is a generic paginator for album, photo and movie pages.  Depending on the page type,
// there are different sets of variables available.  With this data, you can make a paginator
// that lets you say "You're viewing photo 5 of 35", or "You're viewing photos 10 - 18 of 37"
// for album views.
//
// Available variables for all page types:
//   $page_type               - "collection", "item", or "other"
//   $page_subtype            - "album", "movie", "photo", "tag", etc.
//   $previous_page_url       - the url to the previous page, if there is one
//   $next_page_url           - the url to the next page, if there is one
//   $total                   - the total number of photos in this album
//
// Available for the "collection" page types:
//   $page                    - what page number we're on
//   $max_pages               - the maximum page number
//   $page_size               - the page size
//   $first_page_url          - the url to the first page, or null if we're on the first page
//   $last_page_url           - the url to the last page, or null if we're on the last page
//   $first_visible_position  - the position number of the first visible photo on this page
//   $last_visible_position   - the position number of the last visible photo on this page
//
// Available for "item" page types:
//   $position                - the position number of this photo
//
?>

<ul class="g-paginator row">
  <li class="g-first small-6 large-4 columns">
  <? if ($page_type == "collection"): ?>
    <? if (isset($first_page_url)): ?>
      <a href="<?= $first_page_url ?>" class="button small radius secondary">&#8676; <span class="xxx"><?= t("First") ?></span></a>
    <? else: ?>
      <a class="button small radius secondary disabled">&#8676; <span class="xxx"><?= t("First") ?></span></a>
    <? endif ?>
  <? endif ?>

  <? if (isset($previous_page_url)): ?>
    <a href="<?= $previous_page_url ?>" class="button small radius secondary">&larr; <span class="xxx"><?= t("Previous") ?></span></a>
  <? else: ?>
    <a class="button small radius secondary disabled">&larr; <span class="xxx"><?= t("Previous") ?></span></a>
  <? endif ?>
  </li>

  <li class="g-info hide-for-small large-4 columns">
    <? if ($total): ?>
      <? if ($page_type == "collection"): ?>
        <?= /* @todo This message isn't easily localizable */
            t2("Photo %from_number of %count",
               "Photos %from_number - %to_number of %count",
               $total,
               array("from_number" => $first_visible_position,
                     "to_number" => $last_visible_position,
                     "count" => $total)) ?>
      <? else: ?>
        <?= t("%position of %total", array("position" => $position, "total" => $total)) ?>
      <? endif ?>
    <? else: ?>
      <?= t("No photos") ?>
    <? endif ?>
  </li>

  <li class="g-text-right small-6 large-4 columns">
  <? if (isset($next_page_url)): ?>
    <a href="<?= $next_page_url ?>" class="button small radius secondary"><span class="xxx"><?= t("Next") ?></span> &rarr;</a>
  <? else: ?>
    <a class="button small radius secondary disabled"><span class="xxx"><?= t("Next") ?></span> &rarr;</a>
  <? endif ?>

  <? if ($page_type == "collection"): ?>
    <? if (isset($last_page_url)): ?>
      <a href="<?= $last_page_url ?>" class="button small radius secondary"><span class="xxx"><?= t("Last") ?></span> &#8677;</a>
    <? else: ?>
      <a class="button small radius secondary disabled"><span class="xxx"><?= t("Last") ?></span> &#8677;</a>
    <? endif ?>
  <? endif ?>
  </li>
</ul>
