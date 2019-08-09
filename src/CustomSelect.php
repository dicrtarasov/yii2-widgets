<?php
namespace dicr\widgets;

use yii\base\InvalidConfigException;
use yii\bootstrap4\Html;
use yii\bootstrap4\InputWidget;

/**
 * Альтернативный элемент select.
 *
 * @author Igor (Dicr) Tarasov <develop@dicr.org>
 * @version 2019
 */
class CustomSelect extends InputWidget
{
    /** @var string[] ассоциативный массив значений val => label */
    public $values;

    /** @var string placeholder */
    public $placeholder;

    /**
     * {@inheritDoc}
     * @see \yii\widgets\InputWidget::init()
     */
    public function init()
    {
        Html::addCssClass($this->options, 'dicr-widgets-customselect');

        if (empty($this->values)) {
            $this->values = [];
        } elseif (!is_array($this->values)) {
            throw new InvalidConfigException('values');
        }

        if (isset($this->placeholder)) {
            $this->clientOptions['placeholder'] = $this->placeholder;
        }

        parent::init();
    }

    /**
     * {@inheritDoc}
     * @see \yii\base\Widget::run()
     */
    public function run()
    {
        $this->view->registerAssetBundle(CustomSelectAsset::class);
        $this->registerPlugin('dicrCustomSelect');

        ob_start();
        echo Html::beginTag('div', $this->options);

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

        if (!empty($this->values)) {
            foreach ((array)$this->values as $val => $label) {
                echo Html::tag('div', Html::encode($label), [
                    'class' => 'dicr-widgets-customselect-item',
                    'data-value' => $val
                ]);
            }
        }

        echo Html::endTag('div');   // popup
        echo Html::endTag('div');   // widget
        return ob_get_clean();
    }
}