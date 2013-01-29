<?php defined('SYSPATH') OR die('No direct script access.');

Route::set('pets', 'pets(/<page>)', array('page' => '[0-9]+'))
	->defaults(array(
		'directory'  => 'Pet',
		'controller' => 'Index',
		'action'     => 'index',
	));

Route::set('pet.adopt', 'pet/adopt(/<page>)', array('page' => '[0-9]+'))
	->defaults(array(
		'directory'  => 'Pet',
		'controller' => 'Adopt',
		'action'     => 'index',
	));

Route::set('pet.create', 'pet/create')
	->defaults(array(
		'directory'  => 'Pet',
		'controller' => 'Create',
		'action'     => 'index',
	));

Route::set('pet', 'pet/<name>', array('name' => '[a-zA-Z0-9-_]+'))
	->defaults(array(
		'directory'  => 'Pet',
		'controller' => 'Profile',
		'action'     => 'index',
	));


Route::set('pet.admin.index', 'admin/pet')
	->defaults(array(
		'directory'  => 'Admin',
		'controller' => 'Pet',
		'action'     => 'index',
));
Route::set('pet.admin.search', 'admin/pet/search')
	->defaults(array(
		'directory'  => 'Admin',
		'controller' => 'Pet',
		'action'     => 'search',
));
Route::set('pet.admin.specie.retrieve', 'admin/pet/specie/retrieve')
	->defaults(array(
		'directory'  => 'Admin/Pet',
		'controller' => 'Specie',
		'action'     => 'retrieve',
));
Route::set('pet.admin.specie.delete', 'admin/pet/specie/delete')
	->defaults(array(
		'directory'  => 'Admin/Pet',
		'controller' => 'Specie',
		'action'     => 'delete',
));
Route::set('pet.admin.specie.save', 'admin/pet/specie/save')
	->defaults(array(
		'directory'  => 'Admin/Pet',
		'controller' => 'Specie',
		'action'     => 'save',
));
Route::set('pet.admin.specie.index', 'admin/pet/specie')
	->defaults(array(
		'directory'  => 'Admin/Pet',
		'controller' => 'Specie',
		'action'     => 'index',
));
Route::set('pet.admin.colour.retrieve', 'admin/pet/colour/retrieve')
	->defaults(array(
		'directory'  => 'Admin/Pet',
		'controller' => 'Colour',
		'action'     => 'retrieve',
));
Route::set('pet.admin.colour.delete', 'admin/pet/colour/delete')
	->defaults(array(
		'directory'  => 'Admin/Pet',
		'controller' => 'Colour',
		'action'     => 'delete',
));
Route::set('pet.admin.colour.save', 'admin/pet/colour/save')
	->defaults(array(
		'directory'  => 'Admin/Pet',
		'controller' => 'Colour',
		'action'     => 'save',
));
Route::set('pet.admin.colour.index', 'admin/pet/colour')
	->defaults(array(
		'directory'  => 'Admin/Pet',
		'controller' => 'Colour',
		'action'     => 'index',
));
	
//Add link to manage forums in admin
Event::listen('admin.nav_list', function(){
	return array(
			'title' => 'Pet',
			'link'  => URL::site('admin/pet'),
			'icon'  => 'icon-picture'
	);
});
