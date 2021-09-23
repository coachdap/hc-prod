<?php

namespace NFMailchimp\NinjaForms\Mailchimp\Handlers;

// Integrating plugin
use NFMailchimp\NinjaForms\Mailchimp\NinjaFormsMailchimp;
use NFMailchimp\NinjaForms\Mailchimp\Contracts\NinjaFormsMailchimpContract;
// NF Bridge
use NFMailchimp\EmailCRM\NfBridge\Contracts\NfBridgeContract;
use NFMailchimp\EmailCRM\NfBridge\Contracts\NewsletterExtensionContract;
// Mailchimp
use NFMailchimp\EmailCRM\Mailchimp\Contracts\MailchimpContract;
use NFMailchimp\EmailCRM\Mailchimp\Factories\ActionFactoryService;
use NFMailchimp\EmailCRM\Mailchimp\Entities\Account;
use NFMailchimp\EmailCRM\Mailchimp\Entities\Lists;
use NFMailchimp\EmailCRM\Mailchimp\Entities\SingleList;
use NFMailchimp\EmailCRM\Mailchimp\Entities\Interest;
use NFMailchimp\EmailCRM\Mailchimp\Entities\Interests;
use NFMailchimp\EmailCRM\Mailchimp\Entities\InterestCategory;
use NFMailchimp\EmailCRM\Mailchimp\Entities\InterestCategories;
use NFMailchimp\EmailCRM\Mailchimp\Entities\MergeVar;
use NFMailchimp\EmailCRM\Mailchimp\Entities\MergeVars;
// WP Bridge
use NFMailchimp\EmailCRM\WpBridge\Database\TransientStore;

/**
 * Extended functionality for NF Action to integrate with NF_Abstracts_Newsletter
 *
 * This class honors the NF Bridge contract that substitutes Ninja Forms' newsletter action
 * It enables the form to use the existing NF functionality for newsletters to
 * provide a smooth implementation for existing and future NF newsletter users
 */
class NewsletterExtension implements NewsletterExtensionContract
{

	/**
	 *
	 * @var NinjaFormsMailchimpContract
	 */
	protected $nfMailchimp;

	/**
	 *
	 * @var NfBridgeContract
	 */
	protected $nfBridge;

	/**
	 * Mailchimp Module - 'Module' added to differentiate from vendor API library
	 * @var MailchimpContract
	 */
	protected $mailchimpModule;

	/**
	 *
	 * @var ActionFactoryService
	 */
	protected $actionFactory;

	/**
	 *
	 * @var TransientStore
	 */
	protected $transientStore;

	/**
	 *
	 * @var string
	 */
	protected $transient = '';

	/**
	 *
	 * @var string
	 */
	protected $transientExpiration = '';

	/**
	 * Construct Newsletter Extension
	 * @param NinjaFormsMailchimpContract $nfMailchimp
	 */
	public function __construct(NinjaFormsMailchimpContract $nfMailchimp)
	{
		$this->nfMailchimp = $nfMailchimp;

		$this->nfBridge = $this->nfMailchimp->getNfBridge();

		$this->mailchimpModule = $this->nfMailchimp->getMailchimpModule();

		$this->actionFactory = $this->mailchimpModule->make(ActionFactoryService::class);
		$apiKey = trim(Ninja_Forms()->get_setting('ninja_forms_mc_api'));
		$account = Account::fromArray(['apiKey' => $apiKey]);
		$this->actionFactory->setAccount($account);

		$this->transient = 'mailchimp_newsletter_lists'; // Must match NF Newsletter Abstract

		$this->transientStore = new TransientStore($this->transient);
	}

	/**
	 * Pass through get_lists request to getLists
	 *
	 * May be obsolete, but kept until confirmed - other integrations may
	 * use this public method from previous NF Mailchimp plugin
	 * @return type
	 */
	public function get_lists()
	{
		$lists = $this->getLists();
		return $lists;
	}

	/**
	 * Make API calls to construct array of lists
	 *
	 * $cacheOkay set to true if using cached lists is okay, i.e. not
	 * specifically requesting a list refresh
	 *
	 * @param bool $cacheOkay
	 * @return array
	 */
	public function getLists(bool $cacheOkay = false): array
	{
		if ($cacheOkay) {
			$maybeLists = $this->transientStore->getData();

			if ($maybeLists) {
				$lists = $maybeLists;

				return $lists;
			}
		}
		/** @var Lists $listsEntity */
		$getLists = $this->actionFactory->getListsAction();

		$listCollection = $getLists->requestLists()->getLists();

		$lists = $this->extractListData($listCollection);

		$this->cacheLists($lists);
		// Make/update an option every time the list is updated.
		// @todo: Verify if needed - doesn't appear to be used - SRS
		update_option('ninja_forms_mailchimp_interests', $lists);
		return $lists;
	}

	/**
	 * Extract list data as used by Ninja Forms Newsletter action
	 * @param array $listCollection
	 * @return array
	 */
	protected function extractListData(array $listCollection): array
	{
		/** @var SingleList $list */
		$nfMailchimpLists = [];
		foreach ($listCollection as $list) {
			// Create/update a setting with the the ID and name of the list.
			Ninja_Forms()->update_setting('mail_chimp_list_' . $list->getId(), $list->getName());

			// Build the array of lists.
			$nfMailchimpLists[] = array(
				'value' => $list->getId(),
				'label' => $list->getName(),
				'groups' => $this->getListInterestCategories($list->getId()),
				'fields' => $this->getMergeVars($list->getId())
			);
		}

		return $nfMailchimpLists;
	}

