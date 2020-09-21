<?php
/*
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 22.09.20 01:34:39
 */

declare(strict_types = 1);
namespace dicr\widgets\redactor;

use dicr\widgets\RedactorModule;
use yii\base\Action;

/**
 * Базовая акция.
 *
 * @property-read UploadController $controller
 * @property-read RedactorModule $module
 */
abstract class RedactorAction extends Action
{
    /**
     * Модуль.
     *
     * @return RedactorModule
     */
    public function getModule()
    {
        return $this->controller->module;
    }
}
