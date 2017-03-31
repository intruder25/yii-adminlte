<?php

namespace madedwi\yii2adminlte\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\base\InvalidParamException;

class HeaderBar extends Widget{

    public $logo = '<b>Admin</b>LTE';

    public $logoMini = '<b>A</b>LT';

    public $logoUrl = '';

    public $options = NULL;

    public $navOptions = NULL;

    public $dropDownItems = [];

    public $displayUserLogin = false;

    public $userInformation = [];

    public $menuOptions = [];

    public function init(){
        if(empty($this->logoUrl)){
            $this->logoUrl = Yii::getAlias('@web');
        }

        $_baseUserInformation = [
            'image'     => 'not_set',
            'niceName'  => 'not_set',
            'userEmail' => '',
            'userFullName' => '',
            'userHeader'    => '',
            'userBody'      => '',
            'userFooter'    => '',
            'logout'        => '',
            'profile'       => ''
        ];

        if(!is_array($this->userInformation)){
            throw new InvalidParamException("User information should be in array format.");
        }

        $this->userInformation = array_merge($_baseUserInformation, $this->userInformation);

        if(!is_array($this->menuOptions)){
            throw new InvalidParamException("Error Processing Request");
        }

        if(count($this->menuOptions)==0){
            $this->menuOptions = ['class'=>'navbar-custom-menu'];
        }
    }

    public function run(){

        $logo = Html::a( Html::tag('span', $this->logoMini, ['class'=>'logo-mini']) . Html::tag('span', $this->logo, ['class'=>'logo-lg']), $this->logoUrl, ['class'=>'logo']);

        $toggleButton = Html::a(
                                Html::tag('span','Toggle Nav', ['class'=>'sr-only']) .
                                Html::tag('span', '',['class'=>'icon-bar']) .
                                Html::tag('span', '',['class'=>'icon-bar']) .
                                Html::tag('span', '',['class'=>'icon-bar']), '#',
                                ['class'=>'sidebar-toggle', 'data-toggle'=>'offcanvas', 'role'=>'button']);


        if($this->displayUserLogin == true){
            $userDisplay = $this->renderUserInformation();
            $this->dropDownItems[] = $userDisplay;
        }

        $menuContent = '';

        foreach($this->dropDownItems as $item){
            $sanitizedItem = $this->sanitizeMenuItem($item);
            $menuContent .= $sanitizedItem;
        }

        $headerContent = Html::tag('div', Html::tag('ul', $menuContent, ['class'=>'nav navbar-nav']), $this->menuOptions);

        if(is_null($this->navOptions) || count($this->navOptions)==0){
            $this->navOptions = ['class'=>'navbar navbar-static-top'];
        }else if(!is_array($this->navOptions)){
            throw new InvalidParamException('Nav options should be in array format.');
        }

        $headerMenu = Html::tag('nav', $toggleButton. $headerContent , $this->navOptions);

        if(is_null($this->options) || count($this->options)==0){
            $this->options = ['class'=>'main-header'];
        }else if(!is_array($this->options)){
            throw new InvalidParamException('Header options should be in array format.');
        }

        return Html::tag('header', $logo. $headerMenu, $this->options);
    }

    private function sanitizeMenuItem($item){
        if(!is_array($item)){
            return Html::tag('li', $item, ['class'=>'dropdown']);
        }else{

            if(!isset($item['content'])){
                return '';
            }
            $content = is_callable($item['content']) ? call_user_func($item['content']) :$item['content'];
            $listOptions = isset($item['options']) ? $item['options'] : ['class'=>'dropdown'];

            return Html::tag('li', $content, $listOptions);
        }
    }

