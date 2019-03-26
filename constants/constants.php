<?php

defined('DS') OR define('DS', '/');

defined('REFRESH_TOKEN_PREFIX') OR define("REFRESH_TOKEN_PREFIX", "oauth2_ort_");

defined('EXP_ACCESS_TOKEN') OR define("EXP_ACCESS_TOKEN", 60 * 60 * 2); // 2 Jam
defined('EXP_REFRESH_TOKEN') OR define("EXP_REFRESH_TOKEN", 60 * 60 * 24 * 7); // 7 Hari

defined('JWT_ALGORITHM') OR define("JWT_ALGORITHM", "HS256");
defined('TOKEN_TYPE') OR define("TOKEN_TYPE", "Bearer");