<?php
App::uses('ReCaptchaToken', 'ReCaptcha.Lib');
class ReCaptchaHelper extends Helper {
	public $uses = ['Html'];
	public function display() {
		$site_key = Configure::read('ReCaptcha.site_key');
		if (empty($site_key)) {
			return 'ReCaptcha Not Configured';
		}
		$secure_token = ReCaptchaToken::secureToken();
		$script = '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
		return sprintf('<div class="g-recaptcha" data-sitekey="%s" data-stoken="%s"></div>%s', $site_key, $secure_token, $script);
	}
}
