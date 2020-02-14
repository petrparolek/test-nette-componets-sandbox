<?php

namespace App\Components;

use Nette;
use Nette\ComponentModel\IComponent;

class ControlFactory
{

	/**
	 * @var Nette\DI\Container
	 */
	protected $context;

	public function __construct(Nette\Di\Container $context)
	{
		$this->context = $context;
	}

	public function create(IComponent $parentComponent, $name, array $args = [])
	{
		$component = NULL;

		$ucname = ucfirst($name);

		if ($ucname !== $name) {
			$classPossibilities = [];

			$presenter = $parentComponent->presenter->getName();
			$modulesArr = explode(':', trim($presenter, ':'));
			array_pop($modulesArr);

			$classPossibilities = ['App\\Components\\' . $ucname];
			$prev = '';

			//auto registration of controls
			foreach ($modulesArr as $module) {
				$prev .= '\\' . $module . 'Module';

				$classPossibilities[] = 'App' . $prev . '\Components\\' . $ucname;
			}

			//manual registration of registered controls as service implemented by App\Components\IForm
			if ($this->context->findByType(IForm::class)) {
				$instance = $this->context->getByType(IForm::class);
				$className = get_class($instance);

				$classPossibilities[] = $className;
			}

			$classPossibilities = array_unique($classPossibilities);

			$classPossibilities = array_reverse($classPossibilities);

			foreach ($classPossibilities as $class) {
				if (class_exists($class, true)) {
					$component = $this->context->createInstance($class, $args);
					$this->context->callInjects($component);
					break;
				}
			}
		}

		return $component;
	}
}
