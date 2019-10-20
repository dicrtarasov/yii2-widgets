<?php
namespace dicr\widgets\redactor;

use yii\base\Action;

/**
 * @author Nghia Nguyen <yiidevelop@hotmail.com>
 * @since 2.0
 */
class FileUploadAction extends Action
{
    /**
     * run
     */
    function run()
    {
        $ret = [];

        if (isset($_FILES)) {
            $model = new FileUploadModel();
            $ret = $model->upload();
        }

        return $ret;
    }

}
