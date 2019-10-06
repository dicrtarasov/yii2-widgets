<?php
namespace dicr\widgets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Ресурсы виджеа автоподсказки.
 *
 * @link https://github.com/devbridge/jQuery-Autocomplete
 * @link https://www.devbridge.com/sourcery/components/jquery-autocomplete/
 * @author Igor (Dicr) Tarasov <develop@dicr.org>
 * @version 2019
 */
class AutocompleteAsset extends AssetBundle
{
    /** @var string */
    public $sourcePath = __DIR__ . '/assets';

    /** @var string[] */
    public $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/jquery.devbridge-autocomplete/1.4.10/jquery.autocomplete.min.js'
    ];

    /** @var string[] */
    public $css = [
        'autocomplete.css'
    ];

    /** @var string[] */
    public $depends = [
        JqueryAsset::class
    ];
}