    private function renderUserInformation(){
        $userDisplayHeader  = '';
        $userDisplayBody    = '';
        $userDisplayFooter  = '';

        if(!empty($this->userInformation['userHeader'])){
            $userHeader = $this->userInformation['userHeader'];
            $userHeaderOptions = ['class'=>'user-header'];
            if(is_array($userHeader)){
                $_header = $userHeader;
                $userHeader = isset($_header['content']) ? $_header['content'] : '';
                $userHeaderOptions = isset($_header['options']) ? $_header['options'] : $userHeaderOptions;
            }
            $userDisplayHeader = Html::tag('li', $userHeader , $userHeaderOptions);
        }else{

            $name = !empty($this->userInformation['userFullName']) ? $this->userInformation['userFullName'] : $this->userInformation['niceName'];
            $email = !empty($this->userInformation['userEmail']) ? Html::tag('small', $this->userInformation['userEmail']) : '';

            $userDisplayHeader = Html::tag('li',
                                            Html::img($this->userInformation['image'], ['class'=>'img-circle', 'alt'=>'User Image']) .
                                            Html::tag('p', $name . $email),
                                            ['class'=>'user-header']);
        }

        if(!empty($this->userInformation['userBody'])){
            $userBody = $this->userInformation['userBody'];
            $userBodyOptions = ['class'=>'user-body'];
            if(is_array($userBody)){
                $_body = $userBody;
                $userBody = isset($_body['content']) ? $_body['content'] : '';
                $userBodyOptions = isset($_body['options']) ? $_body['options'] : $userBodyOptions;
            }
            $userDisplayBody = Html::tag('li', $userBody, $userBodyOptions);
        }


        if(!empty($this->userInformation['userFooter'])){
            $userFooter = $this->userInformation['userFooter'];
            $userFooterOptions = ['class'=>'user-footer'];
            if(is_array($userFooter)){
                $_footer = $userFooter;
                $userFooter = isset($_footer['content']) ? $_footer['content'] : '';
                $userFooterOptions = isset($_footer['options']) ? $_footer['options'] : $userFooterOptions;
            }
            $userDisplayFooter = Html::tag('li', $userFooter, $userFooterOptions);
        }else{

            $logoutUrl = $this->userInformation['logout'];
            $logoutText = 'Logout';
            $logoutOptions = ['class'=>'btn btn-default btn-flat'];
            if(is_array($this->userInformation['logout'])){
                $_logout = $this->userInformation['logout'];
                $logoutUrl = $_logout[0];
                array_shift($_logout);
                if(isset($_logout[0]) && !is_array($_logout[0])){
                    $logoutText = $_logout[0];
                    array_shift($_logout);
                }
                if(isset($_logout[0]) && !is_array($_logout[0])){
                    throw new InvalidParamException("Logout options should be in array format");

                }else{
                    $logoutOptions = $_logout[0];
                }
            }


            $profileUrl = $this->userInformation['profile'];
            $profileText = 'Profile';
            $profileOptions = ['class'=>'btn btn-default btn-flat'];
            if(is_array($this->userInformation['profile'])){
                $_profile = $this->userInformation['profile'];
                $profileUrl = $_profile[0];
                array_shift($_profile);
                if(isset($_profile[0]) && !is_array($_profile[0])){
                    $profileText = $_profile[0];
                    array_shift($_profile);
                }
                if(isset($_profile[0]) && !is_array($_profile[0])){
                    throw new InvalidParamException("Profile options should be in array format");

                }else{
                    $profileOptions = $_profile[0];
                }
            }

            $userDisplayFooter = Html::tag('li',
                                            Html::tag('div',
                                                        Html::a($profileText, $profileUrl, $profileOptions),
                                                        ['class'=>'pull-left']) .
                                            Html::tag('div',
                                                        Html::a($logoutText, $logoutUrl, $logoutOptions),
                                                        ['class'=>'pull-right']),
                                            ['class'=>'user-footer']);
        }


        $userDisplay = Html::tag('li',
                                Html::a(
                                        Html::img($this->userInformation['image'], ['class'=>'user-image', 'alt'=>'User Image']) .
                                        Html::tag('span', $this->userInformation['niceName'], ['class'=>'hidden-xs']),
                                    '#', ['class'=>'dropdown-toggle', 'data-toggle'=>'dropdown']) .
                                Html::tag('ul',
                                            $userDisplayHeader .
                                            $userDisplayBody .
                                            $userDisplayFooter ,
                                            ['class'=>'dropdown-menu']),
                                ['class'=>'dropdown user user-menu']);

        return $userDisplay;
    }

}