	/**
	 * Get Merge Vars for a given list id
	 * @param string $listId
	 * @return array
	 */
	public function getMergeVars(string $listId): array
	{
		$singleList = SingleList::fromArray(['listId' => $listId]);

		$getMergeVars = $this->actionFactory->getMergeFieldsAction($singleList);

		$mergeVarsCollection = $getMergeVars->requestMergeFields($listId)->getMergeVars();

		$mergeVars = $this->buildMergeVars($mergeVarsCollection, $listId);

		return $mergeVars;
	}

	/**
	 * Build MergeVars array from a collection
	 * @param array $mergeVarsCollection
	 * @param string $listId
	 * @return array
	 */
	protected function buildMergeVars($mergeVarsCollection, $listId): array
	{

		/** @var MergeVar $mergeVar */
		// Email field is required for all new mailing list sign ups,
		// but is not pulled in through the api so we need to build it ourselves.
		$mergeVars[] = array(
			'value' => $listId . '_email_address',
			'label' => 'Email' . ' <small style="color:red">(required)</small>',
		);
		
		// Loop over the fields and...
		foreach ($mergeVarsCollection as $mergeVar) {
			// If the has required text...
			if (true == $mergeVar->getRequired()) {
				// ...add html to apply a required tag.
				$required_text = ' <small style="color:red">(required)</small>';
			} else {
				// ...otherwise leave this variable empty.
				$required_text = '';
			}

			// Build our fields array.
			$mergeVars[] = array(
				'value' => $listId . '_' . $mergeVar->getTag(),
				'label' => $mergeVar->getName() . $required_text
			);
		}

		// Added by SRS
		// @todo: deliver this value externally - it is shared with form autogeneration
		// so use a single source for better maintained code  see AutogenerateForm
		$mergeVars[] = array(
			'value' => $listId . '_interests',
			'label' => 'User Selected Interests'
		);

		$mergeVars[] = array(
			'value' => $listId . '_tags',
			'label' => 'Tags, comma-separated'
		);

		return $mergeVars;
	}

	/**
	 * Get Interest Categories for a given list id
	 * @param string $listId
	 * @return array
	 */
	public function getListInterestCategories($listId): array
	{

		$getInterestCategoriesAction = $this->actionFactory->getInterestCategoriesAction();

		$interestCategoriesCollection = $getInterestCategoriesAction->requestInterestCategories($listId)->getInterestCategories();

		$categories=$this->consolidateInterestsAcrossCategories($listId, $interestCategoriesCollection);

		Ninja_Forms()->update_setting('nf_mailchimp_categories_' . $listId, $categories);

		return $categories;
	}

	/**
	 * Consolidate interests across all interest categories, structured for NF Newsletter Action
	 * @param string $listId
	 * @param array $interestCategoriesCollection
	 * @return array
	 */
	protected function consolidateInterestsAcrossCategories(string $listId, array $interestCategoriesCollection):array
	{
		$interestsAllCategories=[];
		// Loop over the categories we get back from the API.
		foreach ($interestCategoriesCollection as $category) {
			// Gets our interests lists.
			$interests = $this->getInterests($listId, $category->getId());

			// Loops over interests and builds interest list.
			$addedInterests = $this->constructInterestsActionStructure($listId, $interests);

			$interestsAllCategories = array_merge($interestsAllCategories, $addedInterests);
		}
		return $interestsAllCategories;
	}
	/**
	 * Construct array of interests into NF standard structure
	 *
	 * Glues the listId, interest Id, and interest name in an underscore-
	 * delineated structure, parsed to construct Action Settings
	 * @param string $listId
	 * @param array $interests
	 * @return array
	 */
	protected function constructInterestsActionStructure(string $listId, array $interests): array
	{
		$categories = [];
		foreach ($interests as $interest) {
			$categories[] = array(
				'value' => $listId . '_group_' . $interest['id'] . '_' . $interest['name'],
				'label' => $interest['name'],
			);
		}
		return $categories;
	}

	/**
	 * Get interests for a given list id and interest category id
	 * @param string $listId
	 * @param string $interestCategoryId
	 * @return array
	 */
	public function getInterests($listId, $interestCategoryId): array
	{

		$getInterests = $this->actionFactory->getInterestsAction();

		$interestsCollection = $getInterests->requestInterests($listId, $interestCategoryId)->getInterests();

		$interests = $this->constructInterestsArray($interestsCollection);
		return $interests;
	}

	/**
	 * Return indexed array of name/id pairs for interests collection
	 * @param array $interestsCollection
	 * @return array
	 */
	protected function constructInterestsArray(array $interestsCollection): array
	{
		$interests = [];
		foreach ($interestsCollection as $interest) {
			// Build our array.
			$interests[] = array(
				'name' => $interest->getName(),
				'id' => $interest->getId()
			);
		}
		return $interests;
	}

	/**
	 * Stores the lists collection as a WP transient
	 * @param array $lists
	 */
	private function cacheLists(array $lists)
	{
		$this->transientStore->saveData($lists);
	}
}
