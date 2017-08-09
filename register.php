<?php
 
// =============================================================================
// REGISTER.PHP
// -----------------------------------------------------------------------------
// Sets up the options to be used in the Customizer.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
// 	01. Register Options
// =============================================================================

// Register Options
// =============================================================================

function gwfc_register_customizer_options( $wp_customize ) {

	//
	// 	Font data.
	// 	1. Fonts.
	// 	2. Font weights.
	// 	3. All font weights.
	//

	$list_fonts        		= array(); // 1
	$list_font_weights 		= array(); // 2
	$webfonts_array    		= file( plugins_url( 'fonts.json' , __FILE__ ) );
	$webfonts          		= implode( '', $webfonts_array );
	$list_fonts_decode 		= json_decode( $webfonts, true );
	$list_fonts['default'] 	= 'Theme Default';
	foreach ( $list_fonts_decode['items'] as $key => $value ) {
		$item_family                     = $list_fonts_decode['items'][$key]['family'];
		$list_fonts[$item_family]        = $item_family; 
		$list_font_weights[$item_family] = $list_fonts_decode['items'][$key]['variants'];
	}

	$list_all_font_weights = array( // 3
		'100'       => __( 'Ultra Light', '__x__' ),
		'100italic' => __( 'Ultra Light Italic', '__x__' ),
		'200'       => __( 'Light', '__x__' ),
		'200italic' => __( 'Light Italic', '__x__' ),
		'300'       => __( 'Book', '__x__' ),
		'300italic' => __( 'Book Italic', '__x__' ),
		'400'       => __( 'Regular', '__x__' ),
		'400italic' => __( 'Regular Italic', '__x__' ),
		'500'       => __( 'Medium', '__x__' ),
		'500italic' => __( 'Medium Italic', '__x__' ),
		'600'       => __( 'Semi-Bold', '__x__' ),
		'600italic' => __( 'Semi-Bold Italic', '__x__' ),
		'700'       => __( 'Bold', '__x__' ),
		'700italic' => __( 'Bold Italic', '__x__' ),
		'800'       => __( 'Extra Bold', '__x__' ),
		'800italic' => __( 'Extra Bold Italic', '__x__' ),
		'900'       => __( 'Ultra Bold', '__x__' ),
		'900italic' => __( 'Ultra Bold Italic', '__x__' )
	);

	//
	// 	Tags data
	// 	1. Tags.
	//

	$list_tags = array( // 1
		'body'		=> "All (body tags)",
		'h1'		=> "Headline 1 (h1 tags)",
		'h2'		=> "Headline 2 (h2 tags)",
		'h3'		=> "Headline 3 (h3 tags)",
		'h4'		=> "Headline 4 (h4 tags)",
		'h5'		=> "Headline 5 (h5 tags)",
		'h6'		=> "Headline 6 (h6 tags)",
		'blockquote'=> "Blockquote (blockquote)",		
		'p'			=> "Paragraph (p tags)",
		'li'		=> "List (li tags)",
	);


	//
	// 	Section.
	//

	$wp_customize->add_setting( 'gwfc_customizer_section_fonts' );

	$wp_customize->add_section( 'gwfc_customizer_section_fonts', array(
		'title'    => __( 'Fonts Customizer', '__gwfc__' ),
		'description'    => __( '<strong>Note.</strong><br />Please enable tags section checkbox for activate and use Google Web Fonts on selected tags.', '__gwfc__' ),
		'priority' => 1
	));

	$i_priority = 5;

	foreach ($list_tags as $key => $value) {

		//
		//	Checkbox
		//

		$wp_customize->add_setting( 'gwfc_' . $key . '_checkbox', array(
			'transport' => 'postMessage'
		));

		$wp_customize->add_control( 'gwfc_' . $key . '_checkbox', array(
			'label' => __( 'Enable ' . $value, '__gwfc__' ),
			'section' => 'gwfc_customizer_section_fonts',
			'settings' => 'gwfc_' . $key . '_checkbox',
			'type' => 'checkbox',
			'priority' 	=> $i_priority++
		));


		/* sub title */

		$wp_customize->add_setting( 'gwfc_' . $key . '_sub_title');
		$wp_customize->add_control( 
			new gwfc_sub_title( $wp_customize, 'gwfc_' . $key . '_sub_title', array(
			'label'		=> __( $value, '__gwfc__' ),
			'section'   => 'gwfc_customizer_section_fonts',
			'settings'  => 'gwfc_' . $key . '_sub_title',
			'priority' 	=> $i_priority++ //Determines priority
		) ) );

		/* font family */

		$wp_customize->add_setting( 'gwfc_' . $key . '_font_family', array(
			'default' => 'default',
			'transport' => 'postMessage'
		));

		$wp_customize->add_control( 'gwfc_' . $key . '_font_family', array(
			'type'     => 'select',
			'label'    => __( 'Font Family', '__gwfc__' ),
			'section'  => 'gwfc_customizer_section_fonts',
			'priority' => $i_priority++,
			'choices'  => $list_fonts
		));

		/* font weight */

		$wp_customize->add_setting( 'gwfc_' . $key . '_font_weight', array(
			'default' => '400',
			'transport' => 'postMessage'
		));

		$wp_customize->add_control( 'gwfc_' . $key . '_font_weight', array(
			'type'     => 'select',
			'label'    => __( 'Font Weight', '__gwfc__' ),
			'section'  => 'gwfc_customizer_section_fonts',
			'priority' => $i_priority++,
			'choices'  => $list_all_font_weights
		));

		/* font color */

		$wp_customize->add_setting( 'gwfc_' . $key . '_font_color', array(
			'transport' => 'postMessage'
		));

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'gwfc_' . $key . '_font_color', array(
			'label'	=> __( 'Font Color', 'themename' ),
			'section' => 'gwfc_customizer_section_fonts',
			'priority' => $i_priority++,
			'settings' => 'gwfc_' . $key . '_font_color',
		)));

	}

}

add_action( 'customize_register', 'gwfc_register_customizer_options' );

