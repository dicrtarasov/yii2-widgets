<?php
/*
 * @copyright 2019-2022 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 04.01.22 18:23:49
 */

declare(strict_types = 1);
namespace dicr\widgets\redactor;

/**
 * Upload action
 */
class FileUploadAction extends RedactorAction
{
    /**
     * @inheritDoc
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
