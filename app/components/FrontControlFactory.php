<?php

namespace App\FrontModule\Components;

use Nette,
    Andweb,
    App\FrontModule\Model,
    Andweb\Application\UI\ControlFactory,
    Nette\ComponentModel\IComponent,
    App\FrontModule\Components\FrontControl;
    
class FrontControlFactory
{
    
    protected $context;
    protected $controlFactory;

    private $components;

    public function __construct(Nette\Di\Container $context, ControlFactory $controlFactory)
    {
        $this->context = $context;
        $this->controlFactory = $controlFactory;
    }

    public function getComponents()
    {

        if ($this->components === null) {
            $this->components = [];
 /*            $componentsList = $this->modelComponent->getByPresenterId([$this->modelNavigation->presenterId, null]);

            foreach ($componentsList as $component) {
                if (!isset($this->components[$component->name])) {
                    $this->components[$component->name] = $component;
                }
            } */
        }

        return $this->components;
    }

    public function flushComponentsCache()
    {
        $this->components = NULL;
    }

    public function create(IComponent $parentComponent, $name, array $args = [])
    {
        $component = null;

        $components = $this->getComponents();

        if (!isset($components[$name])) {
            $component = $this->controlFactory->create($parentComponent, $name, $args);
        } else {
            $component = $this->controlFactory->create($parentComponent, $components[$name]->component, $args);
        }
/*
        if (!$component instanceof IComponent) {
            throw new Nette\UnexpectedValueException("Automatic creation component did not return or create the desired component. Component name: " . $name);
        }
*/
		// set config from database
        if (isset($components[$name])) {
            if(method_exists($component, 'setConfig'))
                $component->setConfig(
                    $this->modelComponent->getComponentSettings($components[$name])
                );

       /*      if($component instanceof FrontControl)
            {
                $component->setComponentRow($components[$name]);
            } */
        }

        return $component;

    }
}