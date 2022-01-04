<?php
/*
 * @copyright 2019-2022 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 04.01.22 18:24:10
 */

declare(strict_types = 1);
namespace dicr\widgets\redactor;

use dicr\widgets\RedactorModule;
use Exception;
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
    public function getModule(): RedactorModule
    {
        return $this->controller->module;
    }

    /**
     * Выполнение акции.
     *
     * @throws Exception
     */
    abstract public function run(): array;
}
