<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 12.08.21 22:01:18
 */

declare(strict_types = 1);
namespace dicr\widgets;

use function array_combine;
use function ob_get_clean;
use function ob_start;
use function range;

/**
 * Отображает ввод рейтинга звездочками.
 */
class RatingInput extends InputWidget
{
    /** @var string тэг виджета */
    public $tag = 'span';

    /**
     * @inheritDoc
     */
    public function init() : void
    {
        parent::init();

        Html::addCssClass($this->options, 'dicr-widget-rating-input');
    }

    /**
     * @inheritDoc
     */
    public function run() : string
    {
        RatingInputAsset::register($this->view);

        ob_start();
        echo Html::beginTag($this->tag, $this->options);

        $range = range(1, 5);
        $items = array_combine($range, $range);

        // значение поля ввода
        $inputValue = $this->hasModel() ? (int)$this->model->{$this->attribute} : (int)$this->value;

        $options = [
            'tag' => false,
            'item' => static function ($index, $label, $name, $checked, $value) use ($inputValue) : string {
                $input = Html::radio($name, $checked, ['value' => $value]);
                $value = (int)$value;

                return Html::label($input, null, [
                    'class' => ['fa-star', ($value <= $inputValue) ? 'fas' : 'far'],
                    'title' => $label
                ]);
            }
        ];

        echo $this->hasModel() ?
            Html::activeRadioList($this->model, $this->attribute, $items, $options) :
            Html::radioList($this->name, $this->value, $items, $options);

        echo Html::endTag($this->tag);
        return ob_get_clean();
    }
}
