Screenshoter
============

Simple PHP Class for Screenshot'er API http://www.screenshoter.com/

**Screenshot'er** is the quick and easy way of taking screenshots of any website. You can even select which device size to use, great for demonstrating responsive web design. 

Sample
------

```php

/* Take screenshots of PHP.net */

require_once('screenshoter.php');

$website = 'http://php.net/';
$path = './cache/'; // save here

$screen = new Screenshoter($website, $path);

$screen->format('png');

// First: Desktops
$screen->device('desktop');
echo $screen->shoot('desktop.png')."<br/>";

// Second: Tablets
$screen->device('tablet');
echo $screen->shoot('tablet.png')."<br/>";

// Third: Smartphones
$screen->device('smartphone');
echo $screen->shoot('smartphone.png')."<br/>";
```


[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/evandro92/screenshoter/trend.png)](https://bitdeli.com/free "Bitdeli Badge")

