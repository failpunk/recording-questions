<?php


class fpEvent
{

	static private $map = array();

	static public function init()
	{
		$events = sfConfig::get('app_observer', array());

		foreach ($events as $on => $handlers)
		{
			foreach ($handlers as $handler)
			{
				if(class_exists($handler))
				{
					self::on($on, new $handler());
				}
				else
				{
					throw new Exception('Event handler not found');
				}
			}

		}

	}

	static public function on($name, fpEventHandler $handler )
	{
		self::$map[$name][] = $handler;
	}

	static public function fire($name)
	{
		$args = array_slice(func_get_args(), 1);

		if(isset(self::$map[$name]))
		{
			foreach (self::$map[$name] as $handler)
			{
				$handler->init($args);
				$handler->execute();
			}

		}
	}

}


