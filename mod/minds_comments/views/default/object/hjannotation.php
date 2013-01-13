<?php

$entity = elgg_extract('entity', $vars, false);

if (!$entity) {
    return true;
}

$owner = get_entity($entity->owner_guid);

if (!elgg_instanceof($owner)) {
    return true;
}

$view = "object/hjannotation/$entity->annotation_name";
if (elgg_view_exists($view)) {
    echo elgg_view($view, $vars);
    return true;
}

$menu = elgg_view_menu('commentshead', array(
    'entity' => $entity,
    'handler' => $handler,
    'class' => 'elgg-menu-entity elgg-menu-hz',
    'sort_by' => 'priority',
    'params' => $params
	));
$metadata = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'file',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));	
$icon = elgg_view_entity_icon($owner, 'tiny', array('use_hover' => false));

$author = elgg_view('output/url', array(
    'text' => $owner->name,
	'href' => $owner->getURL(),
    'class' => 'hj-comments-item-comment-owner'
	));

$comment = $author . ': ' . minds_filter($entity->annotation_value);

/*$type = 'comment';
$pid = bykk
$bar = elgg_view('minds_comments/bar', arrar);*/

$content = <<<HTML
    <div class="clearfix">
        $metadata
        $menu
        $comment

    </div>
    $bar
HTML;

echo elgg_view_image_block($icon, $content);