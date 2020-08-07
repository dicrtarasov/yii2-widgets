<?php
/*
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 07.08.20 16:24:46
 */

declare(strict_types = 1);
namespace dicr\widgets;

use yii\base\InvalidConfigException;
use yii\helpers\Url;
use function array_values;
use function ob_get_clean;
use function ob_start;

/**
 * Хлебные крошки.
 */
class Breadcrumbs extends \yii\bootstrap4\Breadcrumbs
{
    /** @var bool генерировать микроразметку */
    public $schema = true;

    /**
     * @inheritDoc
     * @throws InvalidConfigException
     */
    public function run() : string
    {
        ob_start();
        echo parent::run();

        if ($this->schema) {
            echo $this->renderSchema();
        }

        return ob_get_clean();
    }

    /**
     * Рендерит микроразметку.
     *
     * @return string
     */
    public function renderSchema() : string
    {
        $items = [];

        foreach (array_values($this->links) as $pos => $link) {
            if (! empty($link['url']) && ! empty($link['label'])) {
                $items[] = [
                    '@type' => 'ListItem',
                    'position' => $pos + 1,
                    'name' => $link['label'],
                    'item' => Url::to($link['url'], true)
                ];
            }
        }

        return empty($items) ? '' : Html::schema([
            '@context' => 'http://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $items
        ]);
    }
}
