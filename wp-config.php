<?php
/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa usar o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do banco de dados
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Configurações do banco de dados - Você pode pegar estas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define( 'DB_NAME', 'db-plugin' );

/** Usuário do banco de dados MySQL */
define( 'DB_USER', 'root' );

/** Senha do banco de dados MySQL */
define( 'DB_PASSWORD', '' );

/** Nome do host do MySQL */
define( 'DB_HOST', 'localhost' );

/** Charset do banco de dados a ser usado na criação das tabelas. */
define( 'DB_CHARSET', 'utf8mb4' );

/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define( 'DB_COLLATE', '' );

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para invalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '`I,Ce>%,OTq_!42C?7WtsZF1c1sKq]wl-uUi@yj/P;D;aghEI}bY{i6ab{EO7Tku' );
define( 'SECURE_AUTH_KEY',  's4!j@S=iiXU*I C}N+upEzJsast~6lTP .!kU!p17<_{Ib:U@*I(?e=EZXJ(r!?A' );
define( 'LOGGED_IN_KEY',    'm_d/a&kE*0pCUV5 `;Q0R-rwj@_XxF[eJnq&x4~9i4qFXfx#w]~FiP^!0^)7&jhk' );
define( 'NONCE_KEY',        'R6|/r-`[h}(&R/7^jR<6@QE&T(|~M Pj[;ggouNT^r0dP2Q,67 dq*HH>Q1PyX+$' );
define( 'AUTH_SALT',        'jBUcp}O135{6ux-8lR8~J$65<@Mc{5s&:}D2}+~Hv^tbA5b[/AwMg Ag?pXO0iD#' );
define( 'SECURE_AUTH_SALT', '_ +`4[WP_ij(jRH|ZD7<5mH~56@e(WHoD@vM0X:OZ<-Gi}>6]<i2MAENBV>`5-XZ' );
define( 'LOGGED_IN_SALT',   'b=.b%/[-{Hjww9T>/72j1&(TP!h%v=9tGBH=!<xPhKPRQ50HT!b4QB1Cq5*.sd4F' );
define( 'NONCE_SALT',       'jgCyp13:,q;yWn=_<4brDJCmSB]}vBMoSZo=|1F_,A;;i -uCBKs51uF4mm*{Jdd' );

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * um prefixo único para cada um. Somente números, letras e sublinhados!
 */
$table_prefix = 'wp_';

/**
 * Para desenvolvedores: Modo de debug do WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Adicione valores personalizados entre esta linha até "Isto é tudo". */



/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Configura as variáveis e arquivos do WordPress. */
require_once ABSPATH . 'wp-settings.php';
