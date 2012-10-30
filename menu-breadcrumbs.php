<?php
/*
Plugin Name: Menu Breadcrumbs
Description: Creates the breadcrumbs path from the menu structure, and not from the page hierarchy. Warnung: If a page is included into a menu twice, only one (arbitrary) breadcrumb path is created
*/

function menu_breadcrumbs($menuLocation, $opt = array()) {
    $opt = array_merge(array(
        'echo' => false,
    ), $opt);

    $str = '';

    $menuLocationToId = get_nav_menu_locations();
    if (isset($menuLocationToId[$menuLocation])) {
        $menuId = $menuLocationToId[$menuLocation];
    }
    else {
        $menuId = false;
    }

    if ($menuId) {
        if (is_home()) {
            $pageId = get_option('page_for_posts');
        }
        else {
            $pageId = get_the_ID();
        }
        $currentItemId = false;
        $items = wp_get_nav_menu_items($menuId);
        $itemArray = array();
        foreach($items as $item) {
            if ($item->object_id == $pageId) {
                $currentItemId = $item->ID;
            }
            $itemArray[$item->ID] = array('title' => $item->title, 'url' => $item->url, 'parent' => $item->menu_item_parent);
        }

        if ($currentItemId) {
            $breadcrumbItems = array();
            $breadcrumbItems[] = $itemArray[$currentItemId];

            while ($breadcrumbItems[0]['parent'] > 0) {
                $parentId = $breadcrumbItems[0]['parent'];
                array_unshift($breadcrumbItems, $itemArray[$parentId]);
            }
            $countBCItems = count($breadcrumbItems);

            $str .= '<nav class="breadcrumbs">';
            foreach ($breadcrumbItems as $i => $bci) {
                if ($i < ($countBCItems - 1)) {
                    $str .= '<span><a href="' . $bci['url'] . '">' . $bci['title'] . '</a></span>';
                }
                else {
                    $str .= '<span class="last">' . $bci['title'] . '</span>';
                }
            }
            $str .= '</nav>';
        }

    }

    if ($opt['echo']) {
        echo $str;
    }
    else {
        return $str;
    }
}
