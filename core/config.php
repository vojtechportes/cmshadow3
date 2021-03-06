<?php

if (isset($_SERVER['HTTPS'])) {
	define('SERVER_PROTOCOL', 'https');
} else {
	define('SERVER_PROTOCOL', 'http');
}

define('BASE_PATH', '/');
define('ADMIN_OUTPUT', 'admin');
define('PRODUCTION_OUTPUT', 'production');
define('DEFAULT_OUTPUT', 'default-html');
define('DEFAULT_FORM_ROW_OUTPUT', 'default-html');
define('DEFAULT_CORE_PATH', './core/');
define('DEFAULT_TEMPLATE_PATH', './core/templates/');
define('DEFAULT_STRINGTABLE_PATH', './core/stringtable/');
define('DEFAULT_ASSETS_PATH', './assets/');
define('DEFAULT_CLASS_PATH', './core/class/');
define('DEFAULT_MODULE_PATH', './core/modules/');
define('DEFAULT_LESS_PATH', 'core/source/less/bootstrap.less');
define('DEFAULT_CSS_PATH', 'assets/admin/style/css/bootstrap.css');

define('DEFAULT_ERROR_FORM_VALIDATION_REQUIRED', 'This field is required.');
define('DEFAULT_ERROR_FORM_VALIDATION_MINLENGTH', 'Minimal length is %s.');
define('DEFAULT_ERROR_FORM_VALIDATION_MAXLENGTH', 'Maximal length is %s.');
define('DEFAULT_ERROR_FORM_VALIDATION_PATTERN', 'This field has to match pattern "%s".');
define('DEFAULT_ERROR_FORM_VALIDATION_EQUALTO', 'This fields value has to be equal to field "%s".');
define('DEFAULT_ERROR_FORM_VALIDATION_FORGERY', 'Sending this form was considered as insecure. If you are sure this is an error, please contact system administrator.');
define('DEFUALT_ERROR_DB_CONNECTION', 'Database conection was not established.');

define('DEFAULT_LOGIN_ATTEMPS', 9);
define('DEFAULT_USER_GROUP', 4);

define('DB_HOST', 'localhost');
define('DB_USER_NAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'CMShadow3');
define('DB_PREFIX', 'T_');

define('HIEARCHY', './core/hiearchy.php');
define('TEMPLATE', './core/template.php');

define('ADMIN_PATH', '/admin/');
define('LOGIN_PATH', '/admin/login/');

define('LIMIT_OFFSET', 0);
define('LIMIT_CNT', 20);
?>