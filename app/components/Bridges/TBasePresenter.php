<?php

namespace App\Components\Bridges;

use Nette\ComponentModel\IComponent;
use Tracy\Debugger;

trait TBasePresenter
{

	protected function createComponent($name)
	{
		$component = parent::createComponent($name);

		// pokud se nepodari najit tovarnicku na komponentu, zkusime autoload dle jmena
		if (!$component instanceof IComponent) {
			$componentFactory = $this->getControlFactory();
			$component = $componentFactory->create($this, $name);

			Debugger::barDump($this, 'this');
			Debugger::barDump($name, 'name');
			Debugger::barDump($component, 'comopnent');
		}

		return $component;
	}

	public function getControlFactory()
	{
		return $this->context->getByType('\\App\\Components\\ControlFactory');
	}
}
