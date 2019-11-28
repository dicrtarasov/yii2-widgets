<?php
declare(strict_types = 1);
/**
 * @copyright 2019-2019 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license proprietary
 * @version 20.10.19 21:30:17
 */

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
