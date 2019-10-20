<?php
namespace dicr\widgets\redactor;

use yii\web\Response;

/**
 * @author Nghia Nguyen <yiidevelop@hotmail.com>
 * @since 2.0
 */
class UploadController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            [
                'class' => \yii\filters\ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ],
            ]
        ];
    }

    public function actions()
    {
        return [
            'file' => \dicr\widgets\redactor\FileUploadAction::class,
            'image' => \dicr\widgets\redactor\ImageUploadAction::class,
            'image-json' => \dicr\widgets\redactor\ImageManagerJsonAction::class,
            'file-json' => \dicr\widgets\redactor\FileManagerJsonAction::class,
        ];
    }
}
