<?php

add_action('wp_enqueue_scripts', 'coaches_custom_css_frontend');
function coaches_custom_css_frontend() {	
    wp_enqueue_style( 'custom_css_frontend', get_stylesheet_directory_uri(). '/style.css',false,'1.0','all'); 
}

add_action( 'admin_enqueue_scripts', 'coaches_custom_file' );
function coaches_custom_file() {
	wp_enqueue_style('admin-custom-css', get_stylesheet_directory_uri() . '/assets/css/admin-style.css', array(), '1.0', 'all');
}


function enqueue_owl_carousel() {
    // Enqueue Owl Carousel CSS
    wp_enqueue_style('owl-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css');
    
    // Enqueue Owl Carousel JS
    wp_enqueue_script('owl-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js', array('jquery'), '2.3.4', true);
}
add_action('wp_enqueue_scripts', 'enqueue_owl_carousel');



//*********************** allow to upload SVG files *******************************
function svg_file_types($mimes) {
 $mimes['svg'] = 'image/svg+xml';
 return $mimes;
}
add_filter('upload_mimes', 'svg_file_types');

function fix_svg() {
 echo '<style type="text/css">
      .attachment-266x266, .thumbnail img {
           width: 100% !important;
           height: auto !important;
      }
      </style>';
}
add_action('admin_head', 'fix_svg');


//*********** Allow to upload TTF, OTF, WOFF, and WOFF2 font file types **************

function cc_mime_types($mimes) {
 $mimes['ttf'] = 'application/x-font-ttf';
 $mimes['otf'] = 'application/x-font-opentype';
 $mimes['woff'] = 'application/font-woff';
 $mimes['woff2'] = 'application/font-woff2';
 return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

//Upload trainer profile photo (enqueue uploadtrainer.js)
function enqueue_upload_trainer_script() {
    //wp_enqueue_script( 'uploadtrainer-script', get_template_directory_uri() . 'assets/js/uploadtrainer.js', array( 'jquery' ), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'enqueue_upload_trainer_script' );


//*************************************************************************************** Custom Post Type for Trainers *******************************************************************************

function trainers_post_type() {
	$trainers = array(
					'description'         => 'Trainers',
					'show_ui'             => true,
					'menu_position'       => 2, // place menu item
					'menu_icon'           => 'dashicons-universal-access', // change menu icon
					'exclude_form_search' => false,
					'labels'			  => array(
											'name'                => 'Trainers',
											'singular_name'       => 'Trainer',
											'add_new'             => 'Add Trainer',
											'add_new_item'        => 'Add Trainer',
											'edit'                => 'Edit Trainer',
											'edit_item'           => 'Edit Trainers',
											'new-item'            => 'New Trainer',
											'view'                => 'View Trainer',
											'view-item'           => 'View Trainers',
											'search_item'         => 'Search Trainers',
											'not_found'           => 'No Trainers Found',
											'not_found_in_trash'  => 'No Trainers Found in Trash',
											'parent'              => 'Parent Trainers'					
					),
					'public'              => true,
					'capability_type'     => 'post',
					'hierarchical'        => false,
					'rewrite'             => true,
					'supports'            => array('title', 'editor', 'excerpt', 'thumbnail'),
					'has_archive'         => true,
					'show_in_rest'        => false,
					
			);
			register_post_type('trainers', $trainers);
}

//call the function
add_action('init', 'trainers_post_type');


//****************************************************************************** Register Category Taxonomy for Trainers ****************************************************************************** 

//********************************************************************************************

function create_trainers_taxonomies() {
    // Location Taxonomy
    $location_labels = array(
        'name'              => 'Location',
        'singular_name'     => 'Location',
        'search_items'      => 'Search Locations',
        'all_items'         => 'All Locations',
        'parent_item'       => 'Parent Location',
        'parent_item_colon' => 'Parent Location:',
        'edit_item'         => 'Edit Location',
        'update_item'       => 'Update Location',
        'add_new_item'      => 'Add New Location',
        'new_item_name'     => 'New Location Name',
        'menu_name'         => 'Location',
    );

    $location_args = array(
        'hierarchical'      => true,
        'labels'            => $location_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'trainers-category-location' ),
    );

    register_taxonomy( 'trainers-category-location', 'trainers', $location_args );

    // Gender Taxonomy
    $gender_labels = array(
        'name'              => 'Gender',
        'singular_name'     => 'Gender',
        'search_items'      => 'Search Genders',
        'all_items'         => 'All Genders',
        'parent_item'       => 'Parent Gender',
        'parent_item_colon' => 'Parent Gender:',
        'edit_item'         => 'Edit Gender',
        'update_item'       => 'Update Gender',
        'add_new_item'      => 'Add New Gender',
        'new_item_name'     => 'New Gender Name',
        'menu_name'         => 'Gender',
    );

    $gender_args = array(
        'hierarchical'      => true,
        'labels'            => $gender_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'trainers-category-gender' ),
    );

    register_taxonomy( 'trainers-category-gender', 'trainers', $gender_args );
}
add_action( 'init', 'create_trainers_taxonomies' );


//****************************************************************************************** Meta Boxes ***********************************************************************************************


function add_trainers_meta_box() {
    // Add meta box for trainers custom post type
    add_meta_box(
        'trainers_points_meta_box', // Meta box ID
        'Trainers Specialises On Home', // Meta box title
        'render_trainers_meta_box', // Callback function to render the meta box
        'trainers', // Post type
        'normal', // Position 
        'default' // Priority
    );

    // Add another meta box for additional content
    add_meta_box(
        'trainers_additional_content_meta_box', // Meta box ID
        'Additional Content', // Meta box title
        'render_trainers_additional_content_meta_box', // Callback function to render the meta box
        'trainers', // Post type
        'normal', // Position 
        'default' // Priority
    );

    // Add meta box for personal information
    add_meta_box(
        'trainers_personal_info_meta_box', // Meta box ID
        'Personal Information', // Meta box title
        'render_trainers_personal_info_meta_box', // Callback function to render the meta box
        'trainers', // Post type
        'normal', // Position 
        'default' // Priority
    );
	
	// Add meta box for trainers accordion
    add_meta_box(
        'trainers_points_accordion_meta_box', // Meta box ID
        'Trainers Specialises On Profile', // Meta box title
        'render_trainers_points_meta_box', // Callback function to render the meta box
        'trainers', // Post type
        'normal', // Position 
        'default' // Priority
    );
	
	//*********** Add meta box for trainers sounds *****************
   
	add_meta_box(
		'trainers_main_meta_box', // Meta box ID
		'Trainers Sounds and Motivational Speakers', // Meta box title
		'render_trainers_main_meta_box', // Callback function to render the meta box
		'trainers', // Post type
		'normal', // Position 
		'default' // Priority
	);
	
	add_meta_box(
        'client_meta_box', // Meta box ID
        'Add Client Reviews', // Meta box title
        'render_client_meta_box', // Callback function to render the meta box
        'trainers', // Post type
        'normal', // Position 
        'default' // Priority
    );
	
}
add_action('add_meta_boxes', 'add_trainers_meta_box');

