<?php


namespace NFHubspot\EmailCRM\NfBridge\Entities;

use NFHubspot\EmailCRM\Shared\SimpleEntity;
use NFHubspot\EmailCRM\Shared\Traits\ConvertsFromArrayWithSnakeCaseing;
use NFHubspot\EmailCRM\Shared\Traits\ConvertsToArrayWithSnakeCaseing;

abstract class NFBridgeEntity extends SimpleEntity
{
	use ConvertsFromArrayWithSnakeCaseing,ConvertsToArrayWithSnakeCaseing;
}
