<?php

/**
 * @copyright Copyright Victor Demin, 2014
 * @license https://github.com/ruskid/yii2-nouislider/LICENSE
 * @link https://github.com/ruskid/yii2-nouislider#readme
 */

namespace ruskid\nouislider;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;
use ruskid\nouislider\SliderAsset;
use yii\web\JsExpression;

/**
 * Yii noUiSlider input widget
 *
 * @author Victor Demin <demmbox@gmail.com>
 */
class Slider extends InputWidget {

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
     * @var string Id of container with lower value selected
     */
    public $lowerValueContainerId;

    /**
     * @var string Id of container with higher value selected
     */
    public $upperValueContainerId;

    /**
     * @var JsExpression
     */
    public $updateEventExpression;

    /**
     * @var JsExpression
     */
    public $slideEventExpression;

    /**
     * @var string Character separating values in hidden input. Used on 2 handle case.
     */
    public $valueSeparator = '|';

    /**
     * @var string Slider can be accessed by this javasrcipt variable
     */
    public $javascriptSliderId;

    /**
     * @var boolean If slider has 1 or 2 handles
     */
    private $_twoHandleCase = false;

    /**
     * Init slider. 
     */
    public function init() {
        parent::init(); //Check if sldier has 2 handles
        $this->_twoHandleCase = count($this->pluginOptions['start']) === 2;

        if (!$this->updateEventExpression) {
            $this->updateEventExpression = $this->loadDefaultUpdateExpression();
        }

        if (!$this->slideEventExpression) {
            $this->slideEventExpression = $this->loadDefaultSlideExpression();
        }

        if (!$this->javascriptSliderId) { //remove special characters        
            $this->javascriptSliderId = preg_replace('/[^a-zA-Z]+/', '', $this->id);
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
        $this->registerSliderEvents();
    }

    /**
     * Will render slider div
     */
    private function renderSlider() {
        $view = $this->getView();

        $jsOptions = Json::encode($this->pluginOptions);
        $js = "var {$this->javascriptSliderId} = document.getElementById('" . $this->id . "'); "
                . "noUiSlider.create($this->javascriptSliderId, $jsOptions);";

        $view->registerJs($js);

        $this->sliderTagOptions['id'] = $this->id;
        echo Html::tag($this->sliderTag, '', $this->sliderTagOptions);
    }

    /**
     * Will render input for the slider value
     */
    private function renderInput() {
        echo $this->hasModel() ?
                Html::activeHiddenInput($this->model, $this->attribute, $this->options) :
                Html::hiddenInput($this->name, $this->value, $this->options);
    }

    /**
     * Register Slider Update Event 
     */
    private function registerSliderEvents() {
        $js = "{$this->javascriptSliderId}.noUiSlider.on('update', $this->updateEventExpression); "
                . "{$this->javascriptSliderId}.noUiSlider.on('slide', $this->slideEventExpression)";
        $this->getView()->registerJs($js);
    }

    /**
     * Load default slider update expression
     * @return JsExpression
     */
    private function loadDefaultUpdateExpression() {
        return new JsExpression("function( values, handle ) {
            if('$this->lowerValueContainerId'){
                document.getElementById('$this->lowerValueContainerId').innerHTML = values[0];
            }
            if('$this->upperValueContainerId' && '$this->_twoHandleCase'){
                document.getElementById('$this->upperValueContainerId').innerHTML = values[1];
            }
        }");
    }

    /**
     * Load default slider slide expression
     * @return JsExpression
     */
    private function loadDefaultSlideExpression() {
        $inputId = $this->options['id'];
        return new JsExpression("function( values, handle ) {
            var input = document.getElementById('$inputId');
            if('$this->_twoHandleCase'){
                input.value = values[0] + '$this->valueSeparator' + values[1];
            }else{
                input.value = values[0];
            }
        }");
    }

}
