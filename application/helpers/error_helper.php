<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function show_401(){
	$exceptions =& load_class('Exceptions','core');
	$exceptions->show_401();
}

function valid_date($date) {
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}
?>
