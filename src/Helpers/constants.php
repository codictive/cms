<?php

if (! defined('STATIC_DIR')) {
    define('STATIC_DIR', sprintf('%s/../../public/static', __DIR__));
}

const UNIQUE_COL_SIZE = 150;

const AUTH_SESSION_TOKEN_KEY  = 'auth_token';
const AUTH_SESSION_MOBILE_KEY = 'auth_mobile';

const CACHE_KEY_LOCATIONS  = 'locations_hierarchical';
const CACHE_KEY_CATEGORIES = 'categories_hierarchical';
