<?php

namespace NFHubspot\EmailCRM\Shared\Contracts;

use NFHubspot\EmailCRM\Shared\Entities\FormField;
use NFHubspot\EmailCRM\Shared\Entities\FormFields;

/**
 * Contract for building forms
 */
interface FormBuilder
{

	/**
	 * Set the form title
	 * @param string $title Form Title
	 * @return \NFHubspot\EmailCRM\Shared\Contracts\FormBuilder
	 */
	public function setTitle(string $title): FormBuilder;

	/**
	 * Add form field to the form
	 * @param FormField $formField
	 * @return \NFHubspot\EmailCRM\Shared\Contracts\FormBuilder
	 */
	public function addFormField(FormField $formField): FormBuilder;

	/**
	 * Get form builder title
	 * @return string
	 */
	public function getTitle(): string;

	/**
	 * Get form fields
	 * @return FormFields
	 */
	public function getFormFields(): FormFields;

	/**
	 * Return FormBuilder entity as associative array
	 * @return array
	 */
	public function toArray(): array;
}
