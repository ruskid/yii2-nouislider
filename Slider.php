<?php

/**
 * @copyright Copyright Victor Demin, 2014
 * @license https://github.com/ruskid/yii2-nouislider/LICENSE
 * @link https://github.com/ruskid/yii2-nouislider#readme
 */

namespace ruskid\nouislider;

use yii\helpers\Html;
use yii\widgets\InputWidget;
use ruskid\nouislider\SliderAsset;

/**
 * Yii noUiSlider input widget
 *
 * @author Victor Demin <demmbox@gmail.com>
 */
class Slider extends InputWidget {

    /**
     * @var array noUiSlider config in array format
     */
    public $pluginOptions;

    /**
     * @var string Id of container with lower value selected
     */
    public $lowerValueContainerId = '';

    /**
     * @var string Id of container with higher value selected
     */
    public $upperValueContainerId = '';

    /**
     * @var string
     */
    const SLIDER_ID_POSTFIX = '_nouislider';

    /**
     * @inheritdoc
     */
    public function run() {
        $view = $this->getView();
        SliderAsset::register($view);

        $this->renderSlider();
        $this->renderInput();
        //$this->registerUpdateSliderJs();
    }

    /**
     * Will render slider div
     */
    private function renderSlider() {
        $view = $this->getView();
        $sliderId = $this->constructSliderId();
        $jsOptions = json_encode($this->pluginOptions);
        $js = "var $sliderId = document.getElementById('$sliderId'); noUiSlider.create($sliderId, $jsOptions);";
        $view->registerJs($js);

        $sliderTagOptions = [
            'id' => $sliderId,
            'data-input' => $this->options['id'],
            'data-lower-container' => $this->lowerValueContainerId,
            'data-upper-container' => $this->upperValueContainerId
        ];
        echo Html::tag('div', '', $sliderTagOptions);
    }

    /**
     * @return string Get constructed slider id
     */
    private function constructSliderId() {
        return $this->id . self::SLIDER_ID_POSTFIX;
    }

    /**
     * Will render input for the slider value
     */
    private function renderInput() {
        echo $this->hasModel() ?
                Html::activeTextInput($this->model, $this->attribute, $this->options) :
                Html::textInput($this->name, $this->value, $this->options);
    }

    /**
     */
    public function registerUpdateSliderJs() {
       /* $view = $this->getView();
        $sliderId = $this->constructSliderId();

        $js = "$sliderId.noUiSlider.on('update', function( values, handle ) {
            if ( handle ) {
                var inputId = $sliderId.getAttributeNode('data-input').value;
                var lowerContainerId = $sliderId.getAttributeNode('data-lower-container').value;  
                var uppwerContainerId = $sliderId.getAttributeNode('data-upper-container').value;

                


                document.getElementById(inputId).value = values[handle];
            }
            
            valueInput.addEventListener('change', function(){
                range.noUiSlider.set([null, this.value]);
            });
        });";
        $view->registerJs($js);*/
    }

}
