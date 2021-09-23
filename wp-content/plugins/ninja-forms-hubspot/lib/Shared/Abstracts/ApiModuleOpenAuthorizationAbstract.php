<?php

namespace NFHubspot\EmailCRM\Shared\Abstracts;

use NFHubspot\EmailCRM\Shared\Contracts\ApiModuleOpenAuthorizationContract;
use NFHubspot\EmailCRM\Shared\Contracts\OpenAuthImplementationContract;
use NFHubspot\EmailCRM\Shared\Entities\GlobalSettings;
use NFHubspot\EmailCRM\Shared\Contracts\GlobalSettingsStorageContract;
use NFHubspot\EmailCRM\Shared\Entities\OpenAuthCredentials;

/**
 * Provides an integrating plugin with OpenAuth access through an ApiModule
 * 
 * Integrating plugins communicate settings via GlobalSettings; they aren't 
 * aware of the external definition or uses of the data inside.  It does know
 * how to solicit, store, and provide each piece of data inside the 
 * GlobalSettings.
 * 
 * ApiModules understand the use of each piece of data inside the GlobalSettings.
 * They are unaware of how the data was solicited, stored, or provided.  Once
 * given the data, however, it can extract the OpenAuth credentials, which it
 * can pass on to an OpenAuthenticator for authorization.
 * 
 * The OpenAuthorization process, in generating a new AccessToken for 
 * immediate access, invalidates any existing RefreshToken, 
 * AuthorizationCode, and AccessToken, and provides new values.  
 * Therefore, as part of the authorization process, this class must also provide
 * the updated values for the integrating plugin to store for future use.
 * 
 */
abstract class ApiModuleOpenAuthorizationAbstract implements ApiModuleOpenAuthorizationContract {

    /**
     * Provides OpenAuth access through the ApiModule to a specific user's account
     *
     * This class provides public methods to receive the incoming credentials,
     * which it uses to generate the access token needed for access. In
     * addition, it also generates and provides a refresh token, which the
     * integrating plugin must store, to be used in making the next request.
     *
     * @var OpenAuthImplementationContract 
     */
    protected $openAuthImplementation;

    /**
     * Store, retrieve, and provide GlobalSettings from a data source
     * 
     * @var GlobalSettingsStorageContract 
     */
    protected $globalSettingsStorage;

    /**
     * OpenAuthorization credentials structured OpenAuthCredentials entity 
     * @var OpenAuthCredentials 
     */
    protected $openAuthCredentials;

    /**
     * Lookup values for OpenAuth credentials in a GlobalSettings entity
     * 
     * To relieve classes outside a given ApiModule of knowing which GlobalSettings
     * key relates to which OpenAuth credentials key, the ApiModule provides
     * a lookup entity in an OpenAuthCredentials entity structure.  The value
     * of each OpenAuthCredential key is the GlobalSettings entity key that
     * holds the actual OpenAuthCredential value.  In this fashion, this class
     * is agnostic of external values, using this lookup to retrieve 
     * OpenAuthCredentials from the GlobalSettings and setting the new
     * GlobalSettings from refreshed OpenAuthCredentials.
     * 
     * @var OpenAuthCredentials
     */
    protected $openAuthCredentialsLookup;

    /**
     * Fully formed endpoint to which grant_type=authorization_code request is made
     * 
     * @var string
     */
    protected $grantTypeAuthCodeUrl;
    
    /**
     * Fully formed endpoint to which grant_type=refresh_token request is made
     * 
     * @var string
     */
    protected $grantTypeRefreshTokenUrl;
    
    /**
     * 
     * 
     * @param OpenAuthImplementationContract $openAuthImplementation
     * @param GlobalSettingsStorageContract $globalSettingsStorage
     * @param OpenAuthCredentials $openAuthCredentialsLookup
     */
    public function __construct(
            OpenAuthImplementationContract $openAuthImplementation,
            GlobalSettingsStorageContract $globalSettingsStorage,
            OpenAuthCredentials $openAuthCredentialsLookup
    ) {

        $this->openAuthImplementation = $openAuthImplementation;

        $this->globalSettingsStorage = $globalSettingsStorage;
        $this->globalSettingsStorage->retrieveGlobalSettings();
        
        $this->openAuthCredentialsLookup = $openAuthCredentialsLookup;
        
        $this->extractOpenAuthCredentials();
        $this->setURLs();
    }

