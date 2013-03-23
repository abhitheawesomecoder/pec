#Paypal Express Checkout
**Version: 1.1.1**

	A Payment Gateway Bundle for Laravel.

##Installation
**Artisan**

	php artisan bundle:install pec

**Git Clone**

	git clone http://github.com/abhitheawesomecoder/pec

**Modify application/bundles.php**
```php
return array(
	'pec' => array(
		'handles' => 'pec' // this is mainly for the examples
		
	),
);
```

**Publish Assets**

	php artisan bundle:publish

Now visit http://yoursite.com/index.php/pec and you should see the example products page.

Contact me at abhitheawesomecoder@gmail.com for any queries 

