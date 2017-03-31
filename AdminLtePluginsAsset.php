<?php
namespace madedwi\yii2adminlte;

use yii\web\AssetBundle;


class AdminLtePluginsAsset extends AssetBundle{
    public $sourcePath = '@bower/AdminLTE/plugins';
    public $js = [
        'slimScroll/jquery.slimscroll.min.js',
        'fastclick/fastclick.js',
    ];

    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
