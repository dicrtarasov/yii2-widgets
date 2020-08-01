<?php
/*
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 02.08.20 02:56:30
 */

/**
 * @author Nghia Nguyen <yiidevelop@hotmail.com>
 * @since 2.0
 */

declare(strict_types = 1);

namespace dicr\widgets\redactor;

/**
 * Class ImageUploadModel
 */
class ImageUploadModel extends FileUploadModel
{
    /**
     * Инициализация.
     */
    public function init()
    {
        parent::init();

        $this->allowedExtensions = $this->module()->imageAllowExtensions;
    }
}
