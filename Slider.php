<?php

/**
 * @copyright Copyright Victor Demin, 2014
 * @license https://github.com/ruskid/yii2-nouislider/LICENSE
 * @link https://github.com/ruskid/yii2-nouislider#readme
 */

namespace ruskid\nouislider;

use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;
use ruskid\nouislider\SliderAsset;

/**
 * Yii noUiSlider input widget
 *
 * @author Victor Demin <demmbox@gmail.com>
 */
class Slider extends InputWidget {

    /**
     * @var string Slider Tag ID and Javascript variable 
     */
    public $sliderId;

    /**
     * @see http://refreshless.com/nouislider/
     * @var array noUiSlider config options in array format
     */
    public $pluginOptions;

    /**
     * @var string Slider tag
     */
    public $sliderTag = 'div';

    /**
     * @var array Slider div options. Can be used to customize sliders
     */
    public $sliderTagOptions = ['class' => 'ruskid-nouislider'];

    /**
     * Slider events. Array key is slider event name and value is JsExpression.
     * @see https://refreshless.com/nouislider/events-callbacks/
     * @var array[EVENT_UPDATE => new JsExpression()]
     */
    public $events = [];

    const NOUI_EVENT_UPDATE = 'update';
    const NOUI_EVENT_SLIDE = 'slide';
    const NOUI_EVENT_CHANGE = 'change';
    const NOUI_EVENT_SET = 'set';
    const NOUI_EVENT_START = 'start';
    const NOUI_EVENT_END = 'end';
    const JS_NAME_POSTFIX = '_nouislider';

    /**
     * Init slider. 
     */
    public function init() {
        parent::init();

        if (!$this->sliderId) { //remove special characters   
            $removedcharacters = preg_replace('/[^a-zA-Z]+/', '', $this->id);
            $this->sliderId = $removedcharacters . self::JS_NAME_POSTFIX;
        }
    }

    /**
     * @inheritdoc
     */
    public function run() {
        $view = $this->getView();
        SliderAsset::register($view);

        $this->renderSlider();
        $this->renderInput();
    }

    /**
     * Will render slider div
     */
    protected function renderSlider() {
        $view = $this->getView();

        $jsOptions = Json::encode($this->pluginOptions);

        $view->registerJs("function init_{$this->sliderId}() {
            var {$this->sliderId} = document.getElementById('" . $this->sliderId . "');
            noUiSlider.create({$this->sliderId}, {$jsOptions});
            {$this->getEventsJsString()}
        }", View::POS_END);

        $view->registerJs("init_{$this->sliderId}();");

        $this->sliderTagOptions['id'] = $this->sliderId;
        echo Html::tag($this->sliderTag, '', $this->sliderTagOptions);
    }

    /**
     * @return string
     */
    protected function getEventsJsString() {
        $eventJs = '';
        foreach ($this->events as $eventName => $expression) {
            $eventJs .= "{$this->sliderId}.noUiSlider.on('$eventName', $expression);";
        }
        return $eventJs;
    }

    /**
     * Will render input for the slider value
     */
    protected function renderInput() {
        echo $this->hasModel() ?
                Html::activeHiddenInput($this->model, $this->attribute, $this->options) :
                Html::hiddenInput($this->name, $this->value, $this->options);
    }

}
