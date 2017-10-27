<?php

use App\Factories\Validation;

$container['validator'] = function($c){
	return new Validation($c);
};
