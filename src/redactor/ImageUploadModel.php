<?php
/**
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license proprietary
 * @version 21.01.20 18:25:32
 */

declare(strict_types = 1);

namespace dicr\widgets\redactor;

use Yii;

/**
 * @author Nghia Nguyen <yiidevelop@hotmail.com>
 * @since 2.0
 */
class ImageUploadModel extends FileUploadModel
{
    /**
     * Инициализация.
     */
    public function init()
    {
        parent::init();

        $this->allowedExtensions = Yii::$app->controller->module->imageAllowExtensions;
    }
}
