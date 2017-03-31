<?php
namespace madedwi\yii2adminlte;

use yii\web\AssetBundle;


class AdminLteAsset extends AssetBundle{

    public $sourcePath = '@bower/AdminLTE/dist';
    public $css = [
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css',
    ];

    public $js = [
        'js/app.min.js'
    ];

    public $depends = [
        'adminlte\AdminLtePluginsAsset',
    ];

    public $skin = 'skin-blue';

    private static $static_skin = NULL;

    public function init()
    {
        $this->skin = !is_null(self::$static_skin) ? self::$static_skin : $this->skin;
        // Append skin color file if specified
        if ($this->skin) {

            if (('_all-skins' !== $this->skin) && (strpos($this->skin, 'skin-') !== 0)) {
                throw new Exception('Invalid AdminLte skin');
            }
            $this->css[] = sprintf('css/skins/%s.min.css', $this->skin);
        }

        $this->css[] = 'css/AdminLTE.min.css';

        parent::init();
    }

    public static function setSkin($skin){
        self::$static_skin = $skin;
    }
}
