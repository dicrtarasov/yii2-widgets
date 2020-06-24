<?php
/**
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 24.06.20 15:59:54
 */

declare(strict_types = 1);
namespace dicr\widgets;

use dicr\asset\AutocompleteAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\widgets\InputWidget;
use function array_merge;

/**
 * Виджет авто-подсказок при вводе.
 *
 * @link https://www.devbridge.com/sourcery/components/jquery-autocomplete/
 * @noinspection PhpUnused
 */
class AutocompleteWidget extends InputWidget
{
    /** @var array опции скрипта */
    public $clientOptions = [];

    /**
     * @inheritDoc
     *
     * @throws \yii\base\InvalidConfigException
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

        $this->view->registerJs(
            "$('#{$this->options['id']}').devbridgeAutocomplete(" . Json::encode($this->clientOptions) . ');'
        );

        $type = ArrayHelper::remove($this->options, 'type', 'search');
        return $this->renderInputHtml($type);
    }
}
