<?php

namespace NFHubspot\EmailCRM\WpBridge;

use NFHubspot\EmailCRM\WpBridge\Contracts\WpHooksContract;
/**
 * Hook into Wordpress functions to decouple Wordpress from the Monorepo
 * 
 * This class provides standardized methods for Wordpress-specific functions.  In
 * doing so, the Monorepo can function with or without an actual Wordpress
 * installation.  This enables robust, simplified testing along with a code base
 * that can migrate across any platform.
 */
class WpHooksApi implements WpHooksContract
{
    /**
     * Provide WP's apply_filters() functionality
     * 
     * Checks if Wordpress' native function is available and uses that.  If
     * it is not, then the original value is returned as it would if no filter 
     * had been added.
     * @param string $filterName
     * @param mixed $incoming
     * @return mixed
     */
	public function applyFilters(string $filterName, $incoming, ...$args)
	{

        if (function_exists('apply_filters')) {
            return apply_filters($filterName, $incoming, $args);
        }

        return $incoming;
    }

    /**
     * Provide WP's add_filter() functionality
     * 
     * Checks if Wordpress' native function is available and uses that.  If
     * it is not available, no filter is added.
     * 
     * @param string $filterName
     * @param mixed $callback
     * @param int $priority
     * @param int $accepted_args
     * @return mixed
     */
	public function addFilter(string $filterName, $callback, $priority = 10, $accepted_args = 1)
	{

        if (function_exists('add_filter')) {
            add_filter($filterName, $callback, $priority, $accepted_args);
        }
    }

    /**
     * Provide WP's add_action functionality
     * 
     * Check if Wordpress' native function is available and uses that.  If
     * it is not available, no action is added.
     * 
     * @param string $tag
     * @param array|string|callable $hook
     */
	public function addAction(string $tag, $hook)
	{

        if (function_exists('add_action')) {
            add_action($tag, $hook);
        }
    }

    /**
     * Provide WP's wp_nonce_field functionality
     * 
     * If function exists, sets a variable by Wordpress' wp_nonce_field function.
     * Wordpress' function will automatically echo if that parameter is true,
     * 
     * If the function does not exist, this method creates a simulated nonce string
     * and conditionally echoes it.
     * 
     * Regardless of $echo conditional, the nonce value is returned
     * @param int|string $action
     * @param string $name
     * @param bool $referer
     * @param bool $echo
     */
    public function wpNonceField($action = -1, string $name = '_wpnonce', bool $referer = true, bool $echo = true) {

        if (function_exists('wp_nonce_field')) {

            $response = wp_nonce_field($action, $name, $referer, $echo);
        } else {

            $response = '<input type="hidden" id="'.$name.'" name="'.$name.'" value="simulated_nonce">';

            if ($echo) {
                echo $response;
            }
        }
        
        return $response;
    }

    /**
     * Return the wp_rest_url parameter
     *  
     * @return string
     */
    public function wpRestUrl() {
        if(function_exists('rest_url')){
            $response = \rest_url();
        }else{
            
            $response = 'wp-json/';
        }
        
        return $response;
    }
}
