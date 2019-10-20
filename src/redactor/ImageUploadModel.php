<?php
namespace dicr\widgets\redactor;

/**
 * @author Nghia Nguyen <yiidevelop@hotmail.com>
 * @since 2.0
 */
class ImageUploadModel extends FileUploadModel
{
    public function rules()
    {
        return [
            ['files', 'each', 'rule' => ['file', 'extensions' => \Yii::$app->controller->module->imageAllowExtensions]]
        ];
    }

}