function render_trainers_meta_box($post) {
    // Retrieve the saved points from the list content
    $points_form_list = get_post_meta($post->ID, 'points_form_list', true);
    
    // Display the WP Editor for the first meta box
    ?>
    <div class="custom-wp-editor-wrapper">
        <?php wp_editor($points_form_list, 'points_form_list_editor'); ?>
    </div>
    <?php
}

function render_trainers_additional_content_meta_box($post) {
    // Retrieve the saved additional content
    $additional_content = get_post_meta($post->ID, 'additional_content', true);
    
    // Display the WP Editor for the additional meta box
    ?>
    <div class="custom-wp-editor-wrapper">
        <?php wp_editor($additional_content, 'additional_content_editor'); ?>
    </div>
    <?php
}

function render_trainers_personal_info_meta_box($post) {
    // Retrieve the saved personal information
    $name = get_post_meta($post->ID, 'name', true);
    
    // Display the fields for personal information
    ?>
    <div class="personal-info-container">
        <div class="form-field">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo esc_attr($name); ?>">
        </div>
    </div>
    <?php
}


function render_trainers_points_meta_box($post) {
    // Retrieve the saved trainer information
    $trainer_name = get_post_meta($post->ID, 'trainer_name', true);
    $about_trainer = get_post_meta($post->ID, 'about_trainer', true);
    $specializations = get_post_meta($post->ID, 'specializations', true);
    $training_philosophy = get_post_meta($post->ID, 'training_philosophy', true);
    $education_experience_achievements = get_post_meta($post->ID, 'education_experience_achievements', true);
    $fun_fact_1 = get_post_meta($post->ID, 'fun_fact_1', true);
    $fun_fact_2 = get_post_meta($post->ID, 'fun_fact_2', true);
    $fun_fact_3 = get_post_meta($post->ID, 'fun_fact_3', true);
    $trainer_photo = get_post_meta($post->ID, 'trainer_photo', true);
    
    // Display the fields for trainer information
    ?>
    <div class="trainer-info-container">
		<div class="trainer-info-form-field">
            <label for="trainer_name">Trainer First Name:</label>
            <input type="text" id="trainer_name" name="trainer_name" value="<?php echo esc_attr($trainer_name); ?>">
        </div>
        <div class="trainer-info-form-field">
            <label for="about_trainer">About the Trainer:</label>
            <?php wp_editor($about_trainer, 'about_trainer', array('textarea_name' => 'about_trainer')); ?>
        </div>
        
		<div class="trainer-info-form-field">
			<label for="specializations">Specializations:</label>
			<?php wp_editor($specializations, 'specializations', array('textarea_name' => 'specializations')); ?>
		</div>
		<div class="trainer-info-form-field">
			<label for="specializations_bullet_points">Specializations Bullet Points:</label>
			<?php echo do_shortcode('[specializations_bullet_points]'); ?>
		</div>
		
		
        <div class="trainer-info-form-field">
            <label for="training_philosophy">Training Philosophy:</label>
            <?php wp_editor($training_philosophy, 'training_philosophy', array('textarea_name' => 'training_philosophy')); ?>
        </div>
		
		
		<div class="trainer-info-form-field">
			<label for="education_experience_achievements">Education, Experience & Achievements:</label>
			<?php wp_editor($education_experience_achievements, 'education_experience_achievements', array('textarea_name' => 'education_experience_achievements')); ?>
		</div>
		<div class="trainer-info-form-field">
			<label for="education_bullet_points">Education Bullet Points:</label>
			<?php echo do_shortcode('[education_bullet_points]'); ?>
		</div>
		
        <div class="trainer-info-form-field">
            <label for="fun_facts">3 Fun Facts:</label>
            <input type="text" id="fun_fact_1" name="fun_fact_1" value="<?php echo esc_attr($fun_fact_1); ?>">
            <input type="text" id="fun_fact_2" name="fun_fact_2" value="<?php echo esc_attr($fun_fact_2); ?>">
            <input type="text" id="fun_fact_3" name="fun_fact_3" value="<?php echo esc_attr($fun_fact_3); ?>">
        </div>
        <div class="form-field">
            <label for="trainer_photo">Trainer Photo:</label>
            <input type="hidden" id="trainer_photo" name="trainer_photo" value="<?php echo esc_attr($trainer_photo); ?>">
            <div id="trainer_photo_preview" class="image-preview">
                <?php if (!empty($trainer_photo)) : ?>
                    <img src="<?php echo esc_url($trainer_photo); ?>" alt="Trainer Photo" class="trainer-photo">
                <?php endif; ?>
            </div>
            <button id="upload_trainer_photo_button" class="button">Upload Image</button>
            <button id="remove_trainer_photo_button" class="button">Remove Image</button>
        </div>
    </div>

    <script>
        jQuery(document).ready(function($) {
            // Image upload
            $('#upload_trainer_photo_button').click(function(e) {
                e.preventDefault();
                var imageUploader = wp.media({
                    title: 'Upload Trainer Photo',
                    button: {
                        text: 'Select Photo'
                    },
                    multiple: false
                }).on('select', function() {
                    var attachment = imageUploader.state().get('selection').first().toJSON();
                    $('#trainer_photo').val(attachment.url);
                    $('#trainer_photo_preview').html('<img src="' + attachment.url + '" alt="Trainer Photo" class="trainer-photo" style="max-width: 200px; max-height: 200px;">');
                }).open();
            });

            // Image removal
            $('#remove_trainer_photo_button').click(function(e) {
                e.preventDefault();
                $('#trainer_photo').val('');
                $('#trainer_photo_preview').html('');
            });
        });
    </script>
    
    <?php
}



/*********************************************************************************/
//*********************** Sounds Main *****************************

function render_trainers_main_meta_box($post) {
    // Include the individual meta boxes
    render_trainers_sounds_meta_box($post);
    render_trainers_sounds_meta_box_2($post);
    render_trainers_sounds_meta_box_3($post);
    render_trainers_sounds_meta_box_4($post);
    render_trainers_sounds_meta_box_5($post);
}

//*********************** Sound 01 *******************************

function render_trainers_sounds_meta_box($post) {
    // Retrieve the saved sound information
    //$test_1 = get_post_meta($post->ID, 'test_1', true);
    $main_title = get_post_meta($post->ID, 'main_title', true);
    $title = get_post_meta($post->ID, 'sound_title', true);
    $artist = get_post_meta($post->ID, 'sound_artist', true);
    $spotify_link = get_post_meta($post->ID, 'sound_spotify_link', true);
    $album_cover = get_post_meta($post->ID, 'sound_album_cover', true);
    
    // Display the fields for sound information
    ?>
    <div class="sound-info-container">
		<!--<div class="sound-info-form-field">
            <label for="test_1">Test One:</label>
            <input type="text" id="test_1" name="test_1" value="<?php echo esc_attr($test_1); ?>">
        </div>-->
		<div class="sound-info-form-field">
            <label for="main_title">Main Title:</label>
            <input type="text" id="main_title" name="main_title" value="<?php echo esc_attr($main_title); ?>">
        </div>
        <div class="sound-info-form-field">
            <label for="sound_title">Title:</label>
            <input type="text" id="sound_title" name="sound_title" value="<?php echo esc_attr($title); ?>">
        </div>
        <div class="sound-info-form-field">
            <label for="sound_artist">Artist:</label>
            <input type="text" id="sound_artist" name="sound_artist" value="<?php echo esc_attr($artist); ?>">
        </div>
        <div class="sound-info-form-field">
            <label for="sound_spotify_link">Spotify Link:</label>
            <input type="text" id="sound_spotify_link" name="sound_spotify_link" value="<?php echo esc_attr($spotify_link); ?>">
        </div>
        <div class="sound-info-form-field">
            <label for="sound_album_cover">Album Cover:</label>
            <input type="hidden" id="sound_album_cover" name="sound_album_cover" value="<?php echo esc_attr($album_cover); ?>">
            <div id="sound_album_cover_preview" class="image-preview">
                <?php if (!empty($album_cover)) : ?>
                    <img src="<?php echo esc_url($album_cover); ?>" alt="Album Cover" class="album-cover" style="max-width: 200px; max-height: 200px;">
                <?php else : ?>
                    <p>No image chosen</p>
                <?php endif; ?>
            </div>
            <button id="upload_album_cover_button" class="button">Add Album Image</button>
            <button id="remove_album_cover_button" class="button">Remove Album Image</button>
        </div>
    </div>

    <script>
        jQuery(document).ready(function($) {
            // Album cover upload
            $('#upload_album_cover_button').click(function(e) {
                e.preventDefault();
                var albumCoverUploader = wp.media({
                    title: 'Add Album Cover',
                    button: {
                        text: 'Select Image'
                    },
                    library: {
                        type: 'image'
                    },
                    multiple: false
                }).on('select', function() {
                    var attachment = albumCoverUploader.state().get('selection').first().toJSON();
                    $('#sound_album_cover').val(attachment.url);
                    $('#sound_album_cover_preview').html('<img src="' + attachment.url + '" alt="Album Cover" class="album-cover" style="max-width: 200px; max-height: 200px;">');
                }).open();
            });

            // Album cover removal
            $('#remove_album_cover_button').click(function(e) {
                e.preventDefault();
                $('#sound_album_cover').val('');
                $('#sound_album_cover_preview').html('<p>No image chosen</p>');
            });
        });
    </script>
    <?php
}

//*********************** Sound 02 *******************************


// Render the additional trainers sounds meta boxes
function render_trainers_sounds_meta_box_2($post) {
    // Retrieve the saved sound information for meta box 2
    $title_2 = get_post_meta($post->ID, 'sound_title_2', true);
    $artist_2 = get_post_meta($post->ID, 'sound_artist_2', true);
    $spotify_link_2 = get_post_meta($post->ID, 'sound_spotify_link_2', true);
    $album_cover_2 = get_post_meta($post->ID, 'sound_album_cover_2', true);

    // Display the fields for sound information in meta box 2
    ?>
    <div class="sound-info-container">
        <div class="sound-info-form-field">
            <label for="sound_title_2">Title:</label>
            <input type="text" id="sound_title_2" name="sound_title_2" value="<?php echo esc_attr($title_2); ?>">
        </div>
        <div class="sound-info-form-field">
            <label for="sound_artist_2">Artist:</label>
            <input type="text" id="sound_artist_2" name="sound_artist_2" value="<?php echo esc_attr($artist_2); ?>">
        </div>
        <div class="sound-info-form-field">
            <label for="sound_spotify_link_2">Spotify Link:</label>
            <input type="text" id="sound_spotify_link_2" name="sound_spotify_link_2" value="<?php echo esc_attr($spotify_link_2); ?>">
        </div>
        <div class="sound-info-form-field">
            <label for="sound_album_cover_2">Album Cover:</label>
            <input type="hidden" id="sound_album_cover_2" name="sound_album_cover_2" value="<?php echo esc_attr($album_cover_2); ?>">
            <div id="sound_album_cover2_preview" class="image-preview">
                <?php if (!empty($album_cover_2)) : ?>
                    <img src="<?php echo esc_url($album_cover_2); ?>" alt="Album Cover" class="album-cover" style="max-width: 200px; max-height: 200px;">
                <?php else : ?>
                    <p>No image chosen</p>
                <?php endif; ?>
            </div>
            <button id="upload_album_cover_button2" class="button">Add Album Image</button>
            <button id="remove_album_cover_button2" class="button">Remove Album Image</button>
        </div>
    </div>

    <script>
        jQuery(document).ready(function($) {
            // Album cover upload
            $('#upload_album_cover_button2').click(function(e) {
                e.preventDefault();
                var albumCoverUploader = wp.media({
                    title: 'Add Album Cover',
                    button: {
                        text: 'Select Image'
                    },
                    library: {
                        type: 'image'
                    },
                    multiple: false
                }).on('select', function() {
                    var attachment = albumCoverUploader.state().get('selection').first().toJSON();
                    $('#sound_album_cover_2').val(attachment.url);
                    $('#sound_album_cover2_preview').html('<img src="' + attachment.url + '" alt="Album Cover" class="album-cover" style="max-width: 200px; max-height: 200px;">');
                }).open();
            });

            // Album cover removal
            $('#remove_album_cover_button2').click(function(e) {
                e.preventDefault();
                $('#sound_album_cover_2').val('');
                $('#sound_album_cover2_preview').html('<p>No image chosen</p>');
            });
        });
    </script>
    <?php
}

//******************************** Sound 03 ***************************************

function render_trainers_sounds_meta_box_3($post) {
    // Retrieve the saved sound information for meta box 3
    $title_3 = get_post_meta($post->ID, 'sound_title_3', true);
    $artist_3 = get_post_meta($post->ID, 'sound_artist_3', true);
    $spotify_link_3 = get_post_meta($post->ID, 'sound_spotify_link_3', true);
    $album_cover_3 = get_post_meta($post->ID, 'sound_album_cover_3', true);

    // Display the fields for sound information in meta box 3
    ?>
    <div class="sound-info-container">
        <div class="sound-info-form-field">
            <label for="sound_title_3">Title:</label>
            <input type="text" id="sound_title_3" name="sound_title_3" value="<?php echo esc_attr($title_3); ?>">
        </div>
        <div class="sound-info-form-field">
            <label for="sound_artist_3">Artist:</label>
            <input type="text" id="sound_artist_3" name="sound_artist_3" value="<?php echo esc_attr($artist_3); ?>">
        </div>
        <div class="sound-info-form-field">
            <label for="sound_spotify_link_3">Spotify Link:</label>
            <input type="text" id="sound_spotify_link_3" name="sound_spotify_link_3" value="<?php echo esc_attr($spotify_link_3); ?>">
        </div>
        <div class="sound-info-form-field">
            <label for="sound_album_cover_3">Album Cover:</label>
            <input type="hidden" id="sound_album_cover_3" name="sound_album_cover_3" value="<?php echo esc_attr($album_cover_3); ?>">
            <div id="sound_album_cover3_preview" class="image-preview">
                <?php if (!empty($album_cover_3)) : ?>
                    <img src="<?php echo esc_url($album_cover_3); ?>" alt="Album Cover" class="album-cover" style="max-width: 200px; max-height: 200px;">
                <?php else : ?>
                    <p>No image chosen</p>
                <?php endif; ?>
            </div>
            <button id="upload_album_cover_button3" class="button">Add Album Image</button>
            <button id="remove_album_cover_button3" class="button">Remove Album Image</button>
        </div>
    </div>

    <script>
        jQuery(document).ready(function($) {
            // Album cover upload
            $('#upload_album_cover_button3').click(function(e) {
                e.preventDefault();
                var albumCoverUploader = wp.media({
                    title: 'Add Album Cover',
                    button: {
                        text: 'Select Image'
                    },
                    library: {
                        type: 'image'
                    },
                    multiple: false
                }).on('select', function() {
                    var attachment = albumCoverUploader.state().get('selection').first().toJSON();
                    $('#sound_album_cover_3').val(attachment.url);
                    $('#sound_album_cover3_preview').html('<img src="' + attachment.url + '" alt="Album Cover" class="album-cover" style="max-width: 200px; max-height: 200px;">');
                }).open();
            });

            // Album cover removal
            $('#remove_album_cover_button3').click(function(e) {
                e.preventDefault();
                $('#sound_album_cover_3').val('');
                $('#sound_album_cover3_preview').html('<p>No image chosen</p>');
            });
        });
    </script>
    <?php
}

//***************************** Sound 04 **********************************
function render_trainers_sounds_meta_box_4($post) {
    // Retrieve the saved sound information for meta box 4
    $title_4 = get_post_meta($post->ID, 'sound_title_4', true);
    $artist_4 = get_post_meta($post->ID, 'sound_artist_4', true);
    $spotify_link_4 = get_post_meta($post->ID, 'sound_spotify_link_4', true);
    $album_cover_4 = get_post_meta($post->ID, 'sound_album_cover_4', true);

    // Display the fields for sound information in meta box 4
    ?>
    <div class="sound-info-container">
        <div class="sound-info-form-field">
            <label for="sound_title_4">Title:</label>
            <input type="text" id="sound_title_4" name="sound_title_4" value="<?php echo esc_attr($title_4); ?>">
        </div>
        <div class="sound-info-form-field">
            <label for="sound_artist_4">Artist:</label>
            <input type="text" id="sound_artist_4" name="sound_artist_4" value="<?php echo esc_attr($artist_4); ?>">
        </div>
        <div class="sound-info-form-field">
            <label for="sound_spotify_link_4">Spotify Link:</label>
            <input type="text" id="sound_spotify_link_4" name="sound_spotify_link_4" value="<?php echo esc_attr($spotify_link_4); ?>">
        </div>
        <div class="sound-info-form-field">
            <label for="sound_album_cover_4">Album Cover:</label>
            <input type="hidden" id="sound_album_cover_4" name="sound_album_cover_4" value="<?php echo esc_attr($album_cover_4); ?>">
            <div id="sound_album_cover4_preview" class="image-preview">
                <?php if (!empty($album_cover_4)) : ?>
                    <img src="<?php echo esc_url($album_cover_4); ?>" alt="Album Cover" class="album-cover" style="max-width: 200px; max-height: 200px;">
                <?php else : ?>
                    <p>No image chosen</p>
                <?php endif; ?>
            </div>
            <button id="upload_album_cover_button4" class="button">Add Album Image</button>
            <button id="remove_album_cover_button4" class="button">Remove Album Image</button>
        </div>
    </div>

    <script>
        jQuery(document).ready(function($) {
            // Album cover upload
            $('#upload_album_cover_button4').click(function(e) {
                e.preventDefault();
                var albumCoverUploader = wp.media({
                    title: 'Add Album Cover',
                    button: {
                        text: 'Select Image'
                    },
                    library: {
                        type: 'image'
                    },
                    multiple: false
                }).on('select', function() {
                    var attachment = albumCoverUploader.state().get('selection').first().toJSON();
                    $('#sound_album_cover_4').val(attachment.url);
                    $('#sound_album_cover4_preview').html('<img src="' + attachment.url + '" alt="Album Cover" class="album-cover" style="max-width: 200px; max-height: 200px;">');
                }).open();
            });

            // Album cover removal
            $('#remove_album_cover_button4').click(function(e) {
                e.preventDefault();
                $('#sound_album_cover_4').val('');
                $('#sound_album_cover4_preview').html('<p>No image chosen</p>');
            });
        });
    </script>
    <?php
}


//********************************** Sound 05 **************************************

