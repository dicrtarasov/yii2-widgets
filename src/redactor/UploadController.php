<?php
declare(strict_types = 1);
/**
 * @copyright 2019-2019 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license proprietary
 * @version 20.10.19 21:28:36
 */

namespace dicr\widgets\redactor;

use yii\filters\ContentNegotiator;
use yii\web\Controller;
use yii\web\Response;

/**
 * @author Nghia Nguyen <yiidevelop@hotmail.com>
 * @since 2.0
 */
class UploadController extends Controller
{
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
