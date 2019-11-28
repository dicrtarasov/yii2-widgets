<?php
/**
 * @copyright 2019-2019 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license proprietary
 * @version 06.10.19 07:49:37
 */

declare(strict_types = 1);
namespace dicr\widgets;

use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;
use function is_array;

/**
 * Альтернативный элемент select.
 */
class CustomSelect extends InputWidget
{
    /** @var string[] ассоциативный массив значений val => label */
    public $values;

    /** @var string placeholder */
    public $placeholder;

    /** @var array опции javascript */
    public $clientOptions = [];

    /**
     * {@inheritDoc}
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\base\InvalidConfigException
     * @see \yii\widgets\InputWidget::init()
     */
    public function init()
    {
        parent::init();

        if (empty($this->options['id'])) {
            $this->options['id'] = $this->id;
        }

        if (empty($this->values)) {
            $this->values = [];
        } elseif (! is_array($this->values)) {
            throw new InvalidConfigException('values');
        }

        if (isset($this->placeholder)) {
            $this->clientOptions['placeholder'] = $this->placeholder;
        }

        Html::addCssClass($this->options, 'dicr-widgets-customselect');
    }

    /**
     * {@inheritDoc}
     * @throws \yii\base\InvalidConfigException
     * @see \yii\base\Widget::run()
     */
    public function run()
    {
        $this->view->registerAssetBundle(CustomSelectAsset::class);

        $this->view->registerJs("$('#{$this->options['id']}').dicrWidgetsCustomSelect(" .
                                Json::encode($this->clientOptions) . ')');

        echo Html::beginTag('section', $this->options);
        $value = null;

        if ($this->hasModel()) {
            echo Html::activeHiddenInput($this->model, $this->attribute);
            $value = Html::getAttributeValue($this->model, $this->attribute);
        } else {
            echo Html::hiddenInput($this->name, $this->value);
            $value = $this->value;
        }

        $label = '';
        $isPlaceholder = false;

        if (isset($value)) {
            /** @noinspection OffsetOperationsInspection */
            $label = $this->values[$value] ?? '';
        } elseif (isset($this->placeholder) && $this->placeholder !== false) {
            $label = $this->placeholder;
            $isPlaceholder = true;
        }

        // видимое значение
        echo Html::tag('div', Html::encode($label), [
            'class' => 'dicr-widgets-customselect-value' . ($isPlaceholder ? ' placeholder' : '')
        ]);

        // всплывающий список
        echo Html::beginTag('div', ['class' => 'dicr-widgets-customselect-popup']);

        if (isset($this->placeholder) && $this->placeholder !== false) {
            echo Html::tag('div', Html::encode($this->placeholder), [
                'class' => 'dicr-widgets-customselect-item placeholder',
                'data-value' => ''
            ]);
        }

        if (! empty($this->values)) {
            foreach ((array)$this->values as $val => $label) {
                echo Html::tag('div', Html::encode($label), [
                    'class' => 'dicr-widgets-customselect-item',
                    'data-value' => $val
                ]);
            }
        }

        echo Html::endTag('div');   // popup
        echo Html::endTag('section');   // widget
    }
}
