<?php
/*
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 22.09.20 01:40:10
 */

declare(strict_types = 1);
namespace dicr\widgets\redactor;

/**
 * Upload action
 */
class FileUploadAction extends RedactorAction
{
    /**
     * @return array
     */
    public function run() : array
    {
        $ret = [];

        if (isset($_FILES)) {
            $model = new FileUploadModel();
            $ret = $model->upload();
        }

        return $ret;
    }
}