function render_trainers_sounds_meta_box_5($post) {
    // Retrieve the saved sound information for meta box 5
    $title_5 = get_post_meta($post->ID, 'sound_title_5', true);
    $artist_5 = get_post_meta($post->ID, 'sound_artist_5', true);
    $spotify_link_5 = get_post_meta($post->ID, 'sound_spotify_link_5', true);
    $album_cover_5 = get_post_meta($post->ID, 'sound_album_cover_5', true);

    // Display the fields for sound information in meta box 5
    ?>
    <div class="sound-info-container">
        <div class="sound-info-form-field">
            <label for="sound_title_5">Title:</label>
            <input type="text" id="sound_title_5" name="sound_title_5" value="<?php echo esc_attr($title_5); ?>">
        </div>
        <div class="sound-info-form-field">
            <label for="sound_artist_5">Artist:</label>
            <input type="text" id="sound_artist_5" name="sound_artist_5" value="<?php echo esc_attr($artist_5); ?>">
        </div>
        <div class="sound-info-form-field">
            <label for="sound_spotify_link_5">Spotify Link:</label>
            <input type="text" id="sound_spotify_link_5" name="sound_spotify_link_5" value="<?php echo esc_attr($spotify_link_5); ?>">
        </div>
        <div class="sound-info-form-field">
            <label for="sound_album_cover_5">Album Cover:</label>
            <input type="hidden" id="sound_album_cover_5" name="sound_album_cover_5" value="<?php echo esc_attr($album_cover_5); ?>">
            <div id="sound_album_cover5_preview" class="image-preview">
                <?php if (!empty($album_cover_5)) : ?>
                    <img src="<?php echo esc_url($album_cover_5); ?>" alt="Album Cover" class="album-cover" style="max-width: 200px; max-height: 200px;">
                <?php else : ?>
                    <p>No image chosen</p>
                <?php endif; ?>
            </div>
            <button id="upload_album_cover_button5" class="button">Add Album Image</button>
            <button id="remove_album_cover_button5" class="button">Remove Album Image</button>
        </div>
    </div>

    <script>
        jQuery(document).ready(function($) {
            // Album cover upload
            $('#upload_album_cover_button5').click(function(e) {
                e.preventDefault();
                var albumCoverUploader = wp.media({
                    title: 'Add Album Cover',
                    button: {
                        text: 'Select Image'
                    },
                    library: {
                        type: 'image'
                    },
                    multiple: false
                }).on('select', function() {
                    var attachment = albumCoverUploader.state().get('selection').first().toJSON();
                    $('#sound_album_cover_5').val(attachment.url);
                    $('#sound_album_cover5_preview').html('<img src="' + attachment.url + '" alt="Album Cover" class="album-cover" style="max-width: 200px; max-height: 200px;">');
                }).open();
            });

            // Album cover removal
            $('#remove_album_cover_button5').click(function(e) {
                e.preventDefault();
                $('#sound_album_cover_5').val('');
                $('#sound_album_cover5_preview').html('<p>No image chosen</p>');
            });
        });
    </script>
    <?php
}


//**************************** Client's Review ***********************************

function render_client_meta_box($post) {
    // Retrieve the saved client information
    $client_fields = get_post_meta($post->ID, 'client_fields', true);
	$test_2 = get_post_meta($post->ID, 'test_2', true);
	?>
	
	<div class="client-info-form-field">
		<label for="test_2">test_2:</label>
		<input type="text" id="test_2" name="test_2" value="<?php echo esc_attr($test_2); ?>">
	</div>
    
	<?php

    // Ensure $client_fields is an array
    if (!is_array($client_fields)) {
        $client_fields = array();
    }

    // Display the fields for client information
    ?>
    <div class="client-info-container">
        <?php foreach ($client_fields as $index => $field) : ?>
            <div class="client-info-form-field">
                <label for="client_name_<?php echo $index; ?>">Client Name:</label>
                <input type="text" id="client_name_<?php echo $index; ?>" name="client_fields[<?php echo $index; ?>][client_name]" value="<?php echo esc_attr($field['client_name']); ?>">
            </div>
            <div class="client-info-form-field">
                <label for="comment_<?php echo $index; ?>">Comment:</label>
                <textarea id="comment_<?php echo $index; ?>" name="client_fields[<?php echo $index; ?>][comment]" class="comment-textarea"><?php echo esc_textarea($field['comment']); ?></textarea>
            </div>
        <?php endforeach; ?>
    </div>

    <button id="add_client_field_button" class="button">Add More</button>

    <script>
        jQuery(document).ready(function($) {
            var clientFieldsContainer = $('.client-info-container');
            var addClientFieldButton = $('#add_client_field_button');
            var index = <?php echo count($client_fields); ?>;

            // Add more client fields
            addClientFieldButton.click(function(e) {
                e.preventDefault();

                var fieldHtml = `
                    <div class="client-info-form-field">
                        <label for="client_name_${index}">Client Name:</label>
                        <input type="text" id="client_name_${index}" name="client_fields[${index}][client_name]" value="">
                    </div>
                    <div class="client-info-form-field">
                        <label for="comment_${index}">Comment:</label>
                        <textarea id="comment_${index}" name="client_fields[${index}][comment]"></textarea>
                    </div>
                `;

                clientFieldsContainer.append(fieldHtml);
                index++;
            });
        });
    </script>
    <?php
}


/*********************************************************************************/

function save_trainers_meta_box($post_id) {
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Save points from the list content
    if (isset($_POST['points_form_list_editor'])) {
        $points_form_list = wp_kses_post($_POST['points_form_list_editor']);
        update_post_meta($post_id, 'points_form_list', $points_form_list);
    }

    // Save additional content
    if (isset($_POST['additional_content_editor'])) {
        $additional_content = wp_kses_post($_POST['additional_content_editor']);
        update_post_meta($post_id, 'additional_content', $additional_content);
    }
    
    // Save personal information
    $personal_info_fields = array('name');
    foreach ($personal_info_fields as $field) {
        if (isset($_POST[$field])) {
            $value = sanitize_text_field($_POST[$field]);
            update_post_meta($post_id, $field, $value);
        }
    }
    
    // Save trainer information
	$trainer_fields = array('trainer_name', 'about_trainer', 'specializations', 'training_philosophy', 'education_experience_achievements', 'trainer_photo','fun_fact_1','fun_fact_2','fun_fact_3');
	foreach ($trainer_fields as $field) {
		if (isset($_POST[$field])) {
			$value = $_POST[$field];
			update_post_meta($post_id, $field, $value);
		}
	}

	
	// Save sound information
	$sound_fields = array('test_1', 'main_title', 'sound_title', 'sound_artist', 'sound_spotify_link', 'sound_album_cover');
	foreach ($sound_fields as $field) {
		if (isset($_POST[$field])) {
			$value = $_POST[$field]; // Remove the sanitize_text_field() function
			update_post_meta($post_id, $field, $value);
		}
	}

	// Save sound information for meta box 2
	$sound_fields_2 = array('sound_title_2', 'sound_artist_2', 'sound_spotify_link_2', 'sound_album_cover_2');
	foreach ($sound_fields_2 as $field) {
		if (isset($_POST[$field])) {
			$value = $_POST[$field]; // Remove the sanitize_text_field() function
			update_post_meta($post_id, $field, $value);
		}
	}

	// Save sound information for meta box 3
	$sound_fields_3 = array('sound_title_3', 'sound_artist_3', 'sound_spotify_link_3', 'sound_album_cover_3');
	foreach ($sound_fields_3 as $field) {
		if (isset($_POST[$field])) {
			$value = $_POST[$field]; // Remove the sanitize_text_field() function
			update_post_meta($post_id, $field, $value);
		}
	}

	// Save sound information for meta box 4
	$sound_fields_4 = array('sound_title_4', 'sound_artist_4', 'sound_spotify_link_4', 'sound_album_cover_4');
	foreach ($sound_fields_4 as $field) {
		if (isset($_POST[$field])) {
			$value = $_POST[$field]; // Remove the sanitize_text_field() function
			update_post_meta($post_id, $field, $value);
		}
	}

	// Save sound information for meta box 5
	$sound_fields_5 = array('sound_title_5', 'sound_artist_5', 'sound_spotify_link_5', 'sound_album_cover_5');
	foreach ($sound_fields_5 as $field) {
		if (isset($_POST[$field])) {
			$value = $_POST[$field]; // Remove the sanitize_text_field() function
			update_post_meta($post_id, $field, $value);
		}
	}

	// Save test_2 field
    if (isset($_POST['test_2'])) {
        $test_2 = sanitize_text_field($_POST['test_2']);
        update_post_meta($post_id, 'test_2', $test_2);
    }
	
	// Save client fields
    if (isset($_POST['client_fields'])) {
        $client_fields = $_POST['client_fields'];
        $sanitized_client_fields = array();

        foreach ($client_fields as $field) {
            $sanitized_field = array(
                'client_name' => isset($field['client_name']) ? sanitize_text_field($field['client_name']) : '',
                //'comment' => isset($field['comment']) ? sanitize_text_field($field['comment']) : ''
                'comment' => isset($field['comment']) ? $field['comment'] : ''
            );

            $sanitized_client_fields[] = $sanitized_field;
        }

        update_post_meta($post_id, 'client_fields', $sanitized_client_fields);
    }
}
add_action('save_post', 'save_trainers_meta_box');



