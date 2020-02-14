<?php

namespace App\Components;

use Nette;
use Nette\ComponentModel\IComponent;

class FrontControlFactory
{

	protected $controlFactory;

	public function __construct(ControlFactory $controlFactory)
	{
		$this->controlFactory = $controlFactory;
	}

	public function create(IComponent $parentComponent, $name, array $args = [])
	{
		$component = $this->controlFactory->create($parentComponent, $name, $args);

		if (!$component instanceof IComponent) {
			throw new Nette\UnexpectedValueException("Automatic creation component did not return or create the desired component. Component name: " . $name);
		}

		return $component;
	}
}
