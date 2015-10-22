ReCaptcha
=========

This plugin borrows ideas from the CakeDC plugin [recaptcha](https://github.com/CakeDC/recaptcha) and makes use of slushie's [recaptcha-secure-token](https://github.com/slushie/recaptcha-secure-token) library to generate a secure token (please note the inherent security flaws in the secure token algorithm on the recaptcha-secure-token readme). It uses v2 of the recaptcha API and widget.

Because it uses secure token, you do not need to manually add each domain name to your list of allowed domains -- just generate an API key and you're done.

[ReCaptcha documentation](https://developers.google.com/recaptcha/intro)

Installation
============

```
git submodule add git@github.com:chrisjohnson/CakePHP-Plugin-ReCaptcha.git app/Plugin/ReCaptcha
git submodule update --init --recursive
```

Setup
=====

To use the ReCaptcha plugin, include the following two lines in your `app/Config/bootstrap.php` file.

```php
Configure::write('ReCaptcha.site_key', 'your-public-api-key');
Configure::write('ReCaptcha.site_secret', 'your-private-api-key');
```

Don't forget to replace the placeholder text with your actual keys!

Keys can be obtained for free from the [Recaptcha website](http://www.google.com/recaptcha).

Then include the Component and Helper:

```php
public $components = ['ReCaptcha.ReCaptcha'];
public $helpers = ['ReCaptcha.ReCaptcha'];
```

In the view simply call the helper's `display()` method to render the ReCaptcha input:

```php
echo $this->ReCaptcha->display();
```

To check the result simply do something like this in your controller:

```php
if ($this->request->is('post')) {
	if ($this->ReCaptcha->verify()) {
		// do something, save you data, login, whatever
	} else {
		// display the error
		$this->Session->setFlash($this->ReCaptcha->error);
	}
}
````
