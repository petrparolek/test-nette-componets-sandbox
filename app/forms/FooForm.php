<?php

namespace Test\Components;

use App\Components\IForm;
use App\Forms\FormFactory;
use App\Model;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;

final class FooForm extends Control implements IForm
{

	/** @var FormFactory */
	private $factory;

	public function __construct(FormFactory $factory)
	{
		$this->factory = $factory;
	}

	public function render()
	{
		$this['form']->render();
	}

	/**
	 * @return Form
	 */
	public function createComponentForm()
	{
		$form = $this->factory->create();
		$form->addText('foo', 'Foo:');

		$form->onSuccess[] = function (Form $form, $values) {

		};

		return $form;
	}
}
