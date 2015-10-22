<?php
class ReCaptcha {
	public $apiUrl = 'https://www.google.com/recaptcha/api/siteverify';
	private $privateKey;

	protected function _getApiResponse($challenge, $response, $ip = null) {
		if (empty($ip)) {
			$ip = env('REMOTE_ADDR');
		}
		$Socket = new HttpSocket();
		$site_secret = Configure::read('ReCaptcha.site_secret');
		return $Socket->post($this->apiUrl, array(
			'privatekey' => $site_secret,
			'remoteip' => $ip,
			'challenge' => $challenge,
			//$this->Controller->request->data['recaptcha_challenge_field'],
			'response' => $response,
			//$this->Controller->request->data['recaptcha_response_field']
		));
	}
}
