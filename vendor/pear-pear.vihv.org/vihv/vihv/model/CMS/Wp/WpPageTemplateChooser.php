<?php
namespace vihv;
/**
 * we will make it singlethon
 * template name and labels shoud be registred 
 * 
 */
class WpPageTemplateChooser {
    
    const POST_TYPE = 'page';
    const DEFAULT_TEMPLATE = 'default';
    
    static private $instance;
    private $templates;
    
    private function __construct() {
        add_action('add_meta_boxes', array($this, 'createMetabox'));    
        add_action( 'save_post', array( &$this, 'savePost' ), 1, 2);
	$this->registerTemplate(self::DEFAULT_TEMPLATE, __('Default'));
    }
    
    public function getInstance() {
	    if(empty(self::$instance)) {
		    self::$instance = new TWpPageTemplateChooser();
	    }
	    return self::$instance;
    }
    
    public function self() {
	    return self::getInstance();
    }
    
    public function registerTemplate($name, $title) {
	    $this->templates[] = array('value'=>$name, 'title'=>$title);
    }
    
    public function getTemplates() {
	    return $this->templates;
    }
    
    function createMetabox() {
        add_meta_box('page_template', "Page Template", array($this, 'paintTemplateChooser'), self::POST_TYPE, 'side', 'default');
    }
    
    function paintTemplateChooser() {
        $options = $this->getTemplates();
        global $post;
        $template = get_post_meta($post->ID, 'vihv_page_template', true);
        ?>
        <select name="vihv_page_template">
            <?php foreach($options as $option) {
                ?>
                <option value="<?php echo $option['value']; ?>"
                        <?php
                        if($option['value'] == $template) {
                            echo 'selected="yes"';
                        }
                        ?>
                        ><?php echo $option['title']; ?></option>
                <?php
            } ?>
            
        </select>
        <?php
    }
    
    function savePost($post_id, $post) {
        if ( wp_is_post_revision( $post_id ) 
			|| ($_POST['post_type'] != self::POST_TYPE)
			) {
            return;
        }
        update_post_meta($post_id, 'vihv_page_template', $_REQUEST['vihv_page_template']);
    }
    
    public function getTemplate($postId) {
        $meta = get_post_meta($postId, 'vihv_page_template', true);
        if(empty($meta)) {
            return self::DEFAULT_TEMPLATE;
        }
        return $meta;
    }
}

