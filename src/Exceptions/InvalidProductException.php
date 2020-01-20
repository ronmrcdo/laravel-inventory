<?php

namespace Ronmrcdo\Inventory\Exceptions;

use Exception;

class InvalidProductException extends Exception
{
	public function report()
	{
		logger('Invalid Product');
	}
}