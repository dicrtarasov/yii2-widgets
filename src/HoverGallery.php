<?php
/**
 * @copyright 2019-2019 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license proprietary
 * @version 20.10.19 10:01:24
 */

declare(strict_types = 1);
namespace dicr\widgets;

use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use function get_class;
use function is_array;
use function is_string;

/**
 * Виджет галлереи избражений, переключающихся при наведении мышки.
 */
class HoverGallery extends Widget
{
    /** @var array опции тэга виджета */
    public $options;

    /** @var string корневой тег галлереи */
    public $tag = 'figure';

    /**
     * @var string[]|array[] картинки
     *
     * Каждый элемент может быть либо:
     * - string url -каринки
     * - array 0 => url каринки, остальные - опции для Html::img
     */
    public $images;

    /** @var float соотношение сторон картинок */
    public $ratio = 4 / 3;

    /**
     * {@inheritDoc}
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\base\InvalidConfigException
     * @see \yii\base\Widget::init()
     */
    public function init()
    {
        parent::init();

        // проверяем тег
        $this->tag = trim($this->tag);
        if (empty($this->tag)) {
            throw new InvalidConfigException('tag');
        }

        // проверяем артинки
        foreach ($this->images as $i => &$image) {
            if (empty($image)) {
                unset($this->images[$i]);
            } elseif (is_array($image)) {
                if (empty($image[0])) {
                    throw new InvalidConfigException('не указан адрес картиинки в элементе 0 параметров');
                }
            } elseif (is_string($image)) {
                $image = [$image];
            } else {
                throw new InvalidConfigException('неизвестный тип image: ' . get_class($image));
            }
        }

        unset($image);

        // соотношение сторон
        $this->ratio = (float)$this->ratio;
        if ($this->ratio <= 0) {
            throw new InvalidConfigException('ratio');
        }

        // резервируем место для картинки заданного соотношения
        Html::addCssStyle($this->options, [
            'padding-bottom' => round(100 / $this->ratio) . '%'
        ]);

        Html::addCssClass($this->options, 'dicr-widgets-hovergallery');
    }

    /**
     * {@inheritDoc}
     * @see \yii\base\Widget::run()
     */
    public function run()
    {
        if (empty($this->images)) {
            return '';
        }

        $this->registerAssets();

        ob_start();

        echo Html::beginTag($this->tag, $this->options);
        $this->renderSlides();
        echo Html::endTag($this->tag);

        return ob_get_clean();
    }

    /**
     * Регистрирует ресурсы.
     */
    protected function registerAssets()
    {
        HoverGalleryAsset::register($this->view);
    }

    /**
     * Рендерит слайды.
     */
    protected function renderSlides()
    {
        if (empty($this->images)) {
            return;
        }

        echo Html::beginTag('div', ['class' => 'gallery-slides']);

        foreach ($this->images as $image) {
            $this->renderSlide($image);
        }

        echo Html::endTag('div');
    }

    /**
     * Рендерит слайд.
     *
     * @param array $options 0 - url картинки, остальное - опции картинки
     */
    protected function renderSlide(array $options)
    {
        $src = ArrayHelper::remove($options, 0);
        if (empty($src)) {
            return;
        }

        Html::addCssClass($options, 'gallery-image');

        echo Html::beginTag('div', ['class' => 'gallery-slide']);
        echo Html::img($src, $options);
        echo Html::tag('div', '', ['class' => 'gallery-label']);
        echo Html::endTag('div');
    }
}
