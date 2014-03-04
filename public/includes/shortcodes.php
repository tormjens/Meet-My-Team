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


	/* Necessary Variables */
	protected $parent_container;
	protected $parent_container_class;
	protected $parent_container_id;
	protected $row_container_class;
	protected $item_container;
	protected $item_container_class;
	protected $cols;

	public function __construct() {
	}


	/**
	 *	Extracts the shortcode atts
	 *
	 *	@since 1.0.0
	 */
	public function extract_shortcodes( $atts ){
		extract( shortcode_atts( array(
			'parent_container'			=>	'div',
			'parent_container_class'	=>	'',
			'parent_container_id'		=>	'',

			'row_container_class'		=>	'row-fluid',

			'item_container'			=>	'div',
			'item_container_class'		=>	'',

			'cols'						=>	'3',
		), $atts ) );

		$this->parent_container 		= 	$parent_container;
		$this->parent_container_id		=	$parent_container_id;
		$this->parent_container_class	=	$parent_container_class;
		$this->row_container_class		=	$row_container_class;
		$this->item_container 			=	$item_container;
		
		if( $cols == "1" || $cols == "2" || $cols == "3" || $cols == "4" || $cols == "6" ){
			$this->cols = $cols;
		}
		else{
			$this->cols = "3";
		}

		if( $item_container_class == '' ){
			$this->item_container_class = "col-mmt-".(12/$this->cols);
		}
		else{
			$this->item_container_class = $item_container_class;
		}
	}
	
	/**
	 * Create Shortcodes
	 *
	 * @since    1.0.0
	 */
	public function display( $atts ){

		// Extracts the shortcodes 
		$this->extract_shortcodes($atts);

		// Gets the team members
		$team_members_list = $this->get_team_members();

		// Create the mmt display
		$mmt = "<".$this->parent_container." class='mmt_container ".$this->parent_container_class."' id='".$this->parent_container_id."'>";

			$team_members = array();
			foreach( $team_members_list as $index=>$member ){

				if( $index%( $this->cols ) == 0 ){
					$mmt .= '<div class="mmt_row '.$this->row_container_class.'">';
				}
				
				$member_details = array();
				$member_details['id']			=	$member->ID;
				$member_details['name']			=	$member->post_title;
				$member_details['designation']	=	get_post_meta( $member->ID, 'mmt_designation', true );
				$member_details['email']		=	get_post_meta( $member->ID, 'mmt_email', true );
				$member_details['bio_picture']	=	get_post_meta( $member->ID, 'mmt_bio_picture', true );
				$member_details['biography']	=	wpautop( get_post_meta( $member->ID, 'mmt_biography', true ) );
				$member_details['personal_url']	=	get_post_meta( $member->ID, 'mmt_personal_url', true );


				$mmt .= $this->build_single_member( $member_details );

				if( $index%( $this->cols ) == ($this->cols-1) ){
					$mmt .= '</div><!-- '.$this->row_container_class.' -->';
				}

			}

		$mmt .= "</".$this->parent_container.">";

		echo $mmt;

	}

	/**
	 *	Extracts the list of team members
	 */
	private function get_team_members(){

		$args = array(
			'posts_per_page'   => 	-1,
			'offset'           => 	0,
			'category'         => 	'',
			'orderby'          => 	'post_date',
			'order'            => 	'ASC',
			'include'          => 	'',
			'exclude'          => 	'',
			'meta_key'         => 	'',
			'meta_value'       => 	'',
			'post_type'        => 	'team_members',
			'post_mime_type'   => 	'',
			'post_parent'      => 	'',
			'post_status'      => 	'publish',
			'suppress_filters' => 	true
		);

		$team_members = get_posts( $args );

		return $team_members;

	}
	/**
	 *	Builds a single member
	 */
	private function build_single_member( $details ){

		// Build the Modal
		$modal = '	<div id="mmt_member_'.$details['id'].'" class="reveal-modal">
						<div class="mmt_bio_picture"><img src="'.$details['bio_picture'].'"></div>
						<h4>'.$details['name'].'</h4>
						<h6>'.$details['designation'].'</h6>';

		if( $details['email'] != '' ){				
			$modal .= '<a href="mailto:'.$details['email'].'" target="_blank">'.$details['email'].'</a>';
		}

		$modal .=	'<div>'.$details['biography'].'</div>';
		
		if( $details['personal_url'] != '' ){				
			$modal .= '<a href="'.$details['personal_url'].'" target="_blank">Personal Link</a>';
		}

		$modal .= '		<a class="close-reveal-modal">&#215;</a>
					</div>';

		// Build the initial display
		$display = '<'.$this->item_container.' data-reveal-id="mmt_member_'.$details['id'].'" class="mmt '.$this->item_container_class.'">';
			$display .= '<div class="mmt_member_img"><img src="'.$details['bio_picture'].'" alt="'.$details['name'].'" ></div>';
			$display .= '<h4>'.$details['name'].'</h3>';
			$display .= '<h6>'.$details['designation'].'</h4>';
		$display .= '</'.$this->item_container.'>';

		return $modal.$display;
	}

	

}