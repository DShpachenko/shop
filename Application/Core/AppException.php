<?php

namespace Core;

class AppException extends \Exception
{
    private $notify;

	public function __construct(string $notify)
	{
		\Exception::__construct($notify);

        logging($notify);
		$this->notify = $notify;
	}

	public function getNotify() : string
	{
		return $this->notify;
	}
}