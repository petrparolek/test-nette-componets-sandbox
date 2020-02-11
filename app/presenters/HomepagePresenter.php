<?php

namespace App\Presenters;


final class HomepagePresenter extends BasePresenter
{


	public function actionDefault()
	{
		$this['testForm']['form']->onSuccess[] = function ($form, $values) {

			$this->flashMessage('Odeslano');
			$this->redirect('this');
		};
	}

	public function renderDefault()
	{
	}




	

}
