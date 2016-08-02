<?php
App::uses('ReCaptchaToken', 'ReCaptcha.Lib');
class ReCaptchaHelper extends Helper {
	public $uses = ['Html'];
	public static $includedScript = false;
	public function display($secureToken = false) {
		$site_key = Configure::read('ReCaptcha.site_key');
		if (empty($site_key)) {
			return 'ReCaptcha Not Configured';
		}
		// Use Secure Token setup
		$secure_token = $secureToken ? sprintf('data-stoken="%s"', ReCaptchaToken::secureToken()) : '';
		if (!self::$includedScript) {
			self::$includedScript = true;
			$script = '<script src="https://www.google.com/recaptcha/api.js?onload=captchaCallBack&render=explicit" async defer></script>';
			$script .= '
				<script>
					var captchaCallBack = function(){
					    $(".g-recaptcha").each(function(index, el){
					        grecaptcha.render(el, {
					            "sitekey" : "' . $site_key . '"
					        });
					    });
					};
				</script>
			';
		} else {
			$script = '';
		}
		return sprintf('<div class="g-recaptcha" data-sitekey="%s" %s></div>%s', $site_key, $secure_token, $script);
	}
}
