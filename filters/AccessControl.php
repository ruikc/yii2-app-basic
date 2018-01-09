<?php

namespace app\filters;

use Yii;
use yii\base\Action;
use yii\base\Module;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * Class AccessControl
 *
 * @package yii2mod\rbac\filters
 */
class AccessControl extends \yii\filters\AccessControl
{
    /**
     * @var array
     */
    public $params = [];

    /**
     * @var array list of actions that not need to check access
     */
    public $allowActions = [];

    /**
     * @inheritdoc
     */
    public function beforeAction($action) {
        $controller = $action->controller;
        $params = ArrayHelper::getValue($this->params, $action->id, []);

        if (Yii::$app->user->can('/' . $action->getUniqueId(), $params)) {
            return true;
        }

        do {
            if (Yii::$app->user->can('/' . ltrim($controller->getUniqueId() . '/*', '/'))) {
                return true;
            }
            $controller = $controller->module;
        } while ($controller !== null);

        return parent::beforeAction($action);
    }

}
