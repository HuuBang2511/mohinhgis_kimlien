<?php

namespace app\modules\quanly\controllers;

use app\modules\quanly\models\VuViec;
use app\modules\quanly\models\DiemDenVsmt;
use app\modules\quanly\models\NgapUng;
use app\modules\quanly\models\TapKetRac;
use app\modules\quanly\models\TratTuDoThi;
use app\modules\quanly\models\UnTacGiaoThong;
use Yii;
use yii\helpers\Json;
use yii\web\Response;
use yii\web\NotFoundHttpException;

class MapController extends \app\modules\quanly\base\QuanlyBaseController
{
    public $layout = '@app/views/layouts/map/main';

    public function actionVuviec()
    {
        return $this->render('vuviec');
    }

    /**
     * Trả về JSON danh sách file đính kèm của một đối tượng theo lớp và ID.
     * URL: /quanly/map/get-files?layer=ngapUng&id=5
     */
    public function actionGetFiles()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $layer = Yii::$app->request->get('layer');
        $id    = (int) Yii::$app->request->get('id');

        if (!$layer || !$id) {
            return ['success' => false, 'files' => [], 'error' => 'Thiếu tham số'];
        }

        // Map layer key → model class
        $modelMap = [
            'ngapUng'         => NgapUng::class,
            'diemDenVsmt'     => DiemDenVsmt::class,
            'tapKetRac'       => TapKetRac::class,
            'tratTuDoThi'     => TratTuDoThi::class,
            'unTacGiaoThong'  => UnTacGiaoThong::class,
        ];

        if (!isset($modelMap[$layer])) {
            return ['success' => false, 'files' => [], 'error' => 'Lớp không hợp lệ'];
        }

        $modelClass = $modelMap[$layer];
        $model = $modelClass::findOne(['id' => $id, 'status' => 1]);

        if (!$model) {
            return ['success' => false, 'files' => [], 'error' => 'Không tìm thấy đối tượng'];
        }

        $files = [];
        if (!empty($model->file_dinhkem)) {
            $decoded = json_decode($model->file_dinhkem, true);
            if (is_array($decoded)) {
                foreach ($decoded as $path) {
                    $filename = basename($path);
                    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                    $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp']);
                    $files[] = [
                        'url'     => Yii::$app->request->baseUrl . '/' . ltrim($path, '/'),
                        'name'    => $filename,
                        'isImage' => $isImage,
                        'ext'     => $ext,
                    ];
                }
            }
        }

        return ['success' => true, 'files' => $files];
    }
}