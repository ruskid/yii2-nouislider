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

 * Check http://refreshless.com/nouislider/ for options.
 * Check https://refreshless.com/nouislider/events-callbacks/ for events.


### Main Slider

Can be configured the way you want. This slider is very simple it doesn't do anything special.
You need to define your own event handlers if you want to update the hidden input's value on change, slide or update etc.

```php

use ruskid\nouislider\Slider;

echo $form->field($model, 'price')->widget(Slider::className(), [
    'pluginOptions' => [
        'start' => [20],
        'connect' => false,
        'range' => [
            'min' => 0,
            'max' => 100
        ]
    ]
]);

echo Slider::widget([
    'name' => 'test',
    'value' => 50,
    'events' => [
        Slider::NOUI_EVENT_CHANGE => new \yii\web\JsExpression('function( values, handle ) {'
                . ' alert("changed"); }'),
        Slider::NOUI_EVENT_START => new \yii\web\JsExpression('function( values, handle ) {'
                . ' alert("start sliding"); }'),
        Slider::NOUI_EVENT_END => new \yii\web\JsExpression('function( values, handle ) {'
                . ' alert("end sliding"); }'),
        Slider::NOUI_EVENT_UPDATE => new \yii\web\JsExpression('function( values, handle ) {'
                . ' alert("updated"); }'),
        Slider::NOUI_EVENT_SET => new \yii\web\JsExpression('function( values, handle ) {'
                . ' alert("set"); }'),
        Slider::NOUI_EVENT_SLIDE => new \yii\web\JsExpression('function( values, handle ) {'
                . ' alert("slided"); }'),
    ],
    'pluginOptions' => [
        'start' => [20],
        'connect' => false,
        'range' => [
            'min' => 0,
            'max' => 100
        ]
    ]
]);
```

### Sliders with default behavior

You can use some of the sliders inside sliders directory and create your own. Extend Main Slider.

**Pull request your sliders!**

```php

echo $form->field($model, 'price_min')->widget(OneHandleSlider::className(), [
    'valueContainerId' => 'price_min-container',
    'pluginOptions' => [
        'start' => [20],
        'connect' => false,
        'range' => [
            'min' => 0,
            'max' => 100
        ]
    ]
]);


echo $form->field($model, 'price_max')->widget(OneHandleSlider::className(), [
    'valueContainerId' => 'price_max-container',
    'pluginOptions' => [
        'start' => [20],
        'connect' => false,
        'range' => [
            'min' => 0,
            'max' => 100
        ]
    ]
]);

<div>Price min: <span id='price_min-container'></span></div>
<div>Price max: <span id='price_max-container'></span></div>

echo $form->field($model, 'price')->widget(TwoHandleSlider::className(), [
    'lowerValueContainerId' => 'price_min-container',
    'upperValueContainerId' => 'price_max-container',
    'pluginOptions' => [
        'start' => [20, 50],
        'connect' => false,
        'range' => [
            'min' => 0,
            'max' => 100
        ]
    ]
]);
```
