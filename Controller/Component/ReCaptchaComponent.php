<?php
class ReCaptchaComponent extends Component {
	public $error;
	public $Controller;

	public function initialize(Controller $controller, $settings = array()) {
		$this->Controller = $controller;
	}

	public function verify() {
		if (isset($this->Controller->request->data['recaptcha_challenge_field']) && isset($this->Controller->request->data['recaptcha_response_field'])) {
			//TODO: https://github.com/CakeDC/recaptcha/blob/755daeaeac18442df9074c5634b61b26ba505c0e/Controller/Component/RecaptchaComponent.php#L149
		}
		$this->error = 'Missing form fields';
		return false;
	}
}
