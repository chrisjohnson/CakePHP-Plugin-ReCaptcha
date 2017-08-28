<?php
App::uses('ReCaptcha', 'ReCaptcha.Lib');
class ReCaptchaComponent extends Component {
	public $error;
	public $Controller;

	public function initialize(Controller $controller, $settings = []) {
		$this->Controller = $controller;
	}

	public function verify($ip = null, $hostname = null) {
		if (isset($this->Controller->request->data['g-recaptcha-response'])) {
			$result = ReCaptcha::verify($this->Controller->request->data['g-recaptcha-response'], $ip, $hostname);
			if (!$result) {
				$this->error = 'Invalid recaptcha';
			}
			return $result;
		}
		$this->error = 'Missing recaptcha response';
		return false;
	}
}
