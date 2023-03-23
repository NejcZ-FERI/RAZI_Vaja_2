<?php
function call($controller, $action) {
  require_once('controllers/' . $controller . '_controller.php');
  require_once('models/' . $controller . '.php');

  $o = $controller . "_controller";
  $controller = new $o;

  $controller->{$action}();
}

$controllers = array(
  'users' => ['index', 'create', 'add', 'edit', 'update', 'delete', 'error']
);

if (array_key_exists($controller, $controllers) && in_array($action, $controllers[$controller])) {
  	call($controller, $action);
} else {
	call('users', 'error');
}
