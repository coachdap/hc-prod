<?php

/**
 * Provides the configuration for constructing an Autogenerate Modal
 */
return [
	/*
	 * ID unique across all platforms and  integrations
	 */
	'id' => 'hubspot-autogenerate',
	/*
	 * Display title in Add New list
	 */
	'title' => __('Hubspot Signup Form','ninja-forms-hubspot'),
	/*
	 * Short description inside the Add New box
	 */
	'templateDesc' => __('Create a fully customizable but ready-to-use Hubspot signup form.','ninja-forms-hubspot'),
	/*
	 *
	 */
	'type' => 'ad',
	/*
	 * Title inside the modal when it pops up
	 */
	'modalTitle' => __('Hubspot Signup Form','ninja-forms-hubspot'),
	'modalContent' =>
	'<p style="margin-top:0px;">'.__('To generate a new form simply click on the button','ninja-forms-hubspot').'.</p>'
	. '<p>'.__('The form will build itself and and after that you can finalize the styling to your liking','ninja-forms-hubspot').'.</p>'
];
