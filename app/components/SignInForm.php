<?php

namespace App\Components;

use Nette;

class SignInForm extends Nette\Application\UI\Control implements \App\Components\IForm
{

	/**
	 * @var Nette\Security\User
	 */
	public $user;

	public function __construct(Nette\Security\User $user)
	{
		$this->user = $user;
	}

	public function createComponentForm()
	{
		$form = new Nette\Application\UI\Form();
		$form->addText('username', 'Username:')
			->setRequired('Please enter your username.');

		$form->addPassword('password', 'Password:')
			->setRequired('Please enter your password.');

		$form->addCheckbox('remember', 'Keep me signed in');

		$form->addSubmit('send', 'Sign in');

		$form->onSuccess[] = function (\Nette\Application\UI\Form $form, $values) {
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

	public function render()
	{
		$this['form']->setDefaults(['username' => 'test']);
		//echo $this['form'];
		// nebo takto
		$this['form']->render();
		//nebo nastavit sablonu a vyrenderovat rucne v ní ...
		//$this->template->render(__DIR__ . '/signInForm.latte');
	}
}
