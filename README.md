# wanotif
Automatic service for sending whatsapp messages through third parties

## Installation

```
composer require ifirmawan/wanotif:dev-master
```

## Example

```
<?php

require_once __DIR__ . '/vendor/autoload.php';

use ifirmawan\Wanotif\Messenger;

$config['api_key'] = 'YOUR_API_KEY';
$config['url'] = 'YOUR_URL_WEB_API';
$msg = new Messenger($config);
$res = $msg->setMessage('081393504913','Test WA notif')->sendMessage()->getResponse();

//debugging a response
print_r($res, TRUE);

```