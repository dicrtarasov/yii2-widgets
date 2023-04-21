<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 12.08.21 22:00:46
 */

declare(strict_types = 1);
namespace dicr\widgets;

use yii\helpers\Json;

/**
 * Class InputWidget
 */
class InputWidget extends \yii\bootstrap5\InputWidget
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
