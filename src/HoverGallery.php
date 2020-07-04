<?php
/**
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 04.07.20 09:27:14
 */

declare(strict_types = 1);
namespace dicr\widgets;

use dicr\helpers\ArrayHelper;
use dicr\helpers\Html;
use yii\base\InvalidConfigException;
use function get_class;
use function is_array;
use function is_string;
use function ob_get_clean;
use function ob_start;

/**
 * Виджет галереи изображений, переключающихся при наведении мышки.
 *
 * @noinspection PhpUnused
 */
class HoverGallery extends Widget
{
    /** @var string корневой тег галереи */
    public $tag = 'figure';

    /**
     * @var string[]|array[] картинки
     *
     * Каждый элемент может быть либо:
     * - string url - картинки
     * - array [0 => url картинки, остальные - опции для Html::img]
     */
    public $images;

    /** @var float соотношение сторон картинок */
    public $ratio = 4 / 3;

    /**
     * @inheritDoc
     * @throws InvalidConfigException
     * @throws InvalidConfigException
     * @throws InvalidConfigException
     */
    public function init()
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
            'padding-bottom' => (int)round(100 / $this->ratio) . '%'
        ]);

        Html::addCssClass($this->options, 'dicr-widgets-hover-gallery');
    }

    /**
     * @inheritDoc
     */
    public function run()
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
    protected function renderSlides()
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
    protected function renderSlide(array $options)
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
