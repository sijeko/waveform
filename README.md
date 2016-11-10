Convert waveform to png
=======================

This project is based on [boyhagemann Waveform](https://github.com/boyhagemann/Waveform).

Usage
-----

You must have installed [ffmpeg](http://ffmpeg.org/)

Create an object from Writer class with path to music as parameter

```php
use Sijeko\Waveform\Writer;
 
$w = new Writer('ogg.ogg');
```

Using 
```php
$w->getImage()
``` 
you get image in browser.

Using
```php
$w->saveImage('save_as.png')
```
you save image. 