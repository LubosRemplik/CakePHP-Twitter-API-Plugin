CakePHP Twitter API Plugin
=========================

Requirements
------------
[CakePHP v2.x](https://github.com/cakephp/cakephp)   
[Opauth](https://github.com/LubosRemplik/cakephp-opauth)   
[OauthLib](https://github.com/LubosRemplik/oauth_lib)

How to use it
-------------
1.	Install this plugin for your CakePHP app.   
	Assuming `APP` is the directory where your CakePHP app resides, it's usually `app/` from the base of CakePHP.

	```bash
	cd APP/Plugin
	git clone git://github.com/LubosRemplik/CakePHP-Twitter-API-Plugin.git Twitter
	```

2.  Install required plugins with all dependcies and configuration
	[Opauth](https://github.com/LubosRemplik/cakephp-opauth)

3.  Connect twitter's account with your application http://example.org/auth/twitter

4.  Include needed model in your controller or anywhere you want to

	```php
	$uses = array('Twitter.TwitterStatuses');
	...
	$data = $this->TwitterStatuses->homeTimeline();
	debug ($data);
	```

	```php
	$data = ClassRegistry::init('Twitter.TwitterStatuses')->homeTimeline();
	debug ($data);
	```

Sample
------
Not available, but similar plugin and sample has [CakePHP Google API Plugin](https://github.com/LubosRemplik/CakePHP-Google-API-Plugin).
