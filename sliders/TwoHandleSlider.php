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
 * Two handle slider example
 *
 * @author Victor Demin <demmbox@gmail.com>
 */
class TwoHandleSlider extends Slider {

    /**
     * @var string Id of container with lower value selected
     */
    public $lowerValueContainerId;

    /**
     * @var string Id of container with upper value selected
     */
    public $upperValueContainerId;

    /**
     * @var string Character separating values in hidden input. Used on 2 handle case.
     */
    public $valueSeparator = '|';

    /**
     * Init slider. 
     */
    public function init() {
        parent::init();

        //Preload start options from input's value
        $this->pluginOptions['start'] = $this->getStartOptions();
    }

    /**
     * Run Two Handler Slider
     */
    public function run() {
        $this->registerUpdateEvent();
        $this->registerSlideEvent();
        $this->registerChangeEvent();

        parent::run();
    }

    /**
     * Start option is mandatory and it must be input value or pluginOptions[start]
     * @return mixed
     */
    protected function getStartOptions() {
        $inputValue = $this->hasModel() ?
                $this->model->{$this->attribute} : $this->value;

        if ($inputValue) {
            $exploded = explode($this->valueSeparator, $inputValue);

            if (!empty($exploded[0]) && !empty($exploded[1])) {
                return [$exploded[0], $exploded[1]];
            }
        }

        return $this->pluginOptions['start'];
    }

    /**
     * Sync container ids with slider
     */
    protected function registerUpdateEvent() {
        $this->events[self::NOUI_EVENT_UPDATE] = new JsExpression(
                "function( values, handle ) {
  
            if('$this->lowerValueContainerId'){
                document.getElementById('$this->lowerValueContainerId').innerHTML = values[0];
            }

            if('$this->upperValueContainerId'){
                document.getElementById('$this->upperValueContainerId').innerHTML = values[1];
            }  
        }");
    }

    /**
     * Sync input with slider
     */
    protected function registerSlideEvent() {
        $inputId = $this->options['id'];

        $this->events[self::NOUI_EVENT_SLIDE] = new JsExpression(
                "function( values, handle ) {
            var input = document.getElementById('$inputId');
            input.value = values[0] + '$this->valueSeparator' + values[1];
        }");
    }

    /**
     * Trigger input change event on change
     */
    protected function registerChangeEvent() {
        $inputId = $this->options['id'];
        list($start, $end) = $this->getStartOptions();

        $this->events[self::NOUI_EVENT_CHANGE] = new JsExpression(
                "function( values, handle ) {
            if($start != values[0] || $end != values[1]){
                var input = document.getElementById('$inputId');
                input.dispatchEvent(new Event('change'));
            }
        }");
    }

}
