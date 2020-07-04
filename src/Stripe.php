<?php
/**
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 04.07.20 22:37:37
 */

declare(strict_types = 1);
namespace dicr\widgets;

use yii\helpers\Json;
use function array_merge;
use function ob_get_clean;

/**
 * Лента карточек с прокруткой.
 *
 * @noinspection PhpUnused
 */
class Stripe extends Widget
{
    /** @var string */
    public $title;

    /** @var bool стрелки в заголовке виджета */
    public $titleArrows = false;

    /** @var bool стрелки в теле виджета */
    public $bodyArrows = true;

    /** @var string[] блоки ленты */
    public $slides;

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();

        if (! isset($this->options['id'])) {
            $this->options['id'] = $this->id;
        }

        $this->clientOptions = array_merge([
            'autoplay' => false,
            'autoplaySpeed' => 5000,
            'prevArrow' => '.' . $this->id . '-prev',
            'nextArrow' => '.' . $this->id . '-next',
            'slidesToShow' => 4,
            'slidesToScroll' => 4,
            'responsive' => [
                [
                    'breakpoint' => 1199,
                    'settings' => [
                        'slidesToShow' => 3,
                        'slidesToScroll' => 3
                    ]
                ],
                [
                    'breakpoint' => 991,
                    'settings' => [
                        'slidesToShow' => 2,
                        'slidesToScroll' => 2
                    ]
                ],
                [
                    'breakpoint' => 575,
                    'settings' => [
                        'slidesToShow' => 1,
                        'slidesToScroll' => 1
                    ]
                ],
            ]
        ], $this->clientOptions);

        Html::addCssClass($this->options, 'widget-stripe');
    }

    /**
     * @inheritDoc
     */
    public function run()
    {
        if (empty($this->slides)) {
            return '';
        }

        StripeAsset::register($this->view);

        $this->view->registerJs(
            '$("#' . $this->id . ' .stripe-slides").slick(' . Json::encode($this->clientOptions) . ');'
        );

        ob_start();
        echo Html::beginTag('section', $this->options);
        echo $this->renderHead();
        echo $this->renderBody();
        echo Html::endTag('section');
        return ob_get_clean();
    }

    /**
     * Рендерит шапку.
     *
     * @return string
     */
    protected function renderHead()
    {
        if (empty($this->title) && ! $this->titleArrows) {
            return '';
        }

        ob_start();
        echo Html::beginTag('div', ['class' => 'stripe-head']);

        if (! empty($this->title)) {
            echo Html::tag('div', $this->title, ['class' => 'title']);
        }

        if ($this->titleArrows) {
            echo $this->renderArrows();
        }

        echo Html::endTag('div');
        return ob_get_clean();
    }

    /**
     * Рендерит тело.
     *
     * @return string
     */
    protected function renderBody()
    {
        ob_start();
        echo Html::beginTag('div', ['class' => 'stripe-body']);
        echo Html::beginTag('div', ['class' => 'stripe-slides']);

        foreach ($this->slides as $slide) {
            echo $slide;
        }

        echo Html::endTag('div');

        if ($this->bodyArrows) {
            echo $this->renderArrows();
        }

        echo Html::endTag('div');
        return ob_get_clean();
    }

    /**
     * Рендерит стрелки.
     *
     * @return string
     */
    protected function renderArrows()
    {
        ob_start();
        echo Html::beginTag('div', ['class' => 'stripe-arrows']);

        echo Html::a('', 'javascript:', [
            'class' => ['arrow', 'prev', $this->id . '-prev'],
            'title' => 'Назад'
        ]);

        echo Html::a('', 'javascript:', [
            'class' => ['arrow', 'next', $this->id . '-next'],
            'title' => 'Вперед'
        ]);

        echo Html::endTag('div');
        return ob_get_clean();
    }
}
