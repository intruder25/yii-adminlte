<?php
namespace madedwi\yii2adminlte;

use yii\web\AssetBundle;


class ChartJsPluginAsset extends AssetBundle{
    public $sourcePath = '@bower/AdminLTE/plugins';
    public $js = [
        'chartjs/Chart.min.js'
    ];

    public $depends = [
        'madedwi\yii2adminlte\AdminLtePluginsAssets',
    ];
}
