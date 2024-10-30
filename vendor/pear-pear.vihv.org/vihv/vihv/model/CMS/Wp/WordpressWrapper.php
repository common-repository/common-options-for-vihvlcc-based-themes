<?php
namespace vihv;

require_once 'vihv/interface/ICms.php';
require_once 'vihv/model/CMS/Wp/WpPost.php';

class WordpressWrapper implements ICms {
	

	
	/**
	 * @param $size wordpress image size
	 * @return site logo url
	 */
	public function getLogo($size = 'small') {
		$logo =  get_theme_mod('vihv_header_logo');
		if(!empty($logo)) {
			return $this->getImageUrlById($logo, $size);
		}

		$logo = self::getThemeFolder();
		if(file_exists(self::getThemeFolder().'/img/logo.png')) {
			$logo = self::getThemeUrl().'/img/logo.png';
		}
		if(file_exists(self::getThemeFolder().'/img/logo@1x.jpg')) {
			$logo = self::getThemeUrl().'/img/logo@1x.jpg';
		}
		if(file_exists(self::getThemeFolder().'/logo.png')) {
			$logo = self::getThemeUrl().'/logo.png';
		}
		
		return $logo;
	}
	
	public function getFavicon() {
		$logo =  get_theme_mod('vihv_favicon',
				get_bloginfo('template_directory').'/img/favicon.png'
				);
		if(empty($logo)) {
			$logo = self::getThemeFolder();
			if(file_exists(self::getThemeFolder().'/img/favicon.png')) {
				$logo = self::getThemeUrl().'/img/favicon.png';
			}
		}
		return $logo;
	}
	
	public function getSiteUrl() {
		return get_bloginfo('url');
	}
	
	public function getSiteSlogan() {
		return get_bloginfo('description');
	}
	public function getSiteTitle() {
		return get_bloginfo('name');
	}
	public function getThemeUrl() {
		return get_bloginfo('template_directory');
	}
	
	public function getParentThemeUrl() {
		return get_stylesheet_directory_uri();
	}
	
	public function getThemeFolder() {
		return get_theme_root()."/".get_stylesheet();
	}
        public function getHtmlHead() {
                ob_start();
		wp_head();
                return ob_get_clean();
        }
        public function isFrontPage(){
               return is_front_page();
        }
        public function getPosts(){
            global $wp_query;
            $res = array();
            while($wp_query->have_posts()) {
                     $wp_query->the_post();
                     $res[] = new WpPost($wp_query->post);
            }
            return $res;
        }
        public function getPost(){
            global $post;
            return new WpPost($post);
        }
        public function getPageTitle(){
            ob_start();
            the_title();
            return ob_get_clean();
        }

        public function addJs($url, $footer = false, $dependancy = array()) {
            wp_enqueue_script($url, $url, $dependancy);
        }
        public function isSingle(){
            return is_singular();
        }
        public function isCategory() {
            return is_category();
        }
	public function isLogged() {
		return is_user_logged_in();
	}

	public function getFooter(){
            ob_start();
	    wp_footer();
	    return ob_get_clean();
        }
        
        public function getMenuHtml($location){
            ob_start();
            wp_nav_menu(array('theme_location'=>$location));
            return ob_get_clean();
        }
	
	public function getImageUrlById($attachment_id,$size = null){
		$imageSrc = wp_get_attachment_image_src( $attachment_id, $size ); ///@TODO magic
		return reset($imageSrc);
	    }
	
	/**
	 * @return human readable menu title 
	 */
	public function getMenuTitle($location) {
		$locations = get_nav_menu_locations();
		$menu = wp_get_nav_menu_object($locations[$location]);
		return $menu->name;
	}
	
	public function getSidebarHtml($sidebar) {
		ob_start();
		dynamic_sidebar($sidebar);
		return ob_get_clean();
	}
        
        public function getPager(){
              global $wp_query;
              ob_start();
              $big = 999999999; // need an unlikely integer
              echo paginate_links( array(
                 'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                 'format' => '?paged=%#%',
                 'current' => max( 1, get_query_var('paged') ),
                 'total' => $wp_query->max_num_pages
                ) );
                return ob_get_clean();
          }
	  
	  
	public function createPost($post) {
		return new WpPost($post);
	}
	
}
