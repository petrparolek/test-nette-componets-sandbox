<?php

namespace App\Components;

use App\Forms\FormFactory;
use Nette;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Security\User;

final class SignInForm extends Control
{

	/** @var FormFactory */
	private $factory;

	/** @var User */
	private $user;

	public function __construct(FormFactory $factory, User $user)
	{
		$this->factory = $factory;
		$this->user = $user;
	}

	public function render()
	{
		//echo $this['form'];
		// nebo takto
		//$this['form']->render();
		//nebo nastavit sablonu a vyrenderovat rucne v ní ...
		$this->template->render(__DIR__ . '/signInForm.latte');
	}

	/**
	 * @return Form
	 */
	public function createComponentForm()
	{
		$form = $this->factory->create();
		$form->addText('username', 'Username:')
			->setRequired('Please enter your username.');

		$form->addPassword('password', 'Password:')
			->setRequired('Please enter your password.');

		$form->addCheckbox('remember', 'Keep me signed in');

		$form->addSubmit('send', 'Sign in');

		$form->onSuccess[] = function (Form $form, $values) {
			try {
				$this->user->setExpiration($values->remember ? '14 days' : '20 minutes');
				$this->user->login($values->username, $values->password);
			} catch (Nette\Security\AuthenticationException $e) {
				$form->addError('The username or password you entered is incorrect.');
				return;
			}
		};

		return $form;
	}
}
