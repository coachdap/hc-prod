<?php


namespace NFHubspot\EmailCRM\NfBridge\Contracts;

use NFHubspot\EmailCRM\NfBridge\Entities\Form;

/**
 * Class FormFactory
 *
 * Converts Ninja Forms objects to standard Form object
 */
interface FormFactoryContract
{

	/**
	 * Create form object form Ninja Forms model factory
	 *
	 * @param \NF_Abstracts_ModelFactory $form
	 * @return Form
	 */
	public function fromNinjaForms(\NF_Abstracts_ModelFactory $form) : Form;
}
