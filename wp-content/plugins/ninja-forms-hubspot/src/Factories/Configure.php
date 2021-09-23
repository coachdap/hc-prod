<?php


namespace NFHubspot\Factories;

// Integrating Plugin
use NFHubspot\Contracts\ConfigureContract;

// Shared
use NFHubspot\EmailCRM\NfBridge\Entities\Modal;
use NFHubspot\EmailCRM\NfBridge\Entities\ActionEntity;

/**
 * Provides configured Integrating Plugin-specific entities
 */
class Configure implements ConfigureContract
{

	/**
	 * ApiModule's top level file location
	 *
	 * @var string
	 */
	protected $dir;

	
	/**
	 * Instantiate with top-level file directory to provide access throughout
	 *
	 * @param string $dir
	 */
	public function __construct(string $dir)
	{
		$this->dir = $dir;
	}
	
		
		/**
		 * Return autogenerate modal markup
		 *
		 * Used to construct Add New modal box
		 * @return Modal
		 */
	public function autogenerateModalMarkup(): Modal
	{
		$array = include $this->dir.'/Config/AutogenerateModal.php';
			
		return Modal::fromArray($array);
	}
		
					/**
	 * Provide ActionEntity defining the primary action of the integrating plugin
	 *
	 * @return ActionEntity
	 */
	public function actionEntity():ActionEntity
	{
				$array = include $this->dir.'/Config/ActionEntity.php';
			
		return ActionEntity::fromArray($array);
	}
}
