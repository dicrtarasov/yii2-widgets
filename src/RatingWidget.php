<?php
/*
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 22.08.20 15:29:07
 */

declare(strict_types = 1);
namespace dicr\widgets;

use dicr\helper\Inflector;
use Yii;
use yii\base\InvalidConfigException;

use function is_numeric;
use function ob_get_clean;

/**
 * Отображает рейтинг звездочками.
 */
class RatingWidget extends Widget
{
    /** @var string тэг виджета */
    public $tag = 'span';

    /** @var float значение 1..5 */
    public $value;

    /** @var ?int кол-во отзывов */
    public $count;

    /** @var bool сделать микроразметку */
    public $schema;

    /** @var bool показывать текст */
    public $showText = false;

    /**
     * @inheritDoc
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();

        // если значение не установлено, то не отображаем виджет
        if (isset($this->value)) {
            if (! is_numeric($this->value) || ($this->value < 0) || ($this->value > 5)) {
                throw new InvalidConfigException('value');
            }

            $this->value = (float)round($this->value, 1);
        }

        if (isset($this->count)) {
            if (! is_numeric($this->count) || ($this->count < 0)) {
                throw new InvalidConfigException('count');
            }

            $this->count = (int)$this->count;
        }

        if (isset($this->value)) {
            if (! isset($this->options['title'])) {
                if ($this->value > 0) {
                    $this->options['title'] = sprintf('%.1f', $this->value);
                    if (isset($this->count) && ($this->count > 0)) {
                        $this->options['title'] .= ' - ' . $this->count . ' ' .
                            Inflector::numReviews($this->count);
                    }
                } else {
                    $this->options['title'] = Yii::t('dicr/widgets', 'нет') . ' ' .
                        Yii::t('dicr/widgets', 'отзывов');
                }
            }

            if ($this->schema && ($this->value > 0)) {
                $this->options['itemprop'] = 'reviewRating';
                $this->options['itemscope'] = true;
                $this->options['itemtype'] = 'http://schema.org/Rating';
            }
        }

        Html::addCssClass($this->options, 'dicr-widget-rating');
    }

    /**
     * @inheritDoc
     */
    public function run()
    {
        if (! isset($this->value)) {
            return '';
        }

        RatingAsset::register($this->view);

        ob_start();
        echo Html::beginTag($this->tag, $this->options);

        if ($this->schema && ($this->value > 0)) {
            echo Html::tag('meta', ['itemprop' => 'worstRating', 'content' => 1]);
            echo Html::tag('meta', ['itemprop' => 'bestRating', 'content' => 5]);
            echo Html::tag('meta', ['itemprop' => 'ratingValue', 'content' => $this->value]);
        }

        echo Html::beginTag('span', ['class' => 'rating-stars']);

        for ($i = 1; $i <= 5; $i++) {
            if ($this->value >= $i) {
                $class = 'fas fa-star';
            } elseif ($this->value >= $i - 0.5) {
                $class = 'fas fa-star-half-alt';
            } else {
                $class = 'far fa-star';
            }

            echo Html::tag('i', '', [
                'class' => 'star ' . $class
            ]);
        }

        echo Html::endTag('span');

        if ($this->showText && isset($this->count)) {
            echo Html::tag('span',
                '(' .
                (($this->count > 0) ?
                    Yii::$app->formatter->asInteger($this->count) :
                    Yii::t('dicr/widgets', 'нет')
                ) . ' ' . Yii::t('dicr/widgets', 'отзывов') . ')', [
                    'class' => 'rating-count'
                ]);
        }

        echo Html::endTag($this->tag);

        return ob_get_clean();
    }
}
