<?php
/**
 * @file
 * Contains theme override functions and preprocess functions for the theme.
 *
 * ABOUT THE TEMPLATE.PHP FILE
 *
 *   The template.php file is one of the most useful files when creating or
 *   modifying Drupal themes. You can add new regions for block content, modify
 *   or override Drupal's theme functions, intercept or make additional
 *   variables available to your theme, and create custom PHP logic. For more
 *   information, please visit the Theme Developer's Guide on Drupal.org:
 *   http://drupal.org/theme-guide
 *
 * OVERRIDING THEME FUNCTIONS
 *
 *   The Drupal theme system uses special theme functions to generate HTML
 *   output automatically. Often we wish to customize this HTML output. To do
 *   this, we have to override the theme function. You have to first find the
 *   theme function that generates the output, and then "catch" it and modify it
 *   here. The easiest way to do it is to copy the original function in its
 *   entirety and paste it here, changing the prefix from theme_ to kogyo_.
 *   For example:
 *
 *     original: theme_breadcrumb()
 *     theme override: kogyo_breadcrumb()
 *
 *   where kogyo is the name of your sub-theme. For example, the
 *   zen_classic theme would define a zen_classic_breadcrumb() function.
 *
 *   If you would like to override any of the theme functions used in Zen core,
 *   you should first look at how Zen core implements those functions:
 *     theme_breadcrumbs()      in zen/template.php
 *     theme_menu_item_link()   in zen/template.php
 *     theme_menu_local_tasks() in zen/template.php
 *
 *   For more information, please visit the Theme Developer's Guide on
 *   Drupal.org: http://drupal.org/node/173880
 *
 * CREATE OR MODIFY VARIABLES FOR YOUR THEME
 *
 *   Each tpl.php template file has several variables which hold various pieces
 *   of content. You can modify those variables (or add new ones) before they
 *   are used in the template files by using preprocess functions.
 *
 *   This makes THEME_preprocess_HOOK() functions the most powerful functions
 *   available to themers.
 *
 *   It works by having one preprocess function for each template file or its
 *   derivatives (called template suggestions). For example:
 *     THEME_preprocess_page    alters the variables for page.tpl.php
 *     THEME_preprocess_node    alters the variables for node.tpl.php or
 *                              for node-forum.tpl.php
 *     THEME_preprocess_comment alters the variables for comment.tpl.php
 *     THEME_preprocess_block   alters the variables for block.tpl.php
 *
 *   For more information on preprocess functions and template suggestions,
 *   please visit the Theme Developer's Guide on Drupal.org:
 *   http://drupal.org/node/223440
 *   and http://drupal.org/node/190815#template-suggestions
 */


/**
 * Implementation of HOOK_theme().
 */
function kogyo_theme(&$existing, $type, $theme, $path) {
  $hooks = zen_theme($existing, $type, $theme, $path);
  // Add your theme hooks like this:
  /*
  $hooks['hook_name_here'] = array( // Details go here );
  */
  // @TODO: Needs detailed comments. Patches welcome!
  return $hooks;
}

/**
 * Override or insert variables into all templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered (name of the .tpl.php file.)
 */
/* -- Delete this line if you want to use this function
function kogyo_preprocess(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the page templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("page" in this case.)
 */
function kogyo_preprocess_page(&$vars, $hook) {
  global $base_path;
  $path = $base_path . drupal_get_path('theme', 'kogyo');
  $vars['header_image'] = $path . '/images/kogyo/kogyo_banner.jpg';

  // get the disclaimer message
  $vars['disclaimer_message'] = kogyo_disclaimer();
  
  // add subtitle if available
  $node = $vars['node'];
  
  if (isset($node) AND !empty($node->field_subtitle[0]['value'])) {
    $vars['title'] .= '<br />' . '<span class="subtitle">&#x201C;' . $node->field_subtitle[0]['value'] . '&#x201D;</span>';
  }
   
    
/*   dsm($vars); */


  // To remove a class from $classes_array, use array_diff().
  //$vars['classes_array'] = array_diff($vars['classes_array'], array('class-to-remove'));
}

/**
 * Override or insert variables into the node templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("node" in this case.)
 */
/* -- Delete this line if you want to use this function
function kogyo_preprocess_node(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');

  // Optionally, run node-type-specific preprocess functions, like
  // kogyo_preprocess_node_page() or kogyo_preprocess_node_story().
  $function = __FUNCTION__ . '_' . $vars['node']->type;
  if (function_exists($function)) {
    $function($vars, $hook);
  }
}
// */

/**
 * Override or insert variables into the comment templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("comment" in this case.)
 */
/* -- Delete this line if you want to use this function
function kogyo_preprocess_comment(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the block templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
/* -- Delete this line if you want to use this function
function kogyo_preprocess_block(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

/*
 * Hardcoded disclaimer message
 */
function kogyo_disclaimer() {
  
  $output = '<div class="disclaimer">';

  $output .= '<a href="http://www.library.pitt.edu/" class="uls" title="University Library System"></a>'; 

  
  $output .= '<p class="copyright">';  
  $output .= '<strong>' . t('Copyright') . ' &copy; ' . date("Y") . '</strong>';  
  $output .= ' ' . t('Hosted by the <a href="!DRL" title="">Digital Research Library</a> within the <a href="!ULS" title="University Library System">University Library System</a> at the <a href="!UPITT" title="University of Pittsburgh">University of Pittsburgh</a>.', array('!DRL' => 'http://www.library.pitt.edu/libraries/drl/', '!ULS' => 'http://www.library.pitt.edu/', '!UPITT' => 'http://www.pitt.edu/')); 
//  $output .= '';  
  $output .= '</p>';  
  
  $output .= '<p class="disclaimer">';
  $output .= t('The University of Pittsburgh owns the physical material presented on this website. We provide access to the digital images for personal, noncommercial, educational and research purposes only. Without written permission from the University of Pittsburgh stating otherwise, prohibited uses include, but are not limited to systematic downloading of images using robots, scripts, or other software programs; commercial use and resale of the images; or redistribution, publication or retransmission of the images beyond what is allowed by the U.S. copyright code. The University of Pittsburgh holds the copyright to most of the images.');  
  $output .= '</p>';  
 
  $output .= '</div>';
  
  return $output;
}
