<?php
/*
 * @copyright 2019-2023 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 21.04.23 11:11:49
 */

declare(strict_types = 1);
namespace dicr\widgets;

use yii\helpers\Json;

/**
 * Class Widget
 */
class Widget extends \yii\bootstrap5\Widget
{
    /**
     * @inheritDoc
     */
    protected function registerPlugin(string $name): void
    {
        $view = $this->getView();
        $id = $this->options['id'];

        if ($this->clientOptions !== false) {
            $options = empty($this->clientOptions) ? '' : Json::htmlEncode($this->clientOptions);
            $js = "jQuery('#$id').$name($options);";
            $view->registerJs($js);
        }

        $this->registerClientEvents();
    }
}
