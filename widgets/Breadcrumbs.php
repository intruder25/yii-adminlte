<?php

namespace madedwi\yii2adminlte\widgets;

use Yii;
use yii\widgets\Breadcrumbs as YiiBreadcrumbs;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class Breadcrumbs  extends YiiBreadcrumbs{

    public $tag = 'ol';

    public $homeLink = null;

    public $homeIcon = 'dashboard';

    public $itemHtmlIconTemplate = '<i class="{icon_class}"></i>';

    public $itemIconPrefix = 'fa fa-';

    public $itemTemplate = "<li>{icon} {link}</li>\n";

    public $activeItemTemplate = "<li class=\"active\">{link}</li>\n";

    public function run()
    {
        if (empty($this->links)) {
            return;
        }
        $links = [];
        if ($this->homeLink === null) {
            $links[] = $this->renderItem([
                'label' => Yii::t('yii', 'Home'),
                'url' => Yii::$app->homeUrl,
                'icon' => $this->homeIcon
            ], $this->itemTemplate);
        } elseif ($this->homeLink !== false) {
            $links[] = $this->renderItem($this->homeLink, $this->itemTemplate);
        }
        foreach ($this->links as $link) {
            if (!is_array($link)) {
                $link = ['label' => $link];
            }
            $links[] = $this->renderItem($link, isset($link['url']) ? $this->itemTemplate : $this->activeItemTemplate);
        }
        return Html::tag($this->tag, implode('', $links), $this->options);
    }

    protected function renderItem($link, $template)
    {
        $encodeLabel = ArrayHelper::remove($link, 'encode', $this->encodeLabels);
        if (array_key_exists('label', $link)) {
            $label = $encodeLabel ? Html::encode($link['label']) : $link['label'];
        } else {
            throw new InvalidConfigException('The "label" element is required for each link.');
        }
        if (isset($link['template'])) {
            $template = $link['template'];
        }

        $icon = isset($link['icon']) ? $link['icon'] : '';

        if (isset($link['url'])) {
            $options = $link;
            unset($options['template'], $options['label'], $options['url'], $options['icon']);
            $link = Html::a($label, $link['url'], $options);
        } else {
            $link = $label;
        }

        return strtr($template, ['{link}' => $link, '{icon}'=>$this->getIconHtml($icon)]);
    }

    private function getIconHtml($icon=""){

        if(empty($icon)){
            return '';
        }
        $iconClass = $this->itemIconPrefix . $icon;
        $iconHtml = str_replace('{icon_class}', $iconClass, $this->itemHtmlIconTemplate) ;

        return $iconHtml;
    }
}
