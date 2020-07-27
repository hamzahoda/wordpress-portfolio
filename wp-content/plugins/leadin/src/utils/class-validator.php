<?php

namespace Leadin\utils;

/**
 * Static class containing all the validation functions.
 */
class Validator {
	/**
	 * Return whether the given domain is valid
	 *
	 * @param String $domain Domain to validate.
	 * @return Boolean Returns whether the given domain is valid or not.
	 */
	public static function is_valid_domain( $domain ) {
		return preg_match( '/^(?:[-A-Za-z0-9]+\.)+[A-Za-z]{2,}$/', $domain, $match );
	}
}
