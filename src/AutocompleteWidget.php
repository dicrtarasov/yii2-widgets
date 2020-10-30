<?php
/*
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 30.10.20 21:35:12
 */

declare(strict_types = 1);
namespace dicr\widgets;

use dicr\asset\AutocompleteAsset;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

use function array_merge;

/**
 * Виджет авто-подсказок при вводе.
 *
 * @link https://www.devbridge.com/sourcery/components/jquery-autocomplete/
 */
class AutocompleteWidget extends InputWidget
{
    /**
     * @inheritDoc
     */
    public function init() : void
    {
        parent::init();

        Html::addCssClass($this->options, 'dicr-widgets-autocomplete');

        if (! isset($this->options['id'])) {
            $this->options['id'] = $this->id;
        }

        $this->clientOptions = array_merge([
            'triggerSelectOnValidInput' => false,
            'onSelect' => new JsExpression('function(suggestion) {
                $(this).trigger("change");
            }')
        ], $this->clientOptions);
    }

    /**
     * @inheritDoc
     */
    public function run() : string
    {
        AutocompleteAsset::register($this->view);

        $this->registerPlugin('devbridgeAutocomplete');

        $type = ArrayHelper::remove($this->options, 'type', 'search');

        return $this->renderInputHtml($type);
    }
}