//*********************************************************************************** Create a shortcode for display all coaches **********************************************************************


function list_coaches_func($atts) {
    // get the location
    $locations = get_terms( array(
        'taxonomy' => 'trainers-category-location',
        'hide_empty' => false,
    ));

    // get the gender
    $genders = get_terms( array(
        'taxonomy' => 'trainers-category-gender',
        'hide_empty' => false,
    ));

    ob_start();

    // Define attributes and their defaults
    extract(shortcode_atts(array(
        'type' => 'trainers',
        'posts' => 12,
        'order' => 'ASC',
        'orderby' => 'post_date',
    ), $atts));

    // Sanitize shortcode attributes
    $type = sanitize_key($type);
    $posts = absint($posts);
    $order = sanitize_key($order);
    $orderby = sanitize_key($orderby);

    // Define query parameters based on attributes
    $options = array(
        'post_type' => $type,
        'posts_per_page' => -1,
        'order' => $order,
        'orderby' => $orderby,
    );

    ?>

	<div class="filter_row">
        <div class="filter_col">
            <div class="filter_box drop_arrow">
                <!-- *************** Filter coaches by location ***********************-->
                <label>Filter by location:</label>
                <select name="location" class="location_filter">
                    <option value="all_location">All Locations</option>
                    <?php
                    foreach ($locations as $location) {
                        echo '<option value="' . $location->slug . '">' . $location->name . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="filter_box drop_arrow">
                <!-- *****************Filter coaches by gender **********************  -->
                <label>Filter by gender:</label>
                <select name="gender" class="gender_filter">
                    <option value="all_gender">All Genders</option>
                    <?php
                    foreach ($genders as $gender) {
                        echo '<option value="' . $gender->slug . '">' . $gender->name . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>

    <div class="posts-row">

        <?php
        global $post;
        $query = new WP_Query($options);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();

                //Getting location slug
                $terms_location = get_the_terms(get_the_ID(), 'trainers-category-location');
                $term_slug_location = '';

                if ($terms_location && !is_wp_error($terms_location)) {
                    foreach ($terms_location as $term_location) {
                        $term_slug_location .= $term_location->slug . ' ';
                    }
                }

                //Getting gender slug
                $terms_gender = get_the_terms(get_the_ID(), 'trainers-category-gender');
                $term_slug_gender = '';

                if ($terms_gender && !is_wp_error($terms_gender)) {
                    foreach ($terms_gender as $term_gender) {
                        $term_slug_gender .= $term_gender->slug . ' ';
                    }
                }

                ?>

                <div class="post-item single_trainer" data-location="<?php echo $term_slug_location; ?>" data-gender="<?php echo $term_slug_gender; ?>" id="<?php echo get_the_ID(); ?>">
					<div class="coaches-display-name">
						<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					</div>
					<a href="<?php the_permalink(); ?>">
						<?php
						$post_thumbnail_id = get_post_thumbnail_id();
						if (isset($post_thumbnail_id) && has_post_thumbnail()) {
							the_post_thumbnail('large', array('class' => 'coaches-images'));
						} else {
							echo '<img src="https://akashint.wpengine.com/wp-content/uploads/2023/04/default-event-image.jpg" class="no-featured-image">';
						}
						?>
					</a>
					<div class="display-hover-wrapper">
						<div class="display-hover-content">
							<?php
							// Get the saved points from list content
							$points_form_list = get_post_meta(get_the_ID(), 'points_form_list', true);
							// Get the post title
							$post_title = get_the_title();
							?>
							<?php
							// Display the post title
							echo '<h2>' . $post_title . '</h2>';

							// Display the saved points form list content
							echo '<p>specialises in:</p>';
							?>
							<div class="coaches-details-list-view">
								<?php
								// Convert the text to bullet points
								$bullet_points = explode("\n", $points_form_list);
								if (!empty($bullet_points)) {
									echo '<ul>';
									foreach ($bullet_points as $bullet_point) {
										echo '<li>' . $bullet_point . '</li>';
									}
									echo '</ul>';
								}
								?>
							</div>
							<?php
							echo '<a href="' . get_permalink() . '" class="coaches-seemore-button">See More ›</a>';
							?>
						</div>
					</div>
					<div><?php the_excerpt(); ?></div>
				</div>

                <?php
            }
        } else {
            echo '<p>No coaches found.</p>';
        }
        wp_reset_postdata();
        ?>
    </div>

    <div class="load-more-btn">
        <button id="load-more-btn" class="btn-load-more">Load More Coaches</button>
    </div>

    <script type="text/javascript">
		jQuery(function ($) {
			var trainersPerPage = <?php echo $posts; ?>; // Number of trainers to display per page
			var loadMoreButton = $('#load-more-btn'); // Load More button element
			var allTrainers = $('.single_trainer'); // All trainer elements
			var visibleTrainers = allTrainers.slice(0, trainersPerPage); // Initially visible trainers
			var hiddenTrainers;

			visibleTrainers.show(); // Show initially visible trainers

			if (allTrainers.length > trainersPerPage) {
				loadMoreButton.show(); // Show Load More button if there are more trainers to display
			} else {
				loadMoreButton.hide(); // Hide Load More button if all trainers are already visible
			}

			loadMoreButton.on('click', function (e) {
				e.preventDefault();

				hiddenTrainers = $('.single_trainer:hidden'); // Get hidden trainers
				hiddenTrainers.slice(0, trainersPerPage).slideDown(); // Show next set of hidden trainers
				if (hiddenTrainers.length <= trainersPerPage) {
					loadMoreButton.hide(); // Hide Load More button if no more trainers to show
				}
			});

				$(".location_filter, .gender_filter").change(function () {
					var locationFilter = $('.location_filter').val(); // Selected location filter value
					var genderFilter = $('.gender_filter').val(); // Selected gender filter value

					allTrainers.hide(); // Hide all trainers

					allTrainers.each(function () {
						var location = $(this).data('location'); // Location data attribute value
						var gender = $(this).data('gender'); // Gender data attribute value

						if ((locationFilter === 'all_location' || location.indexOf(locationFilter) !== -1) && (genderFilter === 'all_gender' || gender.indexOf(genderFilter) !== -1)) {
							$(this).show(); // Show trainers matching the selected location and gender filters
						}
					});

					visibleTrainers = $('.single_trainer:visible'); // Update visible trainers
					hiddenTrainers = $('.single_trainer:hidden'); // Update hidden trainers

					visibleTrainers.slice(trainersPerPage).hide(); // Hide trainers exceeding the trainersPerPage limit

					if (hiddenTrainers.length > 0) {
						loadMoreButton.show(); // Show Load More button if there are more hidden trainers
					} else {
						loadMoreButton.hide(); // Hide Load More button if no more hidden trainers
					}

					if (visibleTrainers.length === 0) {
						$('.posts-row').append('<p>No coaches found.</p>'); // Display a message if no coaches match the filters
					} else {
						$('.posts-row p').remove(); // Remove the "No coaches found" message if it was displayed previously
					}

					if (locationFilter === 'all_location' && genderFilter === 'all_gender') {
						visibleTrainers.show(); // Show all trainers if both filters are set to "All"
						loadMoreButton.hide(); // Hide Load More button when options are chosen from the filtering part
					} else {
						loadMoreButton.hide(); // Hide the "Load More Coaches" button when options are chosen from the filtering part
					}
				});
			});
	</script>


    <style>
        .single_trainer {
            display: none;
        }

        .single_trainer:nth-child(-n+12) {
            display: block;
        }
    </style>

    <?php
    return ob_get_clean();
}
add_shortcode('list_coaches', 'list_coaches_func');


