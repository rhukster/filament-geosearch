# Filament GeoSearch

Forked from https://github.com/heloufir/filament-leaflet-geosearch to add customizable providers w/APIs and other tweaks.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/rhukster/filament-geosearch.svg?style=flat-square)](https://packagist.org/packages/rhukster/filament-geosearch)
[![Total Downloads](https://img.shields.io/packagist/dt/rhukster/filament-geosearch.svg?style=flat-square)](https://packagist.org/packages/rhukster/filament-geosearch)

This package provides a Filament Form Field integration of the LeafLet GeoSearch package [https://github.com/smeijer/leaflet-geosearch](https://github.com/smeijer/leaflet-geosearch)

![Filament GeoSearch](filament-geosearch.png)


## Installation

You can install the package via composer:

```bash
composer require rhukster/filament-geosearch
```

You need to publish assets used by this package:
```bash
php artisan vendor:publish --tag=filament-geosearch-assets
```

If you are using this package with `Filament administration`, add this lines to the `boot()` function of your `AppServiceProvider`
```bash
public function boot()
{
    // ...
    Filament::serving(function () {
        // ... 
        Filament::registerStyles([
            asset('filament/assets/css/leaflet.css'),
            asset('filament/assets/css/geosearch.css'),
        ]);
        Filament::registerScripts([
            asset('filament/assets/js/leaflet.js'),
            asset('filament/assets/js/geosearch.umd.js'),
        ], true);
        // ...
    });
    // ...
}
```

**Important: Don't forget the `true` flag on the `registerScripts` to make the scripts loaded before Filament core scripts**

- If you are using this package without `Filament administration` (only with `Filament forms`), you can include the styles and scripts into your html layout.

## Usage
### Model configuration
In your model you need to add the location column cast:
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MyModel extends Model
{
    // ...

    protected $casts = [
        'location' => 'object'
    ];
}
```

**Important:** The `location` column must have the `longText` type in your migration (see the example below)
```php
// ...
Schema::create('my_models', function (Blueprint $table) {
    // ...
    $table->longText('location');
    // ...
});
// ...
```

### Field usage
Now that you have configured your model, you can use the `LeafletInput` into your Filament Resource form schema:

```php
use Heloufir\FilamentLeafLetGeoSearch\Forms\Components\LeafletInput;

public static function form(Form $form): Form
{
    return $form
        ->schema([
            // ...
            LeafletInput::make('location')
                ->setStyle('bar') // Here you can set: bar|button layout style (default: bar)
                ->autoComplete(true) // Here you enable/disable: true|false (default: true)
                ->autoCompleteDelay(250) // Here you can set the debounce delay in ms (default: 250)
                ->setMapHeight(300) // Here you can specify a map height in pixels, by default the height is equal to 200
                ->setZoomControl(false) // Here you can enable/disable zoom control on the map (default: true)
                ->setScrollWheelZoom(false) // Here you can enable/disable zoom on wheel scroll (default: true)
                ->setZoomLevel(3) // Here you can change the default zoom level (when the map is loaded for the first time), default value is 10
                ->provider('MapBox') // Here you can provide a custom provider as supported by leaflet-geosearch - https://github.com/smeijer/leaflet-geosearch#about, (default: 'OpenStreetMap') 
                ->apiKey('YOUR_API_KEY') // Here you should provide your public API key for whatever provider you have configured (if required)
                ->required()
            // ...
        ]);
}
```

### Good to know
The object stored into the `location` database column have the following format:

```
{
  x: Number, // lon,
  y: Number, // lat,
  label: String, // formatted address
  bounds: [
    [Number, Number], // s, w - lat, lon
    [Number, Number], // n, e - lat, lon
  ],
  raw: {}, // raw provider result
}
```

## Support

For fast support, please join the [**Filament** community](https://filamentphp.com/discord) discord and send me a message in this channel [#leaflet-geosearch](https://discord.com/channels/883083792112300104/1001049950983041044)

## Credits

- [heloufir](https://github.com/heloufir)
- [All Contributors](https://github.com/rhukster/filament-geosearch/graphs/contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
