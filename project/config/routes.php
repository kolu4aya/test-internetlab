<?php
	use \Core\Route;
	
	return [
		new Route('/user/create', 'user', 'create'), 
		new Route('/user/update', 'user', 'update'), 
		new Route('/user/destroy', 'user', 'destroy'), 
		new Route('/user/auth', 'user', 'auth'), 
		new Route('/user/get/:id', 'user', 'get'), 
	];
	
