<?php


namespace NFHubspot\EmailCRM\NfBridge\Factories;

use NFHubspot\EmailCRM\NfBridge\Entities\Form;
use NFHubspot\EmailCRM\NfBridge\Contracts\FormFactoryContract;

/**
 * Class FormFactory
 *
 * Converts Ninja Forms objects to standard Form object
 */
class FormFactory implements FormFactoryContract
{

	/** @inheritdoc */
	public function fromNinjaForms(\NF_Abstracts_ModelFactory $form) : Form
	{
		return  new Form([
					'id' => (string) $form->get_id(),
					'name'=> $form->get_model($form->get_id(), 'form')->get_setting('title')]);
	}
}
