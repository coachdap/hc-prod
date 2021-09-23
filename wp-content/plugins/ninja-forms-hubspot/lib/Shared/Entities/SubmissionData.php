<?php


namespace NFHubspot\EmailCRM\Shared\Entities;

use NFHubspot\EmailCRM\Shared\Contracts\FormActionFieldCollection;
use NFHubspot\EmailCRM\Shared\Contracts\SubmissionDataContract;
use NFHubspot\EmailCRM\Shared\SimpleEntity;
use NFHubspot\EmailCRM\Shared\Traits\UsesArrayForEntity;

/**
 * Class SubmissionData
 *
 * Represents the details about current submission relevant to the form action/ form processor
 */
class SubmissionData extends SimpleEntity implements SubmissionDataContract
{
	use UsesArrayForEntity;

	/**
	 * @var FormActionFieldCollection
	 */
	protected $fields;

	/**
	 * @var array[string]
	 */
	protected $errors = [];

	public function __construct(array $items, FormActionFieldCollection $fields)
	{
		$this->setItems($items);
		$this->fields = $fields;
	}

	/**
	 * Get value or default
	 *
	 * @param string $key
	 * @param null $default
	 * @return mixed|null
	 */
	public function getValue(string $key, $default = null)
	{
		if ($this->hasValue($key)) {
			return $this->$key;
		}
		return $default;
	}
}
