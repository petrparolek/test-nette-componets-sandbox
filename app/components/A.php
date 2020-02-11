<?php

namespace App\FrontModule\Components;

use Nette,
App\Model;


class A extends AutoControl {
	



	public function render() 
	{

		$this->template->setFile(__DIR__ . '/../templates/components/a.latte');
		$this->template->render();

	}



}