## XML transaction


## Signature

### Add signature to XML

1. Start the server

```
$ cd xml-transaction/src
composer install
$ php -S localhost:8080
```

2. Visit `http://localhost:8080/`



### Useful functions
*  Generates a new private key: [openssl_pkey_new](https://www.php.net/manual/en/function.openssl-pkey-new.php)

 ```
 $new_key_pair = openssl_pkey_new(array(
     "private_key_bits" => 2048,
     "private_key_type" => OPENSSL_KEYTYPE_RSA,
 ));
 ```

* Exports key as a PEM encoded string: [openssl_pkey_export](https://www.php.net/manual/en/function.openssl-pkey-export.php)

```
$public_key_pem = openssl_pkey_export($new_key_pair, $private_key_pem)['key'];
```

### To create a signed XML file we will use the [xmlseclibs](https://github.com/robrichards/xmlseclibs) library

```
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '906a84df04cea2aa72f40b5f787e49f22d4c2f19492ac310e8cba5b96ac8b64115ac402c8cd292b8a03482574915d1a8') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```
