<?php
declare(strict_types = 1);
/**
 * @copyright 2019-2019 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license proprietary
 * @version 20.10.19 21:25:48
 */

namespace dicr\widgets\redactor;

use Yii;

/**
 * @author Nghia Nguyen <yiidevelop@hotmail.com>
 * @since 2.0
 */
class ImageUploadModel extends FileUploadModel
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['files', 'each', 'rule' => ['file', 'extensions' => Yii::$app->controller->module->imageAllowExtensions]]
        ];
    }

}
