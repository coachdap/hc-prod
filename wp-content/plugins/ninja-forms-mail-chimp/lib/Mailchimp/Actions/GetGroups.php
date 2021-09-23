<?php


namespace NFMailchimp\EmailCRM\Mailchimp\Actions;

use NFMailchimp\EmailCRM\Mailchimp\Contracts\GetsGroupsFromApi;
use NFMailchimp\EmailCRM\Mailchimp\Entities\Groups;
use NFMailchimp\EmailCRM\Mailchimp\Entities\SingleList;

class GetGroups extends ListAction implements GetsGroupsFromApi
{

	/**
	 * Request interest groups from the
	 *
	 * @param string $listId
	 * @return Groups
	 * @throws \Exception
	 */
	public function requestGroups(string $listId) : Groups
	{
		try {
			$r = $this->api->getInterestCategories($listId, ['count' => 500 ]);
			return Groups::fromArray((array)$r->interests);
		} catch (\Exception $e) {
			throw $e;
		}
	}
}
