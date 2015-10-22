<?php
class ReCaptchaToken {
	public static $_client;
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
	public static function secureToken($sessionId = null) {
		if (empty($sessionId)) {
			$sessionId = uniqid('recaptcha-session');
		}
		return self::client()->secureToken($sessionId);
	}
}
