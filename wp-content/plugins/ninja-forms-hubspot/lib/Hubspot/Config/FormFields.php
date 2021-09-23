<?php
/*
 * Returns a fully configured FormFields in array form
 *
 * Defines all standard fields for the ApiModule
 */
return [
/*
 * Hubspot does not differentiate between standard and common fields as some
 * other integrations do.  The API retrieves ALL fields, both custom and
 * standard when making a request for fields.  Because of this, the standard
 * fields are kept empty and all the fields are retrieved and stored by the
 * Integrating Plugin via the ApiModule's SDK
 */
];
