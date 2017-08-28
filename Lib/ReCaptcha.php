<?php
App::uses('HttpSocket', 'Network/Http');
class ReCaptcha {
	public static $apiUrl = 'https://www.google.com/recaptcha/api/siteverify';
	private static $results = [];
	private static $lastResponse = null;

	public static function verify($response, $ip = null, $hostname = null) {
		if (isset(self::$results[$response])) {
			// A response token can only be checked once, so in case of repeat checks in the code we store the result from the request
			$result = self::$results[$response];
		} else {
			if (empty($ip)) {
				$ip = env('REMOTE_ADDR');
			}
			$Socket = new HttpSocket();
			$site_secret = Configure::read('ReCaptcha.site_secret');
			$result = $Socket->post(self::$apiUrl, array(
				'secret' => $site_secret,
				'remoteip' => $ip,
				'response' => $response,
			));
			self::$lastResponse = $result;
			self::$results[$response] = $result;
		}
		$parsed = json_decode($result, true);
		// Verify Google's response
		if ($parsed['success']) {
			// Also verify the hostname if we have it
			if (!empty($hostname)) {
				if (strtolower($hostname) == strtolower($parsed['hostname'])) {
					return true;
				}
			} else {
				return true;
			}
		}

		return false;
	}
}
