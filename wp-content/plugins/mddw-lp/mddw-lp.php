<?php

/**
 * Plugin Name:       MDDWeb Landing Page
 * Description:       Plugin de criação de Landing Pages.
 * Version:           0.1.0
 * Requires at least: 5.2
 * Requires PHP:      7.4
 * Author:            MDD Web
 * Author URI:        https://mddweb.com.br/
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
    'rewrite'            => array('slug' => 'links'),
    'capability_type'    => 'post',
    'has_archive'        => false,
    'hierarchical'       => false,
    'menu_position'      => null,
    'supports'           => array('title', 'thumbnail')
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

    add_meta_box(
        'meu_plugin_color_meta_box',
        'Cores da Landing Page',
        'meu_plugin_color_meta_box_callback',
        'landing_page',
        'side',
        'default'
    );

    add_meta_box(
        'meu_plugin_social_meta_box',
        'Redes Sociais',
        'meu_plugin_social_meta_box_callback',
        'landing_page',
        'side',
        'default'
    );
}
add_action( 'add_meta_boxes', 'meu_plugin_add_meta_box' );

// Callback para mostrar campos da metabox
function meu_plugin_meta_box_callback( $post ) {
    wp_nonce_field( 'meu_plugin_save_meta_box_data', 'meu_plugin_meta_box_nonce' );

    $values = get_post_meta( $post->ID, '_meu_plugin_meta_data', true );
    $values = is_array( $values ) ? $values : array( array( 'texto' => '', 'url' => '', 'imagem' => '' ) );

    echo '<div id="meu-plugin-metabox-container">';
    foreach ( $values as $index => $value ) {
        $image = isset($value['imagem']) ? $value['imagem'] : '';
        echo '<div class="meu-plugin-meta-box"><br>';
        echo '<label for="meu_plugin_texto_' . $index . '">Texto:</label><br>';
        echo '<input type="text" id="meu_plugin_texto_' . $index . '" name="meu_plugin_texto[]" value="' . esc_attr( $value['texto'] ) . '" size="25" /><br>';
        echo '<label for="meu_plugin_url_' . $index . '">URL:</label><br>';
        echo '<input type="url" id="meu_plugin_url_' . $index . '" name="meu_plugin_url[]" value="' . esc_attr( $value['url'] ) . '" size="25" /><br>';
        
        // Campo de Imagem
        echo '<label for="meu_plugin_imagem_' . $index . '">Imagem:</label><br>';
        echo '<input type="hidden" id="meu_plugin_imagem_' . $index . '" name="meu_plugin_imagem[]" value="' . esc_attr( $image ) . '" />';
        echo '<button type="button" class="upload-image-button button" data-index="' . $index . '">Selecionar Imagem</button><br>';
        echo '<div class="image-preview" id="image-preview-' . $index . '"><br>';
        if ($image) {
            echo '<img src="' . esc_url( wp_get_attachment_url( $image ) ) . '" style="max-width:100%; width: 250px;"/><br>';
        }
        echo '</div>';
        
        echo '<button type="button" class="remove-meta-box">Remover</button>';
        echo '</div>';
    }
    echo '</div>';
    echo '<button type="button" id="add-meta-box">Adicionar Novo</button>';
}




// Callback para mostrar campos de cores
function meu_plugin_color_meta_box_callback( $post ) {
    wp_nonce_field( 'meu_plugin_save_color_meta_box_data', 'meu_plugin_color_meta_box_nonce' );

    $color1 = get_post_meta( $post->ID, '_meu_plugin_color1', true );
    $color2 = get_post_meta( $post->ID, '_meu_plugin_color2', true );
    $color3 = get_post_meta( $post->ID, '_meu_plugin_color3', true );

    echo '<label for="meu_plugin_color1">Cor Primária:</label>';
    echo '<input type="color" id="meu_plugin_color1" name="meu_plugin_color1" value="' . esc_attr( $color1 ) . '" />';

    echo '<br><label for="meu_plugin_color2">Cor Secundária:</label>';
    echo '<input type="color" id="meu_plugin_color2" name="meu_plugin_color2" value="' . esc_attr( $color2 ) . '" />';

    echo '<br><br><label for="meu_plugin_color3">Cor do Texto:</label>';
    echo '<input type="color" id="meu_plugin_color3" name="meu_plugin_color3" value="' . esc_attr( $color3 ) . '" />';
}



// Callback para mostrar campos de redes sociais
function meu_plugin_social_meta_box_callback( $post ) {
    wp_nonce_field( 'meu_plugin_save_social_meta_box_data', 'meu_plugin_social_meta_box_nonce' );

    $facebook = get_post_meta( $post->ID, '_meu_plugin_facebook', true );
    $instagram = get_post_meta( $post->ID, '_meu_plugin_instagram', true );
    $linkedin = get_post_meta( $post->ID, '_meu_plugin_linkedin', true );
    $twitter = get_post_meta( $post->ID, '_meu_plugin_twitter', true );
    $whatsapp = get_post_meta( $post->ID, '_meu_plugin_whatsapp', true );
    $youtube = get_post_meta( $post->ID, '_meu_plugin_youtube', true );

    echo '<label for="meu_plugin_facebook">Facebook:</label><br>';
    echo '<input type="url" id="meu_plugin_facebook" name="meu_plugin_facebook" value="' . esc_attr( $facebook ) . '" size="25" />';
    
    echo '<br><label for="meu_plugin_instagram">Instagram:</label><br>';
    echo '<input type="url" id="meu_plugin_instagram" name="meu_plugin_instagram" value="' . esc_attr( $instagram ) . '" size="25" />';
    
    echo '<br><label for="meu_plugin_linkedin">LinkedIn:</label><br>';
    echo '<input type="url" id="meu_plugin_linkedin" name="meu_plugin_linkedin" value="' . esc_attr( $linkedin ) . '" size="25" />';
    
    echo '<br><label for="meu_plugin_twitter">Twitter:</label><br>';
    echo '<input type="url" id="meu_plugin_twitter" name="meu_plugin_twitter" value="' . esc_attr( $twitter ) . '" size="25" />';
    
    echo '<br><label for="meu_plugin_whatsapp">WhatsApp:</label><br>';
    echo '<input type="url" id="meu_plugin_whatsapp" name="meu_plugin_whatsapp" value="' . esc_attr( $whatsapp ) . '" size="25" />';
    
    echo '<br><label for="meu_plugin_youtube">YouTube:</label>';
    echo '<input type="url" id="meu_plugin_youtube" name="meu_plugin_youtube" value="' . esc_attr( $youtube ) . '" size="25" />';
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

    if ( ! isset( $_POST['meu_plugin_texto'] ) || ! isset( $_POST['meu_plugin_url'] ) || ! isset( $_POST['meu_plugin_imagem'] ) ) {
        return;
    }

    $texts = $_POST['meu_plugin_texto'];
    $urls = $_POST['meu_plugin_url'];
    $images = $_POST['meu_plugin_imagem'];

    $values = array();

    for ( $i = 0; $i < count( $texts ); $i++ ) {
        if ( ! empty( $texts[$i] ) || ! empty( $urls[$i] ) || ! empty( $images[$i] ) ) {
            $values[] = array(
                'texto' => sanitize_text_field( $texts[$i] ),
                'url'   => esc_url_raw( $urls[$i] ),
                'imagem' => intval( $images[$i] ),
            );
        }
    }

    update_post_meta( $post_id, '_meu_plugin_meta_data', $values );
}
add_action( 'save_post', 'meu_plugin_save_meta_box_data' );




function meu_plugin_save_color_meta_box_data( $post_id ) {
    if ( ! isset( $_POST['meu_plugin_color_meta_box_nonce'] ) ) {
        return;
    }

    if ( ! wp_verify_nonce( $_POST['meu_plugin_color_meta_box_nonce'], 'meu_plugin_save_color_meta_box_data' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['meu_plugin_color1'] ) ) {
        $color1 = sanitize_hex_color( $_POST['meu_plugin_color1'] );
        update_post_meta( $post_id, '_meu_plugin_color1', $color1 );
    }

    if ( isset( $_POST['meu_plugin_color2'] ) ) {
        $color2 = sanitize_hex_color( $_POST['meu_plugin_color2'] );
        update_post_meta( $post_id, '_meu_plugin_color2', $color2 );
    }

    if ( isset( $_POST['meu_plugin_color3'] ) ) {
        $color3 = sanitize_hex_color( $_POST['meu_plugin_color3'] );
        update_post_meta( $post_id, '_meu_plugin_color3', $color3 );
    }
}
add_action( 'save_post', 'meu_plugin_save_color_meta_box_data' );

// Função para salvar os dados das redes sociais
function meu_plugin_save_social_meta_box_data( $post_id ) {
    if ( ! isset( $_POST['meu_plugin_social_meta_box_nonce'] ) ) {
        return;
    }

    if ( ! wp_verify_nonce( $_POST['meu_plugin_social_meta_box_nonce'], 'meu_plugin_save_social_meta_box_data' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    $fields = array(
        'facebook' => '_meu_plugin_facebook',
        'instagram' => '_meu_plugin_instagram',
        'linkedin' => '_meu_plugin_linkedin',
        'twitter' => '_meu_plugin_twitter',
        'whatsapp' => '_meu_plugin_whatsapp',
        'youtube' => '_meu_plugin_youtube'
    );

    foreach ($fields as $field => $meta_key) {
        if ( isset( $_POST["meu_plugin_{$field}"] ) ) {
            $url = esc_url_raw( $_POST["meu_plugin_{$field}"] );
            update_post_meta( $post_id, $meta_key, $url );
        }
    }
}
add_action( 'save_post', 'meu_plugin_save_social_meta_box_data' );

// Adicionando scripts e estilos
function meu_plugin_admin_scripts() {
    global $post_type;
    if ( 'landing_page' == $post_type ) {
        wp_enqueue_script( 'meu-plugin-script', plugin_dir_url( __FILE__ ) . 'meu-plugin-script.js', array( 'jquery' ), null, true );
        wp_enqueue_style( 'meu-plugin-style', plugin_dir_url( __FILE__ ) . 'meu-plugin-style.css' );
    }
}
add_action( 'admin_enqueue_scripts', 'meu_plugin_admin_scripts' );