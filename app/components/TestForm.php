<?php

namespace App\FrontModule\Components;

use Nette,
App\Model;


class TestForm extends AutoControl 
{
	
	public function createComponentForm()
	{
		$form = new Nette\Application\UI\Form;
		$form->addText('name', 'Tvoje jméno');
		$form->addSubmit('send', 'Odeslat');

		return $form;
	}

	public function render() 
	{
		echo $this['form'];
		// nebo takto
		//$this['form']->render();
		//nebo nastavit sablonu a vyrenderovat rucne v ní ...
	}



}