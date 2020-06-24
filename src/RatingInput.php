<?php
/**
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 24.06.20 22:50:07
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

        Html::addCssClass($this->options, 'dicr-widget-rating-input');
    }

    /**
     * @inheritDoc
     */
    public function run()
    {
        RatingInputAsset::register($this->view);

        ob_start();
        echo Html::beginTag($this->tag, $this->options);

        $range = range(1, 5);
        $items = array_combine($range, $range);

        $options = [
            'tag' => false,
            'unselect' => '0',
            'itemOptions' => [
                'label' => '',
                'labelOptions' => ['class' => 'far fa-star']
            ]
        ];

        echo $this->hasModel() ?
            Html::activeRadioList($this->model, $this->attribute, $items, $options) :
            Html::radioList($this->name, $this->value, $items, $options);

        echo Html::endTag($this->tag);
        return ob_get_clean();
    }
}
