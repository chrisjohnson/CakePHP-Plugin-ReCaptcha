<?php
App::uses('ReCaptcha', 'ReCaptcha.Lib');
class ReCaptchaComponent extends Component {
	public $error;
	public $Controller;

	public function initialize(Controller $controller, $settings = array()) {
		$this->Controller = $controller;
	}

	public function verify() {
		if (isset($this->Controller->request->data['g-recaptcha-response'])) {
			return ReCaptcha::verify($this->Controller->request->data['g-recaptcha-response']);
		}
		$this->error = 'Missing recaptcha response';
		return false;
	}
}
