<?php  
/* 
	Plugin Name: Zone Slider
	Description: Custom implementation of jCarousel slider into Wordpress
	Author: Fourth Zone 
	Version: 1.0 
	Plugin URI: http://fourthzone.de
	Author URI: http://fourthzone.de
*/


/* settings for custom metabox */
function my_admin() {
	add_meta_box( 'zoneslider_meta_box',
	'Data for loader div',
	'display_zoneslider_meta_box',
	'zoneslider', 'normal', 'high' );
}

/* html settings for custom meta_box */
function display_zoneslider_meta_box( $item ) {
	// based on current item, we display selected data (type, source, divid, width, height)
	$type = intval( get_post_meta( $item->ID, 'type', true ) );
	$source = esc_html( get_post_meta( $item->ID, 'source', true ) );
	$divid = esc_html( get_post_meta( $item->ID, 'divid', true ) );
	$width = intval( get_post_meta( $item->ID, 'width', true ) );
	$height = intval( get_post_meta( $item->ID, 'height', true ) );
	?>


	<table style="width:100%; ">
	<!--TYPE-->
	<tr>
	<td style="width: 20%; float: left !important;"><b>Choose type</b><font style="font-size:11px;">(You can use video or image)</font></td>
	<td style="width: 32%; float: left !important;">
	<select id="select_type" style="width: 100px" name="zoneslider_type" onChange="changeText('select_type');">

	<?php
	// generate all items of drop-down list
	for ( $rating = 1; $rating <= 3; $rating ++ ) {
		?>
		<option value="<?php echo $rating; ?>"
		
		<?php
		// function selected compares current value, with selected value, and sets tag selected='selected'
		// <option value="1" selected="selected">, etc..
		echo selected( $rating, $type ); ?>>
		<?php if ($rating == "1") {echo 'Vimeo';}
		else if ($rating == "2") {echo 'Youtube';}
		else if ($rating == "3") {echo 'Image';} ?>
		<?php } ?>
	</select>
	</td>
	<td style="width: 20%;float: left !important;"></td>
	</tr>
	<!--SOURCE-->
	<tr>
	<td style="width: 20%; float: left !important;">
	<span id="source_title"></span>
	</td>
	<!-- onchange function trigers preview -->
	<td style="width: 32%;float: left !important;"><input id="zoneslider_source" onchange="preview('srcpreview');" type="text" size="80"
	name="zoneslider_source"
	value="<?php echo $source; ?>" /></td>
	<td style="width: 30%;float: left !important;"><span id="source_example"></span></td>
	</tr>
	<!--DIVID-->
	<tr>
	<td style="width: 20%; float: left !important;"><b>Div ID</b>
	<font style="font-size:11px;">(ID of div to show selected source)</font>
	</td>
	<td style="width: 32%; float: left !important;"><input id="zoneslider_divid" type="text" size="80"
	name="zoneslider_divid"
	value="<?php echo $divid; ?>" /></td>
	<td style="width: 30%;float: left !important;"><font style="font-size:11px;">Example:&nbsp;mydiv</font></td>
	</tr>
	<!--WIDTH-->
	<tr id="w">
	<td style="width: 20%; float: left !important;"><b>Width</b>
	<font style="font-size:11px;">(Set width of embeded video)
	</td>
	<td style="width: 32%; float: left !important;"><input id="zoneslider_width" onchange="preview('srcpreview');" type="text" size="80"
	name="zoneslider_width"
	value="<?php echo $width; ?>" /></td>
	<td style="width: 30%;float: left !important;"></td>
	</tr>
	<!--HEIGHT-->
	<tr id="h">
	<td style="width: 20%; float: left !important;"><b>Height</b>
	<font style="font-size:11px;">(Set height of embeded video)
	</td>
	<td style="width: 32%; float: left !important;"><input id="zoneslider_height" onchange="preview('srcpreview');" type="text" size="80"
	name="zoneslider_height"
	value="<?php echo $height; ?>" /></td>
	<td style="width: 30%;float: left !important;"></td>
	</tr>
	</table>
	<br />
	<!--PREVIEW-->
	<table style="width:400px;">
	<tr>
	<td style="width: 50%; float: left !important;"><b>Preview</b>
	</td>
	</tr>
	<tr id="preview">
	<td style="width: 50%; float: left !important;">
	<span id="srcpreview"></span>
	</td>
	</tr>
	</table>
	<?php
}

/* saves fields */
add_action( 'save_post', 'add_zoneslider_fields', 10, 2 );


/* function reads values and saves them */
function add_zoneslider_fields( $zoneslider_id, $item ) {
	// check post type for slider
	if ( $item->post_type == 'zoneslider' ) {
		// store data in post meta table if present in post data
		if ( isset( $_POST['zoneslider_source'] ) &&
				$_POST['zoneslider_source'] != '' ) {
			update_post_meta( $zoneslider_id, 'source',
			$_POST['zoneslider_source'] );
		}
		if ( isset( $_POST['zoneslider_type'] ) &&
				$_POST['zoneslider_type'] != '' ) {
			update_post_meta( $zoneslider_id, 'type',
			$_POST['zoneslider_type'] );
		}
		if ( isset( $_POST['zoneslider_divid'] ) &&
				$_POST['zoneslider_divid'] != '' ) {
			update_post_meta( $zoneslider_id, 'divid',
			$_POST['zoneslider_divid'] );
		}
		if ( isset( $_POST['zoneslider_width'] ) &&
				$_POST['zoneslider_width'] != '' ) {
			update_post_meta( $zoneslider_id, 'width',
			$_POST['zoneslider_width'] );
		}
		if ( isset( $_POST['zoneslider_height'] ) &&
				$_POST['zoneslider_height'] != '' ) {
			update_post_meta( $zoneslider_id, 'height',
			$_POST['zoneslider_height'] );
		}
	}
}

