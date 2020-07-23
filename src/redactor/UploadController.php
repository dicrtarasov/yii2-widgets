<?php
/**
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 23.07.20 21:31:29
 */

/*
 * @author Nghia Nguyen <yiidevelop@hotmail.com>
 * @since 2.0
 */

declare(strict_types = 1);
namespace dicr\widgets\redactor;

use yii\filters\ContentNegotiator;
use yii\web\Controller;
use yii\web\Response;

/**
 * Контроллер загрузки файлов.
 *
 * @noinspection PhpUnused
 */
class UploadController extends Controller
{
    /** @inheritDoc */
    public $enableCsrfValidation = false;

    /**
     * @return array
     */
    public function behaviors()
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
     * @return array
     */
    public function actions()
    {
        return [
            'file' => FileUploadAction::class,
            'image' => ImageUploadAction::class,
            'image-json' => ImageManagerJsonAction::class,
            'file-json' => FileManagerJsonAction::class,
        ];
    }
}
