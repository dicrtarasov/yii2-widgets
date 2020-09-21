<?php
/*
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 22.09.20 01:46:37
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
    public function init() : void
    {
        parent::init();

        $this->allowedExtensions = $this->getModule()->imageAllowExtensions;
    }
}