/* loading jQuery for back-end(adminko metalko) */

function pw_load_scripts($hook) {

	//load js only with specified hooks
	if( !is_admin() || $hook != 'post.php' )
	return;
	// now check to see if the $post type is 'zoneslider'
	global $post;
	if ( !isset($post) || 'zoneslider' != $post->post_type )
	return;
	
	wp_register_script('zoneslider_admin_script', plugins_url('admin.js', __FILE__));  
	// enqueue  
	wp_enqueue_script('jquery');  
	wp_enqueue_script('zoneslider_admin_script');
	
}
add_action('admin_enqueue_scripts', 'pw_load_scripts');

/* registering jQuery for front-end */
function zoneslider_register_scripts() {  
	if (!is_admin()) {  
		// register  
		wp_register_script('jcarousel-script', plugins_url('zoneslider/lib/jquery.jcarousel.min.js', __FILE__), array( 'jquery' ));  
		wp_register_script('zoneslider_script', plugins_url('start.js', __FILE__));  
		// enqueue  
		wp_enqueue_script('jcarousel-script');  
		wp_enqueue_script('zoneslider_script');  
	}  
}

/* registering css on page */
function zoneslider_register_styles() {  
	// register  
	//wp_register_style('zoneslider_styles', plugins_url('zoneslider/style.css', __FILE__));  
	wp_register_style('zoneslider_styles_theme', plugins_url('zoneslider/skins/default/skin.css', __FILE__));  
	// enqueue  
	wp_enqueue_style('zoneslider_styles');  
	wp_enqueue_style('zoneslider_styles_theme');  
}

/* function used to print data on front-end page */
function zoneslider_function($type='zoneslider_function') {  
	$args = array(  
	'post_type' => 'zoneslider',  
	'posts_per_page' => 20  
	);  
	$result = '<ul id="zonecarousel" class="jcarousel-skin-tango">';  
	//$result .= '<div id="slider" class="nivoSlider">';  
	//the loop  
	$loop = new WP_Query($args);  
	while ($loop->have_posts()) {  
		$loop->the_post();  
		$the_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), $type);
		
		//check if data is empty
		$fail = '0';
		
		//get type
		$field_type = get_post_meta(get_the_ID(), 'type', true);
		// check if the custum field has a value
		if($field_type == '') {
			$fail = '1';
		}
		
		//get source
		$field_source = get_post_meta(get_the_ID(), 'source', true);
		// check if the custum field has a value
		if($field_source == '') {
			$fail = '1';
		}
		
		
		//get divid
		$field_divid = get_post_meta(get_the_ID(), 'divid', true);
		// check if the custum field has a value
		if($field_divid == '') {
			$fail = '1';
		}
		
		//get width
		$field_width = get_post_meta(get_the_ID(), 'width', true);
		// check if the custum field has a value
		if($field_width == '') {
			$fail = '1';
		}
		
		//get height
		$field_height = get_post_meta(get_the_ID(), 'height', true);
		// check if the custum field has a value
		if($field_height == '') {
			$fail = '1';
		}
		
		// build source from values
		/*
		//vimeo
		if($field_type == "1"){
			$embed = 'document.getElementById(' . $field_divid . ').innerHTML = "<iframe src=\"http://player.vimeo.com/video/' . $field_source . '?badge=0\" width=\"' . $field_width . '\" height=\"' . $field_height . '\" frameborder=\"0\" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>"';
		}
		//yt
		else if($field_type == "2"){
			$embed = 'arni';
		}
		//image
		else if($field_type == "3"){
			$embed = 'semic';
		}
		else{
			$embed = 'nic';
		}
		*/
		
		// in case there are no empty values, fail flag stays at zero
		if($fail == '0')
		{
			//function chamile(divid, type, code, width, height)
			$result .='<li onclick="chamile(\''. $field_divid . '\', \'' . $field_type . '\', \'' . $field_source . '\', \'' . $field_width . '\', \'' . $field_height . '\');">';
		}
		else if($fail == '1')
		{
			$result .='<li>';
			
		}

		$result .='<img title="'.get_the_title().'" src="' . $the_url[0] . '" data-thumb="' . $the_url[0] . '" width="227" height="130" alt=""/>'; 
		$result .='</li>';
	}  
	
	$result .= '</ul>';
	return $result;  
}  

/* main function */
function zoneslider_init() {  
	// [np-shortcode] used for front-ent print
	add_shortcode('zoneslider', 'zoneslider_function');  

	//image size
	add_image_size('zoneslider_function', 227, 130, true);  

	$args = array(  
	'public' => true,  
	'label' => 'Zone Slider',  
	'supports' => array( 'title', 'thumbnail'),
	'menu_icon' => plugins_url( 'images/image.png', __FILE__ ),
	'has_archive' => true
	);
	

	register_post_type('zoneslider', $args);  
}


/* actions */

/* initiating meta_box */
add_action( 'admin_init', 'my_admin' );

add_theme_support( 'post-thumbnails' ); 
add_action('init', 'zoneslider_init');  
add_action('wp_print_scripts', 'zoneslider_register_scripts');  
add_action('wp_print_styles', 'zoneslider_register_styles');   


?>