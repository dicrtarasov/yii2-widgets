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

            Html::tag('div', Html::img($src, $options) . Html::tag('div', '', ['class' => 'label']),
                ['class' => 'slide']);
        }

        echo Html::endTag($this->tag);
        return ob_get_clean();
    }
}
