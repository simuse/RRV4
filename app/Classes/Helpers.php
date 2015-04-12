<?php

namespace App\Classes;

class Helpers {

	/**
	 * Generate random string
	 *
	 * @param  integer $length
	 * @return string
	 */
	public static function randomString($length = 10)
	{

		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';

		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}

		return $randomString;

	}

	/**
	 * Turn timestamp into human-readable time diffence
	 *
	 * @param  timestamp $time
	 * @return string
	 */
	public static function timeAgo($time)
	{

		$time = time() - $time;

	    $tokens = array (
	        31536000 => 'year',
	        2592000 => 'month',
	        604800 => 'week',
	        86400 => 'day',
	        3600 => 'hour',
	        60 => 'minute',
	        1 => 'second'
	    );

	    foreach ($tokens as $unit => $text) {

	        if ($time < $unit) continue;

	        $numberOfUnits = floor($time / $unit);

	        return $numberOfUnits . ' ' . $text . (($numberOfUnits>1) ? 's' : '');

	    }
	}

}
