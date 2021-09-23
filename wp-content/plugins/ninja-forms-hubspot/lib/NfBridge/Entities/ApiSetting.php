<?php

namespace NFHubspot\EmailCRM\NfBridge\Entities;

use NFHubspot\EmailCRM\Shared\SimpleEntity;

/**
 * Single API setting in form design
 *
 * This entity describes a piece of data that the API requires.  NF / CF
 * is responsible for storing and delivering this data back to the API.
 *
 */
class ApiSetting extends SimpleEntity
{

	/**
	 * Id for API setting entity
	 * @var string
	 */
	protected $id;

	/**
	 * Label for API setting entity
	 * @var string
	 */
	protected $label;

	/**
	 * Type of data expected in this setting
	 * @var string
	 */
	protected $expectedDataType;
        
		/**
		 * Stored value of the setting
		 *
		 * Upon initial configuration inside the ApiModule, this value is null.
		 * The Integrating Plugin manages the solicitation of  values, 
                 * storing of the values, and returning the values upon demand.
		 *
		 * @var mixed
		 */
		protected $value=null;
                
	/**
	 * Constructs object from given array
	 * @param array $items
	 * @return SimpleEntity
	 */
	public static function fromArray(array $items): SimpleEntity
	{
		$obj = new static();
		foreach ($items as $property => $value) {
			$obj = $obj->__set($property, $value);
		}
		return $obj;
	}

	/**
	 * Return API setting Id
	 * @return string
	 */
	public function getId(): string
	{
		return isset($this->id) ? (string) $this->id : '';
	}

	/**
	 * Return API setting label
	 * @return string
	 */
	public function getLabel(): string
	{
		return isset($this->label) ? (string) $this->label : '';
	}

	/**
	 * Return API setting data type
	 * @return string
	 */
	public function getExpectedDataType(): string
	{
		return isset($this->expectedDataType) ? (string) $this->expectedDataType : '';
	}

        		/**
		 * Get the value for the ApiSetting
		 * @return mixed
		 */
	public function getValue()
	{
		return $this->value;
	}
        
	/**
	 * Set API setting Id
	 * @param string $stringValue
	 * @return ApiSetting
	 */
	public function setId(string $stringValue): ApiSetting
	{
		$this->id = $stringValue;

		return $this;
	}

	/**
	 * Set API setting label
	 * @param string $stringValue
	 * @return ApiSetting
	 */
	public function setLabel(string $stringValue): ApiSetting
	{
		$this->label = $stringValue;

		return $this;
	}

	/**
	 * Set API setting expected data type
	 * @param string $stringValue
	 * @return ApiSetting
	 */
	public function setExpectedDataType(string $stringValue): ApiSetting
	{
		$this->expectedDataType = $stringValue;

		return $this;
	}
        		/**
		 * Set the value for the ApiSetting
		 *
		 * @param mixed|null $param
		 * @return ApiSetting
		 */
	public function setValue($param=null):ApiSetting
	{
		$this->value = $param;
			
		return $this;
	}
}