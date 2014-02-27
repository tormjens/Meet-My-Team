<?php
/**
 * Meet My Team Shortcodes
 *
 * @package   Meet My Team
 * @author    Aaron Lee <aaron.lee@buooy.com>
 * @license   GPL-2.0+
 * @link      http://buooy.com
 * @copyright 2014 Buooy
 */
class Meet_My_Team_Shortcodes {

	public function __construct() {
	}
	
	/**
	 * Create Shortcodes
	 *
	 * @since    1.0.0
	 */
	public function display( $atts ){

		
	
		$display = '<div id="myModal" class="reveal-modal">
						<h1>Modal Title</h1>
						<p>Any content could go in here.</p>
						<a class="close-reveal-modal">&#215;</a>
					</div>
					<a href="#" class="mmt" data-reveal-id="myModal">Click Me For A Modal</a>
					';
					
		return $display;
		
	}
	
	

}