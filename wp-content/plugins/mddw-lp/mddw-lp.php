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

add_filter( 'template_include', 'meu_plugin_template_include' );

// Função para registrar metabox
function meu_plugin_add_meta_box() {
    add_meta_box(
        'meu_plugin_meta_box',
        'Detalhes da Landing Page',
        'meu_plugin_meta_box_callback',
        'landing_page',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'meu_plugin_add_meta_box' );

// Callback para mostrar campos da metabox
function meu_plugin_meta_box_callback( $post ) {
    wp_nonce_field( 'meu_plugin_save_meta_box_data', 'meu_plugin_meta_box_nonce' );

    $values = get_post_meta( $post->ID, '_meu_plugin_meta_data', true );
    $values = is_array( $values ) ? $values : array( array( 'texto' => '', 'url' => '' ) );

    echo '<div id="meu-plugin-metabox-container">';
    foreach ( $values as $index => $value ) {
        echo '<div class="meu-plugin-meta-box">';
        echo '<label for="meu_plugin_texto_' . $index . '">Texto:</label>';
        echo '<input type="text" id="meu_plugin_texto_' . $index . '" name="meu_plugin_texto[]" value="' . esc_attr( $value['texto'] ) . '" size="25" />';
        echo '<label for="meu_plugin_url_' . $index . '">URL:</label>';
        echo '<input type="url" id="meu_plugin_url_' . $index . '" name="meu_plugin_url[]" value="' . esc_attr( $value['url'] ) . '" size="25" />';
        echo '<button type="button" class="remove-meta-box">Remover</button>';
        echo '</div>';
    }
    echo '</div>';
    echo '<button type="button" id="add-meta-box">Adicionar Novo</button>';
}

// Função para salvar os dados da metabox
function meu_plugin_save_meta_box_data( $post_id ) {
    if ( ! isset( $_POST['meu_plugin_meta_box_nonce'] ) ) {
        return;
    }

    if ( ! wp_verify_nonce( $_POST['meu_plugin_meta_box_nonce'], 'meu_plugin_save_meta_box_data' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( ! isset( $_POST['meu_plugin_texto'] ) || ! isset( $_POST['meu_plugin_url'] ) ) {
        return;
    }

    $texts = $_POST['meu_plugin_texto'];
    $urls = $_POST['meu_plugin_url'];

    $values = array();

    for ( $i = 0; $i < count( $texts ); $i++ ) {
        if ( ! empty( $texts[$i] ) || ! empty( $urls[$i] ) ) {
            $values[] = array(
                'texto' => sanitize_text_field( $texts[$i] ),
                'url'   => esc_url_raw( $urls[$i] ),
            );
        }
    }

    update_post_meta( $post_id, '_meu_plugin_meta_data', $values );
}
add_action( 'save_post', 'meu_plugin_save_meta_box_data' );

// Adicionando scripts e estilos
function meu_plugin_admin_scripts() {
    global $post_type;
    if ( 'landing_page' == $post_type ) {
        wp_enqueue_script( 'meu-plugin-script', plugin_dir_url( __FILE__ ) . 'meu-plugin-script.js', array( 'jquery' ), null, true );
        wp_enqueue_style( 'meu-plugin-style', plugin_dir_url( __FILE__ ) . 'meu-plugin-style.css' );
    }
}
add_action( 'admin_enqueue_scripts', 'meu_plugin_admin_scripts' );