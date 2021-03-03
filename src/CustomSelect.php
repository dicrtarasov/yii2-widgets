<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 03.03.21 12:13:05
 */

declare(strict_types = 1);
namespace dicr\widgets;

use yii\base\InvalidConfigException;

use function is_array;
use function is_scalar;
use function ob_get_clean;
use function ob_start;

/**
 * Альтернативный элемент select.
 */
class CustomSelect extends InputWidget
{
    /** @var string[]|array[] ассоциативный массив значений value => item */
    public $items;

    /** @var ?array|string элемент пустого значения */
    public $placeholder;

    /**
     * @inheritDoc
     * @throws InvalidConfigException
     */
    public function init(): void
    {
        parent::init();

        // placeholder
        if ($this->placeholder !== null) {
            $this->placeholder = $this->parseItem($this->placeholder);
        }

        // items
        if (empty($this->items)) {
            $this->items = [];
        } elseif (! is_array($this->items)) {
            throw new InvalidConfigException('items');
        }

        foreach ($this->items as &$item) {
            $item = $this->parseItem($item);
        }

        unset($item);

        Html::addCssClass($this->options, 'widget-custom-select');
    }

    /**
     * @inheritDoc
     */
    public function run(): string
    {
        //CustomSelectAsset::register($this->view);
        CustomSelectAsset::register($this->view);

        ob_start();
        echo Html::beginTag('section', $this->options);

        // скрытый элемент input
        echo $this->renderInput();

        // кнопка раскрытия
        echo $this->renderButton();

        // всплывающий список
        echo $this->renderItems();

        echo Html::endTag('section');   // widget

        return ob_get_clean();
    }

    /**
     * Парсит элемент.
     *
     * @param string|array|null $item
     * @return array
     */
    protected function parseItem($item): array
    {
        if ($item === null || is_scalar($item)) {
            $item = [
                'label' => (string)$item,
                'encode' => true,
                'class' => []
            ];
        }

        return [
            'label' => (string)($item['label'] ?? ''),
            'encode' => (bool)($item['encode'] ?? false),
            'class' => empty($item['class']) ? [] : (array)$item['class']
        ];
    }

    /** @var string */
    private $_currentValue;

    /**
     * Текущее значение ввода.
     *
     * @return string
     */
    protected function currentValue(): string
    {
        if ($this->_currentValue === null) {
            $this->_currentValue = $this->hasModel() ?
                (string)Html::getAttributeValue($this->model, $this->attribute) :
                (string)$this->value;
        }

        return $this->_currentValue;
    }

    /**
     * Рендерит скрытый элемент input
     *
     * @return string
     */
    protected function renderInput(): string
    {
        return $this->hasModel() ?
            Html::activeHiddenInput($this->model, $this->attribute) :
            Html::hiddenInput($this->name, $this->value);
    }

    /**
     * Рендерит кнопку раскрытия элемента с текущим значением.
     *
     * @return string
     */
    protected function renderButton(): string
    {
        // текущее значение модели
        $currentValue = $this->currentValue();

        // активный элемент
        $item = $this->items[$currentValue] ?? $this->placeholder;

        // если не задан placeholder, то создаем пустой элемент
        if ($item === null) {
            $item = [
                'label' => '&nbsp;',
                'encode' => false,
                'class' => ['unknown']
            ];
        }

        return Html::button($this->renderItem($currentValue, $item));
    }

    /**
     * Рендерит список выбора.
     *
     * @return string
     */
    protected function renderItems(): string
    {
        ob_start();
        echo Html::beginTag('datalist');

        if ($this->placeholder !== null) {
            echo $this->renderItem('', $this->placeholder);
        }

        foreach ($this->items as $value => $item) {
            echo $this->renderItem((string)$value, $item);
        }

        echo Html::endTag('datalist');

        return ob_get_clean();
    }

    /**
     * Рендерит элемент.
     *
     * @param string $value
     * @param array $item
     * @return string
     */
    protected function renderItem(string $value, array $item): string
    {
        // определяем название поля ввода и значение
        $currentValue = $this->currentValue();

        ob_start();

        $label = $item['encode'] ? Html::esc($item['label']) : $item['label'];
        if ($label === '') {
            $label = '&nbsp;';
        }

        if ($value === $currentValue) {
            $item['class'] = empty($item['class']) ? [] : (array)$item['class'];
            Html::addCssClass($item, 'selected');
        }

        echo Html::label($label, null, [
            'data-value' => $value,
            'class' => $item['class'] ?: null,
        ]);

        return ob_get_clean();
    }
}
