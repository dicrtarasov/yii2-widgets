<?php
/*
 * @copyright 2019-2022 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 04.01.22 18:19:10
 */

declare(strict_types = 1);
namespace dicr\widgets;

use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

use function gettype;
use function is_array;
use function is_string;
use function ob_get_clean;
use function ob_start;

/**
 * Виджет галереи изображений, переключающихся при наведении мышки.
 */
class HoverGallery extends Widget
{
    /** @var string корневой тег галереи */
    public string $tag = 'figure';

    /**
     * @var string[]|array[] картинки
     *
     * Каждый элемент может быть либо:
     * - string url - картинки
     * - array [0 => url картинки, остальные - опции для Html::img]
     */
    public array $images;

    /** @var float соотношение сторон картинок */
    public float $ratio = 4 / 3;

    /**
     * @inheritDoc
     * @throws InvalidConfigException
     */
    public function init(): void
    {
        parent::init();

        // проверяем тег
        $this->tag = trim($this->tag);
        if (empty($this->tag)) {
            throw new InvalidConfigException('tag');
        }

        // проверяем картинки
        foreach ($this->images as $i => &$image) {
            if (empty($image)) {
                unset($this->images[$i]);
            } elseif (is_array($image)) {
                if (empty($image[0])) {
                    throw new InvalidConfigException('не указан адрес картинки в элементе 0 параметров');
                }
            } elseif (is_string($image)) {
                $image = [$image];
            } else {
                throw new InvalidConfigException('неизвестный тип image: ' . gettype($image));
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
            'padding-bottom' => (int)round(100 / $this->ratio) . '%'
        ]);

        Html::addCssClass($this->options, 'dicr-widgets-hover-gallery');
    }

    /**
     * @inheritDoc
     */
    public function run(): string
    {
        if (empty($this->images)) {
            return '';
        }

        HoverGalleryAsset::register($this->view);

        ob_start();
        echo Html::beginTag($this->tag, $this->options);
        echo $this->renderSlides();
        echo Html::endTag($this->tag);

        return ob_get_clean();
    }

    /**
     * Рендерит слайды.
     *
     * @return string
     */
    protected function renderSlides(): string
    {
        if (empty($this->images)) {
            return '';
        }

        ob_start();
        echo Html::beginTag('div', ['class' => 'gallery-slides']);

        foreach ($this->images as $image) {
            echo $this->renderSlide($image);
        }

        echo Html::endTag('div');

        return ob_get_clean();
    }

    /**
     * Рендерит слайд.
     *
     * @param array $options 0 - url картинки, остальное - опции картинки
     * @return string
     */
    protected function renderSlide(array $options): string
    {
        $src = ArrayHelper::remove($options, 0);
        if (empty($src)) {
            return '';
        }

        Html::addCssClass($options, 'gallery-image');

        ob_start();
        echo Html::beginTag('div', ['class' => 'gallery-slide']);
        echo Html::img($src, $options);
        echo Html::tag('div', '', ['class' => 'gallery-label']);
        echo Html::endTag('div');

        return ob_get_clean();
    }
}
