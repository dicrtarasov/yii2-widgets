<?php
namespace dicr\widgets;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

/**
 * Автодополнение.
 *
 * @author Igor (Dicr) Tarasov <develop@dicr.org>
 * @version 2019
 * @link https://www.devbridge.com/sourcery/components/jquery-autocomplete/
 */
class Autocomplete extends InputWidget
{
    /** @var array опции скрипта */
    public $clientOptions = [];

    /**
     * {@inheritDoc}s
     * @see \yii\base\Widget::init()
     */
    public function init()
    {
        parent::init();

        Html::addCssClass($this->options, 'dicr-widgets-autocomplete');

        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->id;
        }
    }

    /**
     * {@inheritDoc}
     * @see \yii\base\Widget::run()
     */
    public function run()
    {
        $this->view->registerAssetBundle(AutocompleteAsset::class);

        $this->view->registerJs(
            "$('#{$this->options['id']}').devbridgeAutocomplete(" . Json::encode($this->clientOptions) . ")"
        );

        $type = ArrayHelper::remove($this->options, 'type', 'search');

        return $this->renderInputHtml($type);
    }
}
