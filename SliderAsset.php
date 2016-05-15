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

    public $sourcePath = '@bower/nouislider/distribute';    
    public function init() {
        $this->css[] = YII_DEBUG ? 'nouislider.css' : 'nouislider.min.css';
        $this->js[] = YII_DEBUG ? 'nouislider.js' : 'nouislider.min.js';
        parent::init();
    }

}
