<?php

class recordingConfiguration extends sfApplicationConfiguration
{
	public function configure()
	{
	}

	public function initialize()
	{
		fpEvent::init();
	}
}
