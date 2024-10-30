<?php

namespace vihv;

/**
 * common stuff for wp themes
 */
class WpThemeCommon {
	
	static public function customizeRegister($wp_customize) {
		$wp_customize->add_setting('vihv_header_logo', array(
			'default' => get_bloginfo('stylesheet_directory') . '/img/logo.jpg',
			'transport' => 'refresh',
			'capability' => 'edit_theme_options',
		));
		$wp_customize->add_setting('vihv_favicon', array(
			'default' => get_bloginfo('stylesheet_directory') . '/img/favicon.png',
			'transport' => 'refresh',
			'capability' => 'edit_theme_options',
		));
		$wp_customize->add_section('vihv_settings', array(
			'title' => __('Site Logo'),
			'priority' => 0,
		));
		$wp_customize->add_section('vihv_settingsfavicon', array(
			'title' => __('Site Favicon'),
			'priority' => 0,
		));
		$wp_customize->add_control(new \WP_Customize_Media_Control($wp_customize, 'vihv_header_logo', array(
			'section' => 'vihv_settings',
		)));
		$wp_customize->add_control(new \WP_Customize_Image_Control($wp_customize, 'vihv_favicon', array(
			'section' => 'vihv_settingsfavicon',
		)));
		if(class_exists('WpThemeColors')) {
			foreach(WpThemeColors::getColors() as $color) {
				$wp_customize->add_setting('vihv_'.$color['name'], array(
					'default' => $color['default'],
					'transport' => 'refresh',
					'capability' => 'edit_theme_options',
				));
				$wp_customize->add_section('vihv_settings_'.$color['name'], array(
					'title' => __($color['title']),
					'priority' => 0,
				));
				$wp_customize->add_control(new \WP_Customize_Color_Control($wp_customize, 'vihv_'.$color['name'], 
					array(
						'section' => 'vihv_settings_'.$color['name'],
					)));
			} 
		}
	}// end of customizeRegister

}
