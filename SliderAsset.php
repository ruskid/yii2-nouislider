<?php

/**
 * @copyright Copyright Victor Demin, 2014
 * @license https://github.com/ruskid/yii2-nouislider/LICENSE
 * @link https://github.com/ruskid/yii2-nouislider#readme
 */

namespace ruskid\nouislider;

use yii\web\AssetBundle;

/**
 * Asset bundle for the noUiSlider js.
 *
 * @author Victor Demin <demin@trabeja.com>
 */
class SliderAsset extends AssetBundle {

    public $sourcePath = '@npm/nouislider/distribute';
    public $js = [
        'nouislider.min.js'
    ];
    public $css = [
        'nouislider.min.css'
    ];

    public function init() {
        if (YII_DEBUG) {
            $this->css = ['nouislider.css'];
            $this->js = ['nouislider.js'];
        }
        parent::init();
    }

}
