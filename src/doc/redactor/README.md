yii2-redactor
=============
Extension redactor for Yii2 Framework.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist yiidoc/yii2-redactor "*"
```

 or
```
 "yiidoc/yii2-redactor": "*"
```

To the *require* section of your composer.json.

Configure
-----------------

Add to config file (config/web.php or common\config\main.php) 

```
    'modules' => [
        'redactor' => 'yii\redactor\RedactorModule',
    ],
```
Or if you want to change the upload directory to path/to/upload/folder default value `@webroot/uploads`

```
    'modules' => [
        'redactor' => [
            'class' => 'yii\redactor\RedactorModule',
            'uploadDir' => '@webroot/path/to/uploadfolder',
            'uploadUrl' => '@web/path/to/uploadfolder',
            'imageAllowExtensions'=>['jpg','png','gif']
        ],
    ],
```

Note: You need to create uploads folder and chmod and set security for folder upload
reference: [Protect Your Uploads Folder with .htaccess](http://tomolivercv.wordpress.com/2011/07/24/protect-your-uploads-folder-with-htaccess/),
[How to Setup Secure Media Uploads](http://digwp.com/2012/09/secure-media-uploads/)

Config view/form

```
<?= $form->field($model, 'body')->widget(\yii\redactor\widgets\Redactor::className()) ?>
```

Or not use ActiveField

```
<?= \yii\redactor\widgets\Redactor::widget([
    'model' => $model,
    'attribute' => 'body'
]) ?>
```    
Or config advanced redactor reference [Docs](http://imperavi.com/redactor/docs/)

```
<?= $form->field($model, 'body')->widget(\yii\redactor\widgets\Redactor::className(), [
    'clientOptions' => [
        'imageManagerJson' => ['/redactor/upload/image-json'],
        'imageUpload' => ['/redactor/upload/image'],
        'fileUpload' => ['/redactor/upload/file'],
        'lang' => 'zh_cn',
        'plugins' => ['clips', 'fontcolor','imagemanager']
    ]
])?>
```

Bummer! I was tested on my project but not have many time to write the document on file and usage.
If you have problem, then please create [issue](https://github.com/yiidoc/yii2-redactor/issues)

Thanks!
