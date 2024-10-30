<?php

namespace vihv;

class WpMenu {
    private $menuSlug;
    
    public function __construct($menuSlug) {
        $this->menuSlug = $menuSlug;
    }
    
    public function getItems() {
        $result = array();
        $locations = get_nav_menu_locations();
        $menu = wp_get_nav_menu_object($locations[$this->menuSlug]);
        $list = wp_get_nav_menu_items($menu->term_id);
	@_wp_menu_item_classes_by_context($list);
       
        if(!is_array($list)) {
                $list = array();
        } 
        foreach($list as $item) {
//		var_dump($item);
                $postData['id'] = $item->ID;
                $postData['title'] = htmlspecialchars($item->title,ENT_QUOTES);
		if(class_exists('TVihvMenu')) {
//                $postData['thumbnail'] = get_post_meta($item->ID, '_vihv_menu_icon', true);
//                if(strpos($postData['thumbnail'],'http://') === false) {
//			$postData['thumbnail'] = site_url()."/".$postData['thumbnail'];
//		}
			$postData['thumbnail'] = \TVihvMenu::getIconSrc(get_post_meta($item->ID, '_vihv_menu_icon', true));
		}
                $postData['content'] = $item->description;
                $postData['permalink'] = $item->url;
                $postData['parent'] = $item->menu_item_parent;
		$postData['type'] = $item->object;
		
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$class_names = apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item);
		
		$postData['classes'] = $class_names;
		$postData['classesString'] = implode(" ", $class_names);
                $result[] = $postData;
        }
	$result['title'] = $menu->name;
        return $result;
    }
    
}

