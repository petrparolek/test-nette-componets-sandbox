<?php

namespace App;

use Nette;

abstract class Control extends Nette\Application\UI\Control
{

	// implements autoloading components by name
	// lookups in namespace global and module namespace
	protected function createComponent($name)
	{
		$component = parent::createComponent($name);

		// pokud se nepodari najit tovarnicku na komponentu, zkusime autoload dle jmena
		if (!$component instanceof IComponent) {

			$componentFactory = $this->presenter->getControlFactory();

			$component = $componentFactory->create($this, $name);
		}

		return $component;
	}
}
