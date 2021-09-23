<?php
/*
 * Array defining the Action Entity for the Integrating Plugin
 */
return [
	/*
	 * Programtic name, unique across all NF integrations
	 */
	'name' => 'add_to_hubspot',
	/*
	 * Human readable name
	 */
	'nicename' => __('Add To Hubspot','ninja-forms-hubspot'),
	/*
	 * Tags
	 *
	 * Newsletters use `newsletter`; no other tags currently used in monorepo
	 */
	'tags' => [],
	/*
	 * `early` `normal` `late`
	 */
	'timing' => 'normal',
	/*
	 * Baseline is 10; can be higher priority (<10) or lower priority (>10)
	 */
	'priority' => 10
];
