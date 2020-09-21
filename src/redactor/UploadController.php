<?php
/*
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 22.09.20 01:33:37
 */

declare(strict_types = 1);
namespace dicr\widgets\redactor;

use dicr\widgets\RedactorModule;
use yii\filters\ContentNegotiator;
use yii\web\Controller;
use yii\web\Response;

/**
 * Контроллер загрузки файлов.
 *
 * @property-read RedactorModule $module
 */
class UploadController extends Controller
{
    /** @inheritDoc */
    public $enableCsrfValidation = false;

    /**
     * @inheritDoc
     */
    public function behaviors() : array
    {
        return [
            [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ],
            ]
        ];
    }

    /**
     * @inheritDoc
     */
    public function actions() : array
    {
        return [
            'file' => FileUploadAction::class,
            'image' => ImageUploadAction::class,
            'image-json' => ImageManagerJsonAction::class,
            'file-json' => FileManagerJsonAction::class,
        ];
    }
}