/******************************************************************** For Display 3 fun facts as a 3 number points in the DIVI accordion ************************************************************/
function display_trainers_fun_facts_shortcode($atts) {
    $atts = shortcode_atts(array(
        'post_id' => get_the_ID(),
    ), $atts);

    $fun_fact_1 = get_post_meta($atts['post_id'], 'fun_fact_1', true);
    $fun_fact_2 = get_post_meta($atts['post_id'], 'fun_fact_2', true);
    $fun_fact_3 = get_post_meta($atts['post_id'], 'fun_fact_3', true);

    // Prepare the output HTML
    $output = '';
    if (!empty($fun_fact_1) || !empty($fun_fact_2) || !empty($fun_fact_3)) {
        $output .= '<ol>';
        if (!empty($fun_fact_1)) {
            $output .= '<li>' . esc_html($fun_fact_1) . '</li>';
        }
        if (!empty($fun_fact_2)) {
            $output .= '<li>' . esc_html($fun_fact_2) . '</li>';
        }
        if (!empty($fun_fact_3)) {
            $output .= '<li>' . esc_html($fun_fact_3) . '</li>';
        }
        $output .= '</ol>';
    }

    return $output;
}
add_shortcode('trainers_fun_facts', 'display_trainers_fun_facts_shortcode');

//*********************************************************** Bullet Points ******************************************

function display_specializations_bullet_points_shortcode($atts) {
    // Get the saved specializations data
    $specializations = get_post_meta(get_the_ID(), 'specializations', true);

    // Convert the entered specializations data to bullet points
    $specializations_bullet_points = preg_split('/\r\n|\r|\n/', $specializations);
    $specializations_bullet_points = array_map('trim', $specializations_bullet_points);
    $specializations_bullet_points = array_filter($specializations_bullet_points);

    // Generate the HTML for bullet points
    $output = '';
    if (!empty($specializations_bullet_points)) {
        $output .= '<ul>';
        foreach ($specializations_bullet_points as $bullet_point) {
            $output .= '<li>' . $bullet_point . '</li>';
        }
        $output .= '</ul>';
    }

    return $output;
}
add_shortcode('specializations_bullet_points', 'display_specializations_bullet_points_shortcode');

function display_education_bullet_points_shortcode($atts) {
    // Get the saved education, experience, and achievements data
    $education_experience_achievements = get_post_meta(get_the_ID(), 'education_experience_achievements', true);

    // Convert the entered education, experience, and achievements data to bullet points
    $education_bullet_points = preg_split('/\r\n|\r|\n/', $education_experience_achievements);
    $education_bullet_points = array_map('trim', $education_bullet_points);
    $education_bullet_points = array_filter($education_bullet_points);

    // Generate the HTML for bullet points
    $output = '';
    if (!empty($education_bullet_points)) {
        $output .= '<ul>';
        foreach ($education_bullet_points as $bullet_point) {
            $output .= '<li>' . $bullet_point . '</li>';
        }
        $output .= '</ul>';
    }

    return $output;
}
add_shortcode('education_bullet_points', 'display_education_bullet_points_shortcode');

//************************************************************************************************ Sounds Carousel ***********************************************************************************

