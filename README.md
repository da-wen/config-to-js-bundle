# config-to-js-bundle
[![Build Status](https://travis-ci.org/da-wen/config-to-js-bundle.svg?branch=master)](https://travis-ci.org/da-wen/config-to-js-bundle)

Provides a command to dump defined config to js file.

---

## Installation

### Step 1: Composer

Required in *composer.json*
    
```json
   "dawen/config-to-js-bundle": "~1.0"
```

Run composer update dawen/config-to-js-bundle after modifiering composer.json file.


### Step 2: AppKernel  

In your *app/config/AppKernel.php* file you should activate the bundle by adding it to the array

```php
    $bundles[] = new Dawen\Bundle\ConfigToJsBundle\ConfigToJsBundle();
```

### Step 3: Configuration

```yml
    config_to_js:
      type: 'module'
      output_path: '%kernel.root_dir%/../web/js/app-config.js'
      config:
        imageLocation: 'http://this-is-an-example.com/images'
        appVersion: '1.1.0'
```

If parameter are not defined, default values will be applied.


### Step 4: Run the command  

Go to your console and run

```shell
    bin/console config:js:dump
```

---


## Configuration Parameter Description


*type:*

possible values: module
default value: module
description: This defines for what the dumped code is optimized.


*output_path:*

possible values: a valid string for a filepath
default value: null
description: This parameter defines a path and filename that will be created. If this value is not set, the dumper will throw an error.

*config:*

possible values: array
default value: empty array
description: Here you can create you config vars that should be availabe on your javascript side.

---

## Supported Types/Renderers


*module:*
Your file is includeable by module pattern like this: import appConfig from './ccurrent-folder/web/js/app-config.js'