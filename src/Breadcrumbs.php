<?php
/*
 * @copyright 2019-2022 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 04.01.22 18:27:53
 */

declare(strict_types = 1);
namespace dicr\widgets;

use yii\helpers\Url;

use function array_key_last;
use function array_unshift;
use function array_values;
use function is_array;
use function is_scalar;
use function ob_get_clean;
use function ob_start;

/**
 * Хлебные крошки.
 */
class Breadcrumbs extends \yii\bootstrap5\Breadcrumbs
{
    /** @inheritDoc */
    public $homeLink = [
        'label' => '<i class="fas fa-home"></i>',
        'encode' => false,
        'url' => '/'
    ];

    /** @var bool генерировать микроразметку */
    public bool $schema = true;

    /**
     * @inheritDoc
     */
    public function init(): void
    {
        parent::init();

        // коррекция ссылок
        foreach ($this->links as $i => &$link) {
            if (empty($link)) {
                unset($this->links[$i]);
            } elseif (is_scalar($link)) {
                $link = ['label' => $link];
            }
        }

        unset($link);

        Html::addCssClass($this->options, 'widget-breadcrumbs');
    }

    /**
     * @inheritDoc
     */
    public function run(): string
    {
        if (empty($this->links)) {
            return '';
        }

        BreadcrumbsAsset::register($this->view);

        // делаем копию ссылок
        $links = $this->links;

        // из последней ссылки удаляем url
        $lastIndex = array_key_last($this->links);
        if (is_array($this->links[$lastIndex])) {
            unset($this->links[$lastIndex]['url']);
        }

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
    public function renderSchema(): string
    {
        if (empty($this->links)) {
            return '';
        }

        $links = $this->links;
        if (! empty($this->homeLink)) {
            array_unshift($links, $this->homeLink);
        }

        $items = [];

        foreach (array_values($links) as $pos => $link) {
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
