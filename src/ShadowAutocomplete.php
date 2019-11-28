<?php
/**
 * @copyright 2019-2019 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license proprietary
 * @version 06.10.19 19:45:17
 */

declare(strict_types = 1);
namespace dicr\widgets;

use dicr\asset\AutocompleteAsset;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\widgets\InputWidget;

/**
 * Автоподсказка по текстовому полю при заполнении значения скрытого поля, например id.
 *
 * @link https://www.devbridge.com/sourcery/components/jquery-autocomplete/
 */
class ShadowAutocomplete extends InputWidget
{
    /** @var string название аттрибута suggestion, значение которого заполняется в скрытое поле */
    public $shadowValueField = 'id';

    /** @var string начальное значение, отображаемое в поле подсказки */
    public $initialDisplayValue = '';

    /** @var array опции скрипта */
    public $clientOptions = [];

    /**
     * {@inheritDoc}s
     *
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\base\InvalidConfigException
     * @see \yii\base\Widget::init()
     */
    public function init()
    {
        parent::init();

        $this->shadowValueField = trim($this->shadowValueField);
        if (empty($this->shadowValueField)) {
            throw new InvalidConfigException('shadowValueField');
        }

        Html::addCssClass($this->options, 'dicr-widgets-shadowautocomplete');

        if (empty($this->options['id'])) {
            $this->options['id'] = $this->id;
        }

        // при изменении подсказки удаляем значение скрытого поля
        $this->clientOptions['onInvalidateSelection'] = new JsExpression("function() {
            $('#{$this->options['id']}-shadow').val('');
        }");

        // при выборе подсказки заполняем значение скрытого поля
        $this->clientOptions['onSelect'] = new JsExpression("function(suggestion) {
            $('#{$this->options['id']}-shadow').val(suggestion.{$this->shadowValueField});
        }");
    }

    /**
     * {@inheritDoc}
     * @throws \yii\base\InvalidConfigException
     * @see \yii\base\Widget::run()
     */
    public function run()
    {
        /** @var string тип поля подсказки */
        $type = ArrayHelper::remove($this->options, 'type', 'search');

        // загружаем плагин
        $this->view->registerAssetBundle(AutocompleteAsset::class);

        // подключаем плагин к видимому полю
        $this->view->registerJs("$('#{$this->options['id']}').devbridgeAutocomplete(" .
                                Json::encode($this->clientOptions) . ')');

        // дополнительно обрабатываем очистку видимого поля
        $this->view->registerJs("$('#{$this->options['id']}').on('change', function() {
                if ($(this).val().trim().length < 1) {
                    $('#{$this->options['id']}-shadow').val('');
                }
            })");

        ob_start();

        // выводим поле скрытое поле ввода для аттрибута модели
        if ($this->hasModel()) {
            echo Html::activeHiddenInput($this->model, $this->attribute, [
                'id' => $this->options['id'] . '-shadow'
            ]);
        } else {
            echo Html::hiddenInput($this->attribute, $this->value, [
                'id' => $this->options['id'] . '-shadow'
            ]);
        }

        // выводим поле для ввода подсказки
        echo Html::input($type, null, $this->initialDisplayValue, $this->options);

        return ob_get_clean();
    }
}