    /**
     * Set fully formed endpoints for authorization requests
     * 
     * grant_type=authorization_code endpoint  
     * grant_type=refresh_token endpoint  
     */
    abstract function setURLs();

    /**
     * Initialize OpenAuth implementation with credentials and endpoint URLs
     */
    protected function initialize() {
        $this->openAuthImplementation->setCredentials($this->openAuthCredentials);
        $this->openAuthImplementation->setGrantTypeAuthCodeUrl($this->grantTypeAuthCodeUrl);
        $this->openAuthImplementation->setGrantTypeRefreshTokenUrl($this->grantTypeRefreshTokenUrl);
    }

    /**
     * Return the GlobalSettings with values
     * 
     * In returning the full GlobalSettings, the Integrating Plugin is relieved
     * of the responsibility of knowing the responsibility of managing any
     * specific value.
     * 
     * @return GlobalSettings
     */
    public function getGlobalSettings(): GlobalSettings {
        return $this->globalSettingsStorage->getGlobalSettings();
    }

    /**
     * Return Access Token
     * 
     * @return string
     */
    public function getAccessToken(): string {

        return $this->openAuthCredentials->getAccessToken();
    }

    /**
     * Request authorization using grant_type=authorization_code 
     * 
     * @return ApiModuleOpenAuthorizationContract
     */
    public function authorizeFromAuthorizationToken(): ApiModuleOpenAuthorizationContract {
        $this->initialize();
        $this->openAuthImplementation->authorizeFromAuthorizationCode();
        $this->finalize();
        return $this;
    }

    /**
     * Request authorization using grant_type=refresh_token 
     * 
     * @return ApiModuleOpenAuthorizationContract
     */
    public function authorizeFromRefreshToken(): ApiModuleOpenAuthorizationContract {
        $this->initialize();
        $this->openAuthImplementation->authorizeFromRefreshToken();
        $this->finalize();
        return $this;
    }

    /**
     * Update credentials and store GlobalSettings
     * 
     * Done after authorization request is made, this sets the new credentials
     * in both this instance and requests that the GlobalSettingsStorage class
     * update the data source as well.
     * 
     */
    protected function finalize() {
        $this->openAuthCredentials = $this->openAuthImplementation->getCredentials();
        $this->setNewGlobalSettingsValues();
        $this->globalSettingsStorage->storeGlobalSettings();
    }

    /**
     * Extract credentials from GlobalSettings using OpenAuthCredentials lookup
     */
    protected function extractOpenAuthCredentials() {

        $credentialsWithValues = [];

        foreach ($this->openAuthCredentialsLookup->toArray() as $openAuthKey => $globalSettingsKey) {
            
            $credentialsWithValues[$openAuthKey] = $this->globalSettingsStorage
                    ->getGlobalSettings()
                    ->getGlobalSetting($globalSettingsKey)
                    ->getValue();
        }


        $this->openAuthCredentials = OpenAuthCredentials::fromArray($credentialsWithValues);
    }

    /**
     * Update GlobalSettings with updated OpenAuthCredentials values
     * 
     * Refresh token and access token are updated with new values while
     * Authorization Code is reset to an empty string as the code is only good
     * for a single request.
     */
    protected function setNewGlobalSettingsValues() {

        $accessTokeGlobalSettingsKey = $this->openAuthCredentialsLookup->getAccessToken();
        $refreshTokenGlobalSettingsKey = $this->openAuthCredentialsLookup->getRefreshToken();
        $authorizationCodeKey = $this->openAuthCredentialsLookup->getAuthorizationCode();

        $this->globalSettingsStorage
                ->getGlobalSettings()
                ->getGlobalSetting($accessTokeGlobalSettingsKey)
                ->setValue($this->openAuthCredentials->getAccessToken());

        $this->globalSettingsStorage
                ->getGlobalSettings()
                ->getGlobalSetting($refreshTokenGlobalSettingsKey)
                ->setValue($this->openAuthCredentials->getRefreshToken());

        $this->globalSettingsStorage
                ->getGlobalSettings()
                ->getGlobalSetting($authorizationCodeKey)
                ->setValue('');
    }

}
