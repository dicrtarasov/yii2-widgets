<?php
/**
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 04.07.20 12:54:30
 */

declare(strict_types = 1);
namespace dicr\widgets\redactor;

use yii\base\Action;

/**
 * Upload action
 */
class FileUploadAction extends Action
{
    /**
     * Run
     */
    public function run()
    {
        $ret = [];

        if (isset($_FILES)) {
            $model = new FileUploadModel();
            $ret = $model->upload();
        }

        return $ret;
    }
}
