<?php

$str = <<< TEMPLATE
<?php 

use Yaf\Controller_Abstract;

class %sController extends Controller_Abstract
{
	public function indexAction()
	{
		//here to write request;
		//here to call business logic;
		//here to write response;
	}
}

TEMPLATE;

return $str;