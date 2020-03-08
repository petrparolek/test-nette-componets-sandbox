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
			$services = $this->context->findByType(IForm::class);
			foreach ($services as $serviceName) {
				$service = $this->context->getService($serviceName);

				$classPossibilities[] = get_class($service);
			}

			$classPossibilities = array_unique($classPossibilities);

			$classPossibilities = array_reverse($classPossibilities);

			foreach ($classPossibilities as $class) {
				if (strpos($class, $ucname)) {
					if (class_exists($class)) {
						$component = $this->context->createInstance($class, $args);
						$this->context->callInjects($component);
					}
				}
			}
		}

		if (!$component instanceof IComponent) {
			throw new Nette\UnexpectedValueException("Automatic creation component did not return or create the desired component. Component name: " . $name);
		}

		return $component;
	}
}
