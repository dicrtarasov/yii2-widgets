<?php
/*
 * @copyright 2019-2022 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 04.01.22 18:31:58
 */

declare(strict_types = 1);
namespace dicr\widgets;

use function ob_get_clean;

/**
 * Виджет выбора количества.
 */
class QuantitySelector extends InputWidget
{
    /** @var string кнопки по сторонам от поля ввода */
    public const BUTTONS_MODE_ASIDE = 'aside';

    /** @var string кнопки в отдельной панели */
    public const BUTTONS_MODE_PANEL = 'panel';

    /** @var string схема кнопок */
    public string $buttonsMode = self::BUTTONS_MODE_ASIDE;

    /** @var string контент кнопки минус */
    public string $buttonMinusContent = '-';

    /** @var string контент кнопки плюс */
    public string $buttonPlusContent = '+';

    /** @var ?int минимальное значение */
    public ?int $min = 1;

    /** @var ?int|null максимальное значение */
    public ?int $max = 99999;

    /** @var ?int шаг */
    public ?int $step = 1;

    /**
     * @inheritDoc
     */
    public function init() : void
    {
        parent::init();

        Html::addCssClass($this->options, 'widget-quantity-selector');
    }

    /**
     * @inheritDoc
     */
    public function run(): string
    {
        QuantitySelectorAsset::register($this->view);

        ob_start();
        echo Html::beginTag('section', $this->options);

        if ($this->buttonsMode === self::BUTTONS_MODE_ASIDE) {
            echo Html::button($this->buttonMinusContent, ['class' => 'button minus']);
        }

        $inputOptions = [
            'class' => 'input',
            'min' => $this->min,
            'max' => $this->max,
            'step' => $this->step
        ];

        echo $this->hasModel() ?
            Html::activeInput('number', $this->model, $this->attribute, $inputOptions) :
            Html::input('number', $this->name, $this->value, $inputOptions);

        if ($this->buttonsMode === self::BUTTONS_MODE_ASIDE) {
            echo Html::button($this->buttonPlusContent, ['class' => 'button plus']);
        } elseif ($this->buttonsMode === self::BUTTONS_MODE_PANEL) {
            echo Html::beginTag('div', ['class' => 'controls']);
            echo Html::button($this->buttonMinusContent, ['class' => 'button minus']);
            echo Html::button($this->buttonPlusContent, ['class' => 'button plus']);
            echo Html::endTag('div');
        }

        echo Html::endTag('section');

        return ob_get_clean();
    }
}
