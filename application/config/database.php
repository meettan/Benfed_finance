<?php
defined('BASEPATH') or exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => 'localhost',
	'username' => 'root',
	'password' => 'SynergicWeb@2020',
	'database' => 'benfed_fin',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

	$db['seconddb'] = array(
		'dsn'	   => '',
	'hostname' => 'localhost',
	'username' => 'root',
	'password' => 'SynergicWeb@2020',
	'database' => 'benfed_fertilizer',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
		//'dsn'	   => '',
		//'hostname' => 'localhost',
		//'username' => 'fert_test',
		//'password' => '@k66oEb7@2014#Qa',
		//'database' => 'fert_test',
		//'dbdriver' => 'mysqli',
		//'dbprefix' => '',
		//'pconnect' => FALSE,
		//'db_debug' => (ENVIRONMENT !== 'production'),
		//'cache_on' => FALSE,
		//'cachedir' => '',
		//'char_set' => 'utf8',
		//'dbcollat' => 'utf8_general_ci',
		//'swap_pre' => '',
		//'encrypt' => FALSE,
		//'compress' => FALSE,
		//'stricton' => FALSE,
		//'failover' => array(),
		//'save_queries' => TRUE
	);
