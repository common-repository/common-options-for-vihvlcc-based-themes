<?php

namespace vihv;
/**
 * represent basic content element
 * for Wordpress it will be post (or page, or custom post type)
 * for Drupal - node
 * for Joomla - article
 */
interface ICmsPost {
	/**
	 * if $node is missing we will create current page object
	 */
	function __construct($node = null);
	/**
	 * @return node type (article or whatever, useful for custom post types, node types)
	 */
	function getType();
	function getPermalink();
	function getTitle();
	
	/**
	 * @return html contend of the page/post
	 */
	function getHtmlContent();
	
	/**
	 * @return html code for annotation of current post (content befor \<\!--more--\> tag for example)
	 */
	function getHtmlExcerpt();
	
	/**
	 * @return array with keys url,width,height,alt,title
	 */
	function getThumbnail();
}


