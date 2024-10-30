<?php

namespace vihv;

class WpCategoryTemplateChooser {
	function __construct() {
	    add_action('edit_category_form_fields', array($this, 'paintCategoryTemplateField'));
	    add_action ( 'edited_category', array($this,'save'));
	}
	
	function save($term_id) {
		if(isset($_POST['vihv-category-template'])) {
			$template = htmlspecialchars($_POST['vihv-category-template']);
			update_option("category_template_".$term_id, $template);
		}
	}
	
	function getTemplate($term_id) {
		return get_option( "category_template_".$term_id);
	}
	/**
	 * override this to create your own list of templates
	 */
	function getPossibleTemplates() {
		return array(
			array('value'=>'default', 'title'=>'Default'),
			array('value'=>'digest', 'title'=>'Дайджест'),
			);
	}
	
	function paintCategoryTemplateField($tag) {
		$options = $this->getPossibleTemplates();
		//echo $tag->term_id;
		$template = get_option( "category_template_".$tag->term_id);
		?>
		<tr class="form-field">
			<th scope="row" valign="top"><label for="cat_template">Category Template</label></th>
			<td>
				<select name="vihv-category-template">
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
				<br />
				    <span class="description"><?php _e('Template for blog category'); ?></span>
				</td>
		</tr>
		<?php
	}
}

//new TCategoryTemplateChooser();