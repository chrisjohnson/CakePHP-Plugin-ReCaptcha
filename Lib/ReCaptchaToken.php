<?php
class ReCaptchaToken {
	public static $_client;
	public static $_client_ntp;

	public static function client() {
		if (empty(self::$_client)) {
			require(App::pluginPath('ReCaptcha') . 'Vendor/recaptcha-secure-token/lib/ReCaptchaToken.php');
			self::$_client = new \ReCaptchaSecureToken\ReCaptchaToken([
				'site_key' => Configure::read('ReCaptcha.site_key'),
				'site_secret' => Configure::read('ReCaptcha.site_secret')
			]);
		}

		return self::$_client;
	}

	public static function client_ntp() {
		if (empty(self::$_client_ntp)) {
			require(App::pluginPath('ReCaptcha') . 'Vendor/ntp/src/Client.php');
			require(App::pluginPath('ReCaptcha') . 'Vendor/ntp/src/Socket.php');
			$socket = new \Bt51\NTP\Socket('0.pool.ntp.org', 123);
			self::$_client_ntp = new \Bt51\NTP\Client($socket);
		}

		return self::$_client_ntp;
	}

	// Generate a unique secureToken based on a unique sessionId, and an accurate timestamp. Leave timestamp empty to look to ntp server instead of using local time
	public static function secureToken($sessionId = null, $timestamp = null) {
		if (empty($sessionId)) {
			$sessionId = uniqid('recaptcha-session');
		}
		if (empty($timestamp)) {
			$timestamp = self::client_ntp()->getTime()->getTimestamp() * 1000;
		}
		return self::client()->secureToken($sessionId, $timestamp);
	}
}
