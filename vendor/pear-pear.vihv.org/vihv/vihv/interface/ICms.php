<?php

namespace vihv;
/**
 * interface for common CMS interactions
 */
interface ICms {
	/**
	 * @return link to site logo
	 */
	function getLogo();
	
	/**
	 * @return site base url
	 */
	function getSiteUrl();
	
	/**
	 * @return url of current theme, needed for linking css, js and images
	 */
	function getThemeUrl();
	
	/**
	 * @return site title
	 */
	function getSiteTitle();
	
	/**
	 * @return site slogan (description)
	 */
	function getSiteSlogan();
	
	/**
	 * @return true if cuttent page is front page
	 */
	function isFrontPage();
	
	/**
	 * @return true if current page is single page or post
	 */
	function isSingle();
	
	/**
	 * @return true if current page should display a list of posts by category
	 */
	function isCategory();
	
	/**
	 * @return html code for default pager  
	 */
	function getPager();
	
	/**
	 * @return list of ICmsPost objects
	 */
	function getPosts();
	
	/**
	 * @return ICmsPost object for current post
	 */
	function getPost();
	
	/**
	 * @return current page title
	 */
	function getPageTitle();
	
	/**
	 * register javascript to be loaded by getHtmlHead or getFooter
	 * @param string $url - full url of javascript file
	 * @param bool $footer - if true script will be loaded in footer
	 * @param array $dependancy - list of dependant scrips that should be loaded befor this one
	 */
	function addJs($url, $footer = false, $dependancy = array());
	
	/**
	 * should be used in THeadControl
	 * @return cms specific html for \<head\> tag
	 */
	function getHtmlHead();	
	
	/**
	 * should be used in TFooterControl
	 * @return cms specipc tags that should be loaded in the bottom on the page, before \</body\>
	 */
	function getFooter();
	
	/**
	 * @return html code for theme sidebar
	 */
	function getSidebarHtml($sidebar);
	
	/**
	 * @return html code rendered by cms core for menu
	 */
	function getMenuHtml($location);
}


