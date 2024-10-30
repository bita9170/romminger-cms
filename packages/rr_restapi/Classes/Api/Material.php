<?php

namespace Romminger\Restapi\Api;

use Nng\Nnrestapi\Api\AbstractApi;
use Nng\Nnrestapi\Annotations as Api;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Romminger\RrSondermetalle\Domain\Repository\MaterialRepository;

/**
 * This annotation registers this class as an Endpoint!
 *  
 * @Api\Endpoint()
 */
class Material extends AbstractApi
{
	private readonly MaterialRepository $materialRepository;

	public function __construct()
	{
		$this->materialRepository = GeneralUtility::makeInstance(MaterialRepository::class);
		\nn\t3::Db()->ignoreEnableFields($this->materialRepository);
	}

	/**
	 * # Retrieve ALL Materials 
	 * 
	 * Send a GET request to this endpoint to retrieve ALL Materials from the database.
	 * 
	 * Replace `{uid}` with the uid of the Material:
	 * 
	 * @Api\Access("public")
	 * 
	 * @return array
	 */
	public function getAllAction()
	{
		$result = $this->materialRepository->findAll();
		return $result;
	}

	/**
	 * # Retrieve an existing Material
	 * 
	 * Send a simple GET request to retrieve an Material by its uid from the database.
	 * 
	 * @Api\Access("public")
	 * @Api\Label("/api/material/{uid}")
	 * 
	 * @return array
	 */
	public function getIndexAction(int $uid = null)
	{
		if (!$uid) {
			return $this->response->notFound("No uid passed in URL. Send the request with `api/material/{uid}`");
		}

		$result = $this->materialRepository->findByUid($uid);
		return $result;
	}
}
