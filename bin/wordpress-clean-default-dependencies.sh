#!/bin/bash

PROJECT_BASE_PATH=$@

__term_found_in_composer() {
    grep "$1" $PROJECT_BASE_PATH/composer.json >> /dev/null
}

_wordpress_plugin_exists_in_composer() {
    __term_found_in_composer "\"wpackagist-plugin/$1\""
}

_wordpress_theme_exists_in_composer() {
    __term_found_in_composer "\"wpackagist-theme/$1\""
}

# Remove default WordPress plugins
if ! _wordpress_plugin_exists_in_composer "akismet"; then
    rm -rf $PROJECT_BASE_PATH/wordpress/wp-content/plugins/akismet
fi

rm -f $PROJECT_BASE_PATH/wordpress/wp-content/plugins/hello.php

# Remove default WordPress themes
if ! _wordpress_theme_exists_in_composer "twentynineteen"; then
    rm -rf $PROJECT_BASE_PATH/wordpress/wp-content/themes/twentynineteen
fi
if ! _wordpress_theme_exists_in_composer "twentytwenty"; then
    rm -rf $PROJECT_BASE_PATH/wordpress/wp-content/themes/twentytwenty
fi
if ! _wordpress_theme_exists_in_composer "twentytwentyone"; then
    rm -rf $PROJECT_BASE_PATH/wordpress/wp-content/themes/twentytwentyone
fi