function owl_carousel_shortcode($atts) {
    // Retrieve the album cover, titles, artists, and Spotify links from post meta
    $sound_album_cover = get_post_meta(get_the_ID(), 'sound_album_cover', true);
    $album_covers = array($sound_album_cover);
    $sound_titles = array(get_post_meta(get_the_ID(), 'sound_title', true));
    $sound_artists = array(get_post_meta(get_the_ID(), 'sound_artist', true));
    $spotify_links = array(get_post_meta(get_the_ID(), 'sound_spotify_link', true));

    // Retrieve additional album covers, titles, artists, and Spotify links from post meta using a loop
    for ($i = 2; $i <= 5; $i++) {
        $album_cover = get_post_meta(get_the_ID(), 'sound_album_cover_' . $i, true);
        $sound_title = get_post_meta(get_the_ID(), 'sound_title_' . $i, true);
        $sound_artist = get_post_meta(get_the_ID(), 'sound_artist_' . $i, true);
        $spotify_link = get_post_meta(get_the_ID(), 'sound_spotify_link_' . $i, true);

        // Add the retrieved data to the respective arrays if it's not empty
        if (!empty($album_cover)) {
            $album_covers[] = $album_cover;
            $sound_titles[] = $sound_title;
            $sound_artists[] = $sound_artist;
            $spotify_links[] = $spotify_link;
        }
    }

    // If there's no data, return an empty string without outputting the carousel
    if (empty($album_covers)) {
        return '';
    }

    // Calculate the number of album covers and determine if looping is required
    $album_covers_count = count($album_covers);
    $loop = $album_covers_count > 3;

    // Set the carousel options for the Owl Carousel
    $carouselOptions = array(
        'stagePadding' => 50,
        'loop' => $loop,
        'margin' => 15,
        'nav' => true,
        'navText' => array(
            "<img src='https://oneplayground.com.au/wp-content/uploads/2022/11/trainers-left.png' alt='Prev' class='owl-prev owl-custom-prev'>",
            "<img src='https://oneplayground.com.au/wp-content/uploads/2022/11/trainers-right.png' alt='Next' class='owl-next owl-custom-next'>"
        ),
        'responsive' => array(
            0 => array(
                'items' => 1,
                'stagePadding' => 0
            ),
            480 => array(
                'items' => 2,
                'stagePadding' => 0
            ),
            768 => array(
                'items' => 2.5,
                'stagePadding' => 0
            ),
            981 => array(
                'items' => 3.5,
                'stagePadding' => 0
            )
        ),
        'onInitialized' => 'owlCarouselInitialized'
    );

    // Start output buffering to capture the HTML output
    ob_start();
    ?>
    <div class="owl-carousel sounds-carousel">
        <?php foreach ($album_covers as $index => $album_cover): ?>
            <!-- Output each album cover with its details -->
            <div class="image-container">
                <a href="<?php echo esc_url($spotify_links[$index]); ?>" target="_blank">
                    <img src="<?php echo esc_url($album_cover); ?>" class="sounds-images">
                </a>
                <div class="sound-details-container">
                    <div class="sound-details-wrapper">
                        <?php if (!empty($sound_titles[$index])): ?>
                            <p class="sound-title"><?php echo esc_html($sound_titles[$index]); ?></p>
                        <?php endif; ?>

                        <?php if (!empty($sound_artists[$index])): ?>
                            <p class="sound-artist"><?php echo esc_html($sound_artists[$index]); ?></p>
                        <?php endif; ?>
                    </div>
                    <!--<img src="https://oneplayground.com.au/wp-content/uploads/2022/11/play-button.png" class="play-button">-->
                    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/play-button.png" class="sounds-play-button" alt="Sounds Play Button">
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
    // Function called when the Owl Carousel is initialized
    function owlCarouselInitialized(event) {
        $('.owl-custom-prev').click(function() {
            // Trigger the previous slide transition
            $('.sounds-carousel').trigger('prev.owl.carousel');
        });
        $('.owl-custom-next').click(function() {
            // Trigger the next slide transition
            $('.sounds-carousel').trigger('next.owl.carousel');
        });
    }

    // Wait for the document to be ready and initialize the Owl Carousel with the defined options
    jQuery(document).ready(function($) {
        var carouselOptions = <?php echo json_encode($carouselOptions); ?>;
        carouselOptions.loop = <?php echo $loop ? 'true' : 'false'; ?>;
        $('.sounds-carousel').owlCarousel(carouselOptions);
    });
    </script>
    <?php
    // Return the captured HTML output after clearing the output buffer
    return ob_get_clean();
}
add_shortcode('owl_carousel', 'owl_carousel_shortcode');






//************************************************************************************** Testimonial Carousel *****************************************************************************************

function carousel_testimonial_shortcode($atts) {
	ob_start();
	?>
	<div class="testimonial-slider">
		<div class="testimonial-carousel">
			<div class="testimonial_slider testimonial_slider_trainers">
				<div class="owl-carousel testimonial_carousel">
					<?php
					$client_fields = get_post_meta(get_the_ID(), 'client_fields', true);

					if (!empty($client_fields)) {
						foreach ($client_fields as $field) {
							$client_name = esc_html($field['client_name']);
							$comment = esc_html($field['comment']);

							if (!empty($client_name)) {
								?>
								<div class="testimonial-item">
									<div class="slider__card slider__card--active">
										<p class="client-name-testimonial"><?php echo $client_name; ?></p>
										<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/stars.png" class="review_star_image" alt="Review Star Image">
										<div class="comment-testimonial-wrapper">
											<?php if (!empty($comment)) : ?>
												<p class="comment-testimonial"><?php echo $comment; ?></p>
											<?php endif; ?>
										</div>
									</div>
								</div>
								<?php
							}
						}
					} else {
						?>
						<img src="https://akashint.wpengine.com/wp-content/uploads/2023/04/default-event-image.jpg" class="no-featured-image">
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
	<script>
		jQuery(document).ready(function($) {
			$('.testimonial_carousel').owlCarousel({
				loop: true,
				margin: 10,
				smartSpeed: 450,
				autoplay: false,
				nav: true,
				navText: ["<img src='https://oneplayground.com.au/wp-content/uploads/2022/11/trainers-left.png' alt='Prev' class='owl-prev'>", "<img src='https://oneplayground.com.au/wp-content/uploads/2022/11/trainers-right.png' alt='Next' class='owl-next'>"],
				responsiveClass: true,
				responsive: {
					0: {
						items: 1,
						nav: true
					},
					700: {
						items: 2,
						nav: true
					},
					980: {
						items: 2,
						nav: true
					}
				},
				onInitialized: function(event) {
					rivew_animation(event);
				},
				onTranslated: function(event) {
					rivew_animation(event);
				},
			});
		});

		function rivew_animation(event) {
			var parent = $(event.target).closest(".testimonial_carousel");
			$(parent).find(".tilt_left").removeClass("tilt_left");
			$(parent).find(".tilt_right").removeClass("tilt_right");

			var activeIndex = event.item.index;
			var items = $(event.target).find(".owl-item");
			var prev = items.eq(activeIndex - 1);
			var next = items.eq(activeIndex + 1);

			var activeItem = items.eq(activeIndex);
			activeItem.removeClass("tilt_left");
			activeItem.removeClass("tilt_right");

			if (prev.length) {
				prev.removeClass("tilt_right");
				prev.addClass("tilt_left");
			}

			if (next.length) {
				next.removeClass("tilt_left");
				next.addClass("tilt_right");
			}
		}
	</script>
	<?php
	return ob_get_clean();
}
add_shortcode('testimonial_carousel', 'carousel_testimonial_shortcode');


//*****************************************************************************************************************
// Register the shortcode for the display mobile footer with toggle module
// [custom_menu menu="main-menu"]
function custom_menu_shortcode($atts) {
    // Extract shortcode attributes
    $atts = shortcode_atts(array(
        'menu' => '',
    ), $atts);

    // Retrieve the menu by slug or ID
    $menu = wp_nav_menu(array(
        'menu' => $atts['menu'],
        'echo' => false,
    ));

    return $menu;
}
add_shortcode('custom_menu', 'custom_menu_shortcode');
