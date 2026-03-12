<?php


namespace app\modules\quanly\base;


use hcmgis\user\controllers\BaseController;
use yii\filters\AccessControl;
use yii\web\Controller;

class QuanlyBaseController extends BaseController
{
    public $layout = '@app/modules/layouts/main';

    public $title = '';

    public $url = 'index';

    public $buttonUrls;

    public $label = [
        'index' => 'Danh sách',
        'search' => 'Tìm kiếm',
        'create' => 'Thêm mới',
        'update' => 'Cập nhật',
        'view' => 'Thông tin chi tiết',
        'delete' => 'Xóa',
        'position' => 'Sơ đồ',
    ];

//    public function behaviors()
//    {
//        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'only' => ['login', 'logout', 'index', 'create', 'update', 'delete', 'search', 'view'],
//                'rules' => [
//                    [
//                        'allow' => true,
//                        'actions' => ['login'],
//                        'roles' => ['?'],
//                    ],
//                    [
//                        'allow' => true,
//                        'actions' => ['logout', 'view', 'index', 'search'],
//                        'roles' => ['viewer'],
//                    ],
//                    [
//                        'allow' => true,
//                        'actions' => ['logout', 'create', 'update', 'delete', 'search', 'view', 'index'],
//                        'roles' => ['@'],
//                    ],
//                ],
//                'denyCallback' => function ($rule, $action) {
////                    $queryParams = \Yii::$app->request->queryParams;
////                    $queryParams[] = implode('/', [$this->moduleUrl, $action->controller->id, $action->id]);
////                    $backUrl = \Yii::$app->urlManager->createUrl($queryParams);
////                    \Yii::$app->user->setReturnUrl($backUrl);
//
//                    return $this->redirect(\Yii::$app->urlManager->createUrl('auth/auth/login'));
//                }
//            ],
//        ];
//    }

    public function beforeAction($action)
    {
        // Danh sách các action cho phép truy cập tự do trong module Quanly
        $allowGuest = ['vuviec', 'search']; 

        if (in_array($action->id, $allowGuest)) {
            // Nhảy thẳng lên lớp Controller của Yii2, bỏ qua kiểm tra của BaseController hcmgis
            return \yii\web\Controller::beforeAction($action);
        }

        return parent::beforeAction($action);
    }
}