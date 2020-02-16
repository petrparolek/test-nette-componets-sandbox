<?php

namespace App\Presenters;

final class SignPresenter extends BasePresenter
{

	/** @persistent */
	public $backlink = '';

	public function actionIn()
	{
		$this['signInForm']['form']->onSuccess[] = function ($form, $values) {
			$this->restoreRequest($this->backlink);
			$this->redirect('Homepage:');
		};
	}

	public function actionUp()
	{
		$this['signUpForm']['form']->onSuccess[] = function ($form, $values) {
			$this->redirect('Homepage:');
		};
	}

	public function actionOut()
	{
		$this->getUser()->logout();
	}
}
