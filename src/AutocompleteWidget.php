<?php
/**
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 04.07.20 05:57:32
 */

declare(strict_types = 1);
namespace dicr\widgets;

use dicr\assets\AutocompleteAsset;
use dicr\helpers\ArrayHelper;
use dicr\helpers\Html;
use yii\web\JsExpression;
use function array_merge;

/**
 * Виджет авто-подсказок при вводе.
 *
 * @link https://www.devbridge.com/sourcery/components/jquery-autocomplete/
 * @noinspection PhpUnused
 */
class AutocompleteWidget extends InputWidget
{
    /**
     * @inheritDoc
     */
    public function init()
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
    public function run()
    {
        AutocompleteAsset::register($this->view);

        $this->registerPlugin('devbridgeAutocomplete');

        $type = ArrayHelper::remove($this->options, 'type', 'search');

        return $this->renderInputHtml($type);
    }
}
