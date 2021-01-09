<?php
/*
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 09.01.21 20:29:59
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
            $this->placeholder['class'] = array_merge(
                (array)($this->placeholder['class'] ?: []), ['placeholder']
            );
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
        CustomSelectAsset::register($this->view);

        ob_start();
        echo Html::beginTag('section', $this->options);

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
            ];
        }

        return [
            'label' => (string)($item['label'] ?? ''),
            'encode' => (bool)($item['encode'] ?? false),
            'class' => empty($item['class']) ? null : $item['class']
        ];
    }

    /**
     * Рендерит кнопку раскрытия элемента с текущим значением.
     *
     * @return string
     */
    protected function renderButton(): string
    {
        // текущее значение модели
        $currentValue = $this->hasModel() ?
            (string)Html::getAttributeValue($this->model, $this->attribute) :
            (string)$this->value;

        // активный элемент
        $item = $this->items[$currentValue] ?? $this->placeholder;

        // если не задан placeholder, то создаем пустой элемент
        if ($item === null) {
            $item = [
                'label' => '',
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
            echo $this->renderItem('', $this->placeholder, 'ph');
        }

        $index = 0;
        foreach ($this->items as $value => $item) {
            echo $this->renderItem((string)$value, $item, $index++);
        }

        echo Html::endTag('datalist');

        return ob_get_clean();
    }

    /**
     * Рендерит элемент.
     *
     * @param string|int|null $value
     * @param array $item
     * @param ?int $index суффикс ID элемента ввода
     * @return string
     */
    protected function renderItem(string $value, array $item, $index = null): string
    {
        // определяем название поля ввода и значение
        if ($this->hasModel()) {
            $inputName = Html::getInputName($this->model, $this->attribute);
            $currentValue = (string)Html::getAttributeValue($this->model, $this->attribute);
        } else {
            $inputName = $this->name;
            $currentValue = (string)$this->value;
        }

        $id = $index === null ? null : $this->id . '-' . $index;

        ob_start();

        if ($id !== null) {
            echo Html::radio($inputName, $currentValue === $value, [
                'id' => $id,
                'value' => $value
            ]);
        }

        $label = $item['encode'] ? Html::esc($item['label']) : $item['label'];
        if ($label === '') {
            $label = '&nbsp;';
        }

        echo Html::label($label, $id, [
            'class' => $item['class'],
        ]);

        return ob_get_clean();
    }
}
