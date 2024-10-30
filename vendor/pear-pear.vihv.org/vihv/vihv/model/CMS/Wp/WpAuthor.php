<?php

namespace vihv;

class WpAuthor {
	private $id;
	
	public function __construct($id) {
		$this->id = $id;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getName() {
		return \get_the_author_meta('display_name', $this->id);
	}
	
	public function getLink() {
		return get_author_posts_url($this->id);
	}
}
