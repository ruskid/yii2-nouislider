<?php

/**
 * @copyright Copyright Victor Demin, 2014
 * @license https://github.com/ruskid/yii2-nouislider/LICENSE
 * @link https://github.com/ruskid/yii2-nouislider#readme
 */

namespace ruskid\nouislider\sliders;

use yii\web\JsExpression;
use ruskid\nouislider\Slider;

/**
 * One hangle slider example
 *
 * @author Victor Demin <demmbox@gmail.com>
 */
class OneHandleSlider extends Slider {

    /**
     * @var string Id of container with lower value selected
     */
    public $valueContainerId;

    /**
     * Define One handle events
     */
    public function init() {
        parent::init();

        //Preload start optinos from input's value
        $this->pluginOptions['start'] = $this->getStartOption();

        $this->registerUpdateEvent();
        $this->registerChangeEvent();
    }

    /**
     * Start option is mandatory and it must be input value or pluginOptions[start]
     * @return mixed
     */
    protected function getStartOption() {
        $inputValue = $this->hasModel() ?
                $this->model->{$this->attribute} : $this->value;

        if ($inputValue) {
            return $inputValue;
        }

        return is_array($this->pluginOptions) ?
                $this->pluginOptions['start'] : $this->pluginOptions;
    }

    /**
     * Sync container id and hidden input with slider
     */
    protected function registerUpdateEvent() {
        $inputId = $this->options['id'];

        $this->events[self::NOUI_EVENT_UPDATE] = new JsExpression(
                "function( values, handle ) {
  
            if('$this->valueContainerId'){
                document.getElementById('$this->valueContainerId').innerHTML = values[0];
            }

            var input = document.getElementById('$inputId');
            input.value = values[0];
        }");
    }

    /**
     * Trigger input change event on change
     */
    protected function registerChangeEvent() {
        $inputId = $this->options['id'];
        $startValue = $this->getStartOption();

        $this->events[self::NOUI_EVENT_CHANGE] = new JsExpression(
                "function( values, handle ) {

            var sliderValue = values[0];
            if($startValue != sliderValue){
                var input = document.getElementById('$inputId');
                input.dispatchEvent(new Event('change'));
            }
        }");
    }

}
