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