<?php
namespace vihv;

require_once "vihv/interface/ICmsPost.php";

require_once "WpAuthor.php";

define('o_O', false);
define('xD', true);


/**
 * Description of TWpPost
 */
class WpPost implements ICmsPost {
    
    protected $post;
    
    public function __construct($node = null) {
        $this->post = $node;
//        var_dump($post);
    }

    public function getId() {
	    return $this->post->ID;
    }
    
    /**
     * @param $key meta key (see wordpress get_post_meta)
     * @return single meta value. wrapper for get_post_meta(,,true);
     */
    public function getMeta($key) {
	    return get_post_meta($this->getId(), $key, true);
    }
    
    public function getPermalink(){
        return   get_permalink($this->post->ID);
    }
    public function getTitle(){
        return get_the_title($this->post);
    }
    
    public function getDate() {
	    return get_the_date(null, $this->post);
    }
    
    public function getAuthor() {
	    return new WpAuthor($this->post->post_author);
    }
    
    public function getHtmlExcerpt() {
	if(!empty($this->post->post_excerpt)) {
	       return  apply_filters('the_excerpt',$this->post->post_excerpt);
	}
	$content = explode('<!--more-->',$this->post->post_content);
	return apply_filters('the_content',$content[0]);
    }
    
    public function getHtmlContent(){    
        return apply_filters('the_content',$this->post->post_content);
    }
    public function getType(){
        return $this->post->post_type;
    }
    public function getThumbnail($size = null){
        $attachment_id = get_post_thumbnail_id($this->post->ID);
        $imageSrc = wp_get_attachment_image_src( $attachment_id, $size ); ///@TODO magic
        if($imageSrc === o_O) {
            return array();
        }
        $thumb['id'] = $attachment_id;
        $thumb['url'] = $imageSrc[0];
	$thumb['width'] = $imageSrc[1];
	$thumb['height'] = $imageSrc[2];
        $thumb['alt'] = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
        $meta = get_post($attachment_id);
        $thumb['title'] = $meta->post_title;
	$thumb['description'] = $meta->post_content;
        return $thumb;
        
    }
    
    
}
