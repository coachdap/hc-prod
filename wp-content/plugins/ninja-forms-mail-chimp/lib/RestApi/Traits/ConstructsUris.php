<?php


namespace NFMailchimp\EmailCRM\RestApi\Traits;

/**
 * Trait ConstructsUris
 *
 * Utility methods for working with REST API endpoint URIs
 */
trait ConstructsUris
{


	/**
	 * Construct a parameter with REGEX to accept required param/value
	 *
	 * @param string $param Parameter requested
	 * @param string $mask `numeric` `alphanumeric`
	 * @return string
	 */
	protected function constructParameterUri(string $param, string $mask): string
	{

		switch ($mask) {
			case 'numeric':
				$return = "(?P<$param>[\d]+)";
				break;
			case 'alphanumeric':
			default:
				$return = "(?P<$param>[\w]+)";
		}

		return $return;
	}
}
