<?php

namespace App\Presenters;

final class SignPresenter extends \App\Presenters\BasePresenter
{

	/** @persistent */
	public $backlink = '';

	public function actionIn()
	{
		$this['signInForm']['form']->onSuccess[] = function ($form, $values) {
			$this->flashMessage('test abc');
			$this->redirect('Homepage:');
		};
	}

	public function actionOut()
	{
		$this->getUser()->logout();
	}
}
