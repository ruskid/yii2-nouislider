Yii2 noUiSlider Wrapper.
==========
Installation
--------------------------

The preferred way to install this extension is through http://getcomposer.org/download/.

Either run

```sh
php composer.phar require ruskid/yii2-nouislider "dev-master"
```

or add

```json
"ruskid/yii2-nouislider": "dev-master"
```

to the require section of your `composer.json` file.


Usage
--------------------------

Check http://refreshless.com/nouislider/ for options.

```php

use ruskid\nouislider\Slider;

echo $form->field($model, 'maxDistance')
->widget(Slider::className(), [
    'pluginOptions' => [
        'start' => [20, 80],
        'connect' => true,
        'range' => [
            'min' => 0,
            'max' => 100
        ]
    ]
]);
```

```php
echo Slider::widget([
    'name'=>'test',
    'value'=>21,
    'pluginOptions' => [
        'start' => [20, 80],
        'connect' => true,
        'range' => [
            'min' => 0,
            'max' => 100
        ]
    ]
]);
```

