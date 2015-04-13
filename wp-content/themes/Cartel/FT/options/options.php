<?php
// Colorset
$arrayDef = array('color1' => '', 'color2' => '','color3' => '','color4' => '','color5' => '');
if (file_exists(dirname(__FILE__) . '/colors.php'))
		$arrayDef = include ('colors.php');

// Colorset Options
$options[] = array(
					'name' => 'Main color',
					'desc' => 'Click to choise main theme color.',
					'id'   => 'fake_colorSet1',
					'std'  => $arrayDef['color1'],
					'class'   => 'color-picker',
					'type'    => 'text',
					'options' => array('rel' => ''),
);
$options[] = array('id' => 'colorset1', 'type' => 'hidden');
$options[] = array('id' => 'colorset1_opacity', 'type' => 'hidden');

$options[] = array(
					'name' => 'Secondary color',
					'desc' => 'Click to choise secondary theme color.',
					'id'   => 'fake_colorSet2',
					'std'    => $arrayDef['color2'],
					'class'  => 'color-picker',
					'type'   => 'text'
);
$options[] = array('id' => 'colorset2', 'type' => 'hidden');
$options[] = array('id' => 'colorset2_opacity', 'type' => 'hidden');

$options[] = array(
					'name' => 'Color 1',
					'desc' => 'Click to choise theme color #1.',
					'id'   => 'fake_colorSet3',
					'std'    => $arrayDef['color3'],
					'class'  => 'color-picker',
					'type'   => 'text'
);
$options[] = array('id' => 'colorset3', 'type' => 'hidden');
$options[] = array('id' => 'colorset3_opacity', 'type' => 'hidden');

$options[] = array(
					'name' => 'Color 2',
					'desc' => 'Click to choise theme color #2.',
					'id'   => 'fake_colorSet4',
					'std'    => $arrayDef['color4'],
					'class'  => 'color-picker',
					'type'   => 'text'
);
$options[] = array('id' => 'colorset4', 'type' => 'hidden');
$options[] = array('id' => 'colorset4_opacity', 'type' => 'hidden');

$options[] = array(
					'name' => 'Color 3',
					'desc' => 'Click to choise theme color #3.',
					'id'   => 'fake_colorSet5',
					'std'    => $arrayDef['color5'],
					'class'  => 'color-picker',
					'type'   => 'text'
);
$options[] = array('id' => 'colorset5', 'type' => 'hidden');
$options[] = array('id' => 'colorset5_opacity', 'type' => 'hidden');

// Colors selector
wp_register_style('jquery.minicolors.css', get_bloginfo('template_directory') . '/FT/css/jquery.minicolors.css', array(), 1);
wp_enqueue_style('jquery.minicolors.css');
wp_register_script('jquery.minicolors.min.js', get_bloginfo('template_directory'). '/FT/js/jquery.minicolors.min.js', array('jquery'), 1);
wp_enqueue_script('jquery.minicolors.min.js');

// Colors selector setting
wp_register_script('ft.colorset.js', get_bloginfo('template_directory'). '/FT/js/colorset.js', array('jquery'), 1);
wp_enqueue_script('ft.colorset.js');