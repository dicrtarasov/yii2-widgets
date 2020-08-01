<?php
/*
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 02.08.20 02:57:47
 */

declare(strict_types = 1);
namespace dicr\widgets;

use function array_filter;
use function is_numeric;
use function ob_get_clean;

/**
 * Виджет выбора количества.
 */
class QuantitySelector extends InputWidget
{
    /** @var int минимальное значение */
    public $min = 1;

    /** @var int|null максимальное значение */
    public $max = 99999;

    /** @var int шаг */
    public $step = 1;

    /** @var int */
    public $value = 1;

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();

        Html::addCssClass($this->options, 'widget-quantity-selector');
    }

    /**
     * @inheritDoc
     */
    public function run()
    {
        QuantitySelectorAsset::register($this->view);

        ob_start();
        echo Html::beginTag('section', $this->options);
        echo Html::button('−', ['class' => 'button minus']);

        $inputOptions = array_filter([
            'class' => 'input',
            'min' => is_numeric($this->min) ? $this->min : null,
            'max' => is_numeric($this->max) ? $this->max : null,
            'step' => is_numeric($this->step) ? $this->step : null
        ]);

        echo $this->hasModel() ?
            Html::activeInput('number', $this->model, $this->attribute, $inputOptions) :
            Html::input('number', $this->name, $this->value, $inputOptions);

        echo Html::button('+', ['class' => 'button plus']);
        echo Html::endTag('section');
        return ob_get_clean();
    }
}
