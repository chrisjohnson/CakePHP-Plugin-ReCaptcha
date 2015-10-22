<?php
App::uses('HttpSocket', 'Network/Http');
class ReCaptcha {
	public static $apiUrl = 'https://www.google.com/recaptcha/api/siteverify';
	private static $results = [];

	public static function verify($response, $ip = null) {
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
			self::$results[$response] = $result;
		}
		$parsed = json_decode($result, true);
		return $parsed['success'] == true;
	}
}
