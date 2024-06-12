<?php

/**
 * Plugin Name:       MDDWeb Landing Page
 * Description:       Plugin de criação de Landing Pages.
 * Version:           0.1.0
 * Requires at least: 5.2
 * Requires PHP:      7.4
 * Author:            Denis Alencar
 * Author URI:        https://github.com/Denismapll
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       mddw-lp
 * Domain Path:       /languages
 *
 * @package         Mddweb Landing Page
 */

// Your code starts here.

defined('ABSPATH') || exit;

class Plugin
{
  public function activate()
  {
    flush_rewrite_rules();
  }
  public function deactivate()
  {
    flush_rewrite_rules();
  }
}

if (class_exists('Plugin')) {
  define('LPT_PLUGIN_FILE', __FILE__);

  $plugin = new Plugin();
}

register_activation_hook(LPT_PLUGIN_FILE, array($plugin, 'activate'));
register_deactivation_hook(LPT_PLUGIN_FILE, array($plugin, 'deactivate'));

function meu_plugin_create_post_type()
{
  $labels = array(
    'name'               => _x('Landing Pages', 'post type general name'),
    'singular_name'      => _x('Landing Page', 'post type singular name'),
    'menu_name'          => _x('Landing Pages', 'admin menu'),
    'name_admin_bar'     => _x('Landing Page', 'add new on admin bar'),
    'add_new'            => _x('Adicionar Nova', 'landing page'),
    'add_new_item'       => __('Adicionar Nova Landing Page'),
    'new_item'           => __('Nova Landing Page'),
    'edit_item'          => __('Editar Landing Page'),
    'view_item'          => __('Ver Landing Page'),
    'all_items'          => __('Todas as Landing Pages'),
    'search_items'       => __('Procurar Landing Pages'),
    'parent_item_colon'  => __('Landing Page Pai:'),
    'not_found'          => __('Nenhuma Landing Page encontrada.'),
    'not_found_in_trash' => __('Nenhuma Landing Page encontrada na lixeira.')
  );

  $args = array(
    'labels'             => $labels,
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'rewrite'            => array('slug' => 'lp'),
    'capability_type'    => 'post',
    'has_archive'        => false,
    'hierarchical'       => false,
    'menu_position'      => null,
    'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments')
  );

  register_post_type('landing_page', $args);

  flush_rewrite_rules();
}

// Hook para registrar o custom post type na inicialização
add_action('init', 'meu_plugin_create_post_type');

// Função para carregar o template específico
function meu_plugin_template_include( $template ) {
  if ( is_singular('landing_page') ) {
      $plugin_template = plugin_dir_path( __FILE__ ) . 'template-landing-page.php';
      if ( file_exists( $plugin_template ) ) {
          return $plugin_template;
      }
  }
  return $template;
}
add_filter( 'template_include', 'meu_plugin_template_include' );