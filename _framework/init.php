<?php

// Widget Framework
require('widget_framework.php');

// Enhanced Custom Fields Framework
require('custom_fields/cf_framework.php');

// Twitter
include_once('twitter/versions-proxy.php');

// Facebook
require('facebook/facebook.php');

// Add RSS links to <head> section
add_theme_support( 'automatic-feed-links' );
