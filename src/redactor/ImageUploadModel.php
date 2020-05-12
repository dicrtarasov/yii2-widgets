<?php
/**
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license proprietary
 * @version 12.05.20 21:34:30
 */

/**
 * @author Nghia Nguyen <yiidevelop@hotmail.com>
 * @since 2.0
 */

declare(strict_types = 1);

namespace dicr\widgets\redactor;

use Yii;

/**
 * Class ImageUploadModel
 *
 * @noinspection PhpUnused
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
