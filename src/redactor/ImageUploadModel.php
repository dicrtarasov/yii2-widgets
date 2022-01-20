<?php
/*
 * @copyright 2019-2022 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 20.01.22 03:53:06
 */

declare(strict_types=1);

namespace dicr\widgets\redactor;

use dicr\widgets\RedactorModule;

/**
 * Class ImageUploadModel
 *
 * @property-read RedactorModule $module
 */
class ImageUploadModel extends FileUploadModel
{
    /**
     * Инициализация.
     */
    public function init(): void
    {
        parent::init();

        $this->allowedExtensions = $this->module->imageAllowExtensions;
    }
}
