<?php

namespace NFHubspot\EmailCRM\Shared\Contracts;

use NFHubspot\EmailCRM\Shared\Entities\GlobalSettings;


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
interface ApiModuleOpenAuthorizationContract {

    /**
     * Return the GlobalSettings with values
     * 
     * In returning the full GlobalSettings, the Integrating Plugin is relieved
     * of the responsibility of knowing the responsibility of managing any
     * specific value.
     * 
     * @return GlobalSettings
     */
    public function getGlobalSettings(): GlobalSettings;

    /**
     * Get Access Token
     *
     * Access Token is expected to be generated inside this class.
     * 
     * @return string
     */
    public function getAccessToken(): string;

    /**
     * Request authorization via the authorization_code OpenAuth standard
     * 
     * @return OpenAuthorizationContract
     */
    public function authorizeFromAuthorizationToken(): ApiModuleOpenAuthorizationContract;

    /**
     * Request authorization via the refresh_token OpenAuth standard
     * @return OpenAuthorizationContract
     */
    public function authorizeFromRefreshToken(): ApiModuleOpenAuthorizationContract;
}
