<?php
/**
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 04.07.20 12:53:41
 */

declare(strict_types = 1);
namespace dicr\widgets\redactor;

use dicr\widgets\RedactorModule;
use Yii;
use yii\base\Action;
use yii\helpers\FileHelper;
use yii\web\HttpException;
use function count;
use function is_array;

/**
 * Class FileManagerJsonAction
 */
class FileManagerJsonAction extends Action
{
    /**
     * @throws HttpException
     */
    public function init()
    {
        if (! Yii::$app->request->isAjax) {
            throw new HttpException(403, 'This action allow only ajaxRequest');
        }
    }

    /**
     * Модуль редактора.
     *
     * @return RedactorModule
     */
    protected function module()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->controller->module;
    }

    /**
     * @return array|null
     */
    public function run()
    {
        $config = ['recursive' => true];
        if ($this->module()->imageAllowExtensions !== null) {
            $onlyExtensions = array_map(static function($ext) {
                return '*.' . $ext;
            }, $this->module()->imageAllowExtensions);

            $config['only'] = $onlyExtensions;
        }

        $filesPath = FileHelper::findFiles($this->module()->saveDir, $config);

        if (is_array($filesPath) && count($filesPath)) {
            $result = [];

            foreach ($filesPath as $filePath) {
                $url = $this->module()->getUrl(pathinfo($filePath, PATHINFO_BASENAME));
                $fileName = pathinfo($filePath, PATHINFO_FILENAME);

                $result[] = [
                    'title' => $fileName,
                    'name' => $fileName,
                    'url' => $url,
                    'size' => Yii::$app->formatter->asShortSize(filesize($filePath)),
                    'id' => count($result) + 1
                ];
            }

            return $result;
        }

        return null;
    }
}
