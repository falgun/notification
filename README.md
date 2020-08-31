# Notification

Simple Notification Manager Library.

## Install
 *Please note that PHP 7.4 or higher is required.*

Via Composer

``` bash
$ composer require falgunphp/notification
```

## Usage
```php
<?php
use Falgun\Http\Session;
use Falgun\Notification\Notification;

$notification = new Notification(new Session());

$notification->successNote('Oh Yeah');
$notification->warningNote('Oh ho');
$notification->errorNote('hold up');
// all 3 notification has been saved to $_SESSION

$notes = $notification->flashNotifications(); // to get notifications and remove them from session
// or
$notes = $notification->getNotifications(); // only get notifications and don't remove them

foreach($notes as $note){
	echo $note->getMessage(); // this is the message of the note
	echo $note->getType(); // success or warning or error
}
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
