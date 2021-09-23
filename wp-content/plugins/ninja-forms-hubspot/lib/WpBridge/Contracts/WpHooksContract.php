<?php


namespace NFHubspot\EmailCRM\WpBridge\Contracts;

/**
 * Hook into Wordpress functions to decouple Wordpress from the Monorepo
 * 
 * This class provides standardized methods for Wordpress-specific functions.  In
 * doing so, the Monorepo can function with or without an actual Wordpress
 * installation.  This enables robust, simplified testing along with a code base
 * that can migrate across any platform.
 */
interface WpHooksContract
{

	/**
         * Provide WP's add_filter() functionality
         * 
	 * @param string $filterName
	 * @param mixed $incoming
	 * @param int $priority
	 * @param int $acceptedArgs
	 * @return mixed
	 */
	public function addFilter(string $filterName, $incoming, $priority = 10, $acceptedArgs = 1);

	/**
         * Provide WP's apply_filters() functionality
         * 
	 * @param string $filterName
	 * @param mixed $incoming
	 * @return mixed
	 */
	public function applyFilters(string $filterName, $incoming);

	/**
	 * Provide WP's add_action functionality
         * 
	 * @param string $tag
	 * @param array|string|callable $hook
	 */
	public function addAction(string $tag, $hook);
        
        /**
         * Provide WP's wp_nonce_field functionality
         * 
         * @param int|string $action
         * @param string $name
         * @param bool $referer
         * @param bool $echo
         */
        public function wpNonceField( $action = -1, string $name = '_wpnonce', bool $referer = true, bool $echo = true);
}
