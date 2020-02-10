<?php

namespace App\Presenters;

use Nette;

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{

	protected function createComponent($name)
	{
		$component = parent::createComponent($name);

		// pokud se nepodari najit tovarnicku na komponentu, zkusime autoload dle jmena
		if (!$component instanceof IComponent) {
			$componentFactory = $this->getControlFactory();
			$component = $componentFactory->create($this, $name);
		}

		return $component;
	}

	public function getControlFactory()
	{
		return $this->context->getByType('\\App\\FrontModule\\Components\\FrontControlFactory');
	}
}
