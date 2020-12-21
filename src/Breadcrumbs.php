<?php
/*
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 22.12.20 04:12:57
 */

declare(strict_types = 1);
namespace dicr\widgets;

use yii\base\InvalidConfigException;
use yii\helpers\Url;

use function array_key_last;
use function array_unshift;
use function array_values;
use function ob_get_clean;
use function ob_start;

/**
 * Хлебные крошки.
 */
class Breadcrumbs extends \yii\bootstrap4\Breadcrumbs
{
    /** @inheritDoc */
    public $homeLink = [
        'label' => '<i class="fas fa-home"></i>',
        'encode' => false,
        'url' => '/'
    ];

    /** @var bool генерировать микроразметку */
    public $schema = false;

    /**
     * @inheritDoc
     */
    public function init() : void
    {
        parent::init();

        Html::addCssClass($this->options, 'dicr-widgets-breadcrumbs');
    }

    /**
     * @inheritDoc
     * @throws InvalidConfigException
     */
    public function run() : string
    {
        if (empty($this->links)) {
            return '';
        }

        BreadcrumbsAsset::register($this->view);

        // делаем копию ссылок
        $links = $this->links;

        // из последней ссылки удаляем url
        unset($this->links[array_key_last($this->links)]['url']);

        // рендерим ссылки
        ob_start();
        echo parent::run();

        // восстанавливаем ссылки
        $this->links = $links;

        // рендерим схему
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
        if (empty($this->links)) {
            return '';
        }

        $links = $this->links;
        if (! empty($this->homeLink)) {
            array_unshift($links, $this->homeLink);
        }

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
