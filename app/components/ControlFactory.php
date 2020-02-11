<?php

namespace Andweb\Application\UI;

use Nette,
	Nette\Reflection\ClassType,
	Nette\ComponentModel\IComponent,
	Andweb\Caching\Cache,
	Nette\Caching\IStorage,
    Andweb;
    
class ControlFactory
{

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

            $presenter = $parentComponent->presenter->getName();
            $modulesArr = explode(':', trim($presenter, ':'));
            array_pop($modulesArr);

            $classPossibilities = ['\\App\\Components\\' . $ucname];
            $prev = '';

            $modulesArr[] = 'Front';

            foreach ($modulesArr as $module)
            {
                $prev .= '\\' . $module . 'Module';

                $classPossibilities[] = '\\App' . $prev . '\Components\\' . $ucname;
            }

            $classPossibilities = array_reverse($classPossibilities);
            
            foreach($classPossibilities as $class)
            {
                
                if (class_exists($class, true))
                {
                    $component = $this->context->createInstance($class, $args);
                    $this->context->callInjects($component);
                    break;
                }
            }
        }

        return $component;
    }
}