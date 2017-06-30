<?php
namespace madedwi\yii2adminlte;

use yii\web\AssetBundle;

class MorrisChartPluginsAsset extends AssetBundle{
    public $sourcePath = '@bower/AdminLTE/plugins';
    public $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js',
        'morris/morris.min.js'
    ];

    public $depends = [
        'madedwi\yii2adminlte\AdminLtePluginsAssets',
    ];
}
?>
