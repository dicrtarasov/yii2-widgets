<?php
/**
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 04.07.20 05:57:32
 */

/**
 * @author Nghia Nguyen <yiidevelop@hotmail.com>
 * @since 2.0
 */

declare(strict_types = 1);

namespace dicr\widgets\redactor;

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

        $this->allowedExtensions = $this->module()->imageAllowExtensions;
    }
}
