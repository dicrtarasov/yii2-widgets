<?php
/**
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 26.06.20 05:22:08
 */

declare(strict_types = 1);

namespace dicr\widgets;

use yii\helpers\Html;
use yii\widgets\InputWidget;
use function array_combine;
use function ob_get_clean;
use function ob_start;
use function range;

/**
 * Отображает ввод рейтинга звездочками.
 *
 * @noinspection PhpUnused
 */
class RatingInput extends InputWidget
{
    /** @var string тэг виджета */
    public $tag = 'span';

    /**
     * @inheritDoc
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();

        if (! isset($this->options['id'])) {
            $this->options['id'] = $this->id;
        }

        Html::addCssClass($this->options, 'dicr-widget-rating-input');
    }

    /**
     * @inheritDoc
     * @noinspection PhpUnusedParameterInspection
     */
    public function run()
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
            'item' => static function($index, $label, $name, $checked, $value) use ($inputValue) {
                $input = Html::radio($name, $checked, ['value' => $value]);
                $value = (int)$value;

                return Html::label($input, null, [
                    'class' => ['fa-star', $value <= $inputValue ? 'fas' : 'far'],
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
