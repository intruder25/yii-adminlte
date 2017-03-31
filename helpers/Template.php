<?php
namespace madedwi\yii2adminlte\helpers;
use Yii;
class Template
{
    public static function skinClass()
    {
        /** @var \dmstr\web\AdminLteAsset $bundle */
        $bundle = Yii::$app->assetManager->getBundle('adminlte\AdminLteAsset');
        return $bundle->skin;
    }

    public static function body(){
        return "hold-transition ".self::skinClass()." sidebar-mini";
    }

    public static function bodyFixed(){
        return "hold-transition ".self::skinClass()." fixed sidebar-mini";
    }

    public static function bodyBoxed(){
        return "hold-transition ".self::skinClass()." layout-boxed sidebar-mini";
    }

    public static function bodyCollapse(){
        return "hold-transition ".self::skinClass()." sidebar-collapse sidebar-mini";
    }


}
