<?php
/**
 * @copyright 2019-2019 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license proprietary
 * @version 06.10.19 19:44:55
 */

declare(strict_types = 1);
namespace dicr\widgets;

use dicr\asset\AutocompleteAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

/**
 * Виджет автоподсказок при вооде.
 *
 * @link https://www.devbridge.com/sourcery/components/jquery-autocomplete/
 */
class AutocompleteWidget extends InputWidget
{
    /** @var array опции скрипта */
    public $clientOptions = [];

    /**
     * {@inheritDoc}s
     *
     * @throws \yii\base\InvalidConfigException
     * @see \yii\base\Widget::init()
     */
    public function init()
    {
        parent::init();

        Html::addCssClass($this->options, 'dicr-widgets-autocomplete');

        if (! isset($this->options['id'])) {
            $this->options['id'] = $this->id;
        }
    }

    /**
     * {@inheritDoc}
     * @throws \yii\base\InvalidConfigException
     * @see \yii\base\Widget::run()
     */
    public function run()
    {
        $this->view->registerAssetBundle(AutocompleteAsset::class);

        $this->view->registerJs("$('#{$this->options['id']}').devbridgeAutocomplete(" .
                                Json::encode($this->clientOptions) . ')');

        $type = ArrayHelper::remove($this->options, 'type', 'search');

        return $this->renderInputHtml($type);
    }
}
