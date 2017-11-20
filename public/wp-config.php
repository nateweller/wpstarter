<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'oIaHJLJbFlHHraC53Ai+VMayw8W+iUA8LbdRxbJIiahAR5PasMo2i6yaiNSgwBA3ybXPS2kGiKhNlqxb1tfHiw==');
define('SECURE_AUTH_KEY',  'U48RtDZfpGoZZzIWyTJqjhhXjuhGMGWzMw1Jdbz/PlIkrGfAtIEghKIElMsuG3I7hUlzOB5lUJZe0f7DfFg+WA==');
define('LOGGED_IN_KEY',    '3KDOC7AkeEhtBle5yhXJut6VnfBcHdp6iXoKpA53G+zyKRb8TpAqpmAs0g2SgvGyci0v7H4d9yJ5dPTE2LxPrA==');
define('NONCE_KEY',        'y5C5rt3OrBjxTozSKOYtjWd05eQjkrS6goXmHzJ8EgdfZu+Y9lNCkVfHmc4VO+GmdmMnPW153/VclKv45Oedgg==');
define('AUTH_SALT',        'xjZBtK4npi5nEcaYHpRW+K1SQJaC8dR+H7PpBfBl7xwTiX0Tew26wnV12/Kl4OarD7OWWHJj4Y0tETCsgLcamA==');
define('SECURE_AUTH_SALT', 'GpPmYTVU9+tw5ZrJQNHEgEZw/+kFHdHAposauujPr6IjodnUlAY0aewQv0jTRaB2D11lRwHJOerqol0Yolrwqg==');
define('LOGGED_IN_SALT',   'wPjl23tRj59xQCyAqyzN91Ruxdciexr8BSgev+l+c5Tr4m8K5JaZm8TpVPH4yuNSsaAdW1He6klRmxPU6HZD0g==');
define('NONCE_SALT',       'LmhPCruIN41NaBg14dKCp+ANrrAojkvWJ6We+2Ijk3YghDm3xTIUHFknx6gZ5ee/kBz7LXJFpmTvJNTncNYeIQ==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';





/* Inserted by Local by Flywheel. See: http://codex.wordpress.org/Administration_Over_SSL#Using_a_Reverse_Proxy */
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
	$_SERVER['HTTPS'] = 'on';
}

/* Inserted by Local by Flywheel. Fixes $is_nginx global for rewrites. */
if (strpos($_SERVER['SERVER_SOFTWARE'], 'Flywheel/') !== false) {
	$_SERVER['SERVER_SOFTWARE'] = 'nginx/1.10.1';
}
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
