<?php
namespace dicr\widgets;

use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Виджет галлереи избражений, переключающихся при наведении мышки.
 *
 * @author Igor (Dicr) Tarasov <develop@dicr.org>
 * @version 2019
 */
class HoverGallery extends Widget
{
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

    /**
     * {@inheritDoc}
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
        foreach ($this->images as $i => $image) {
            if (empty($image)) {
                unset($this->images[$i]);
            } elseif (is_array($image)) {
                if (empty($image[0])) {
                    throw new InvalidConfigException('не указан адрес картиинки в элементе 0 параметров');
                }
            } elseif (is_string($image)) {
                $this->images[$i] = [$image];
            } else {
                throw new InvalidConfigException('неизвестный тип image: ' . get_class($image));
            }
        }

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

        HoverGalleryAsset::register($this->view);

        ob_start();
        echo Html::beginTag($this->tag, $this->options);

        foreach ($this->images as $image) {
            $src = ArrayHelper::remove($image, 0);
            $options = $image;
            Html::addCssClass($options, 'image');

            Html::tag('div',
                Html::img($src, $options) .
                Html::tag('div', '', ['class' => 'label']),
                ['class' => 'slide']
            );
        }

        echo Html::endTag($this->tag);
        return ob_get_clean();
    }
}