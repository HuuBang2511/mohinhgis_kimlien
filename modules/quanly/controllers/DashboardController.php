<?php

namespace app\modules\quanly\controllers;

use app\modules\quanly\base\QuanlyBaseController;
use app\modules\quanly\models\CameraAnNinh;
use app\modules\quanly\models\ChotTuantre;
use app\modules\quanly\models\CosokinhdoanhCodk;
use app\modules\quanly\models\CosonguycoChayno;
use app\modules\quanly\models\DiemNhayCam;
use app\modules\quanly\models\DiemTenannxh;
use app\modules\quanly\models\KhuvucPhuctapAnNinh;
use app\modules\quanly\models\MuctieuTrongdiem;
use app\modules\quanly\models\NguoiDan;
use app\modules\quanly\models\NguonNuocCcc;
// use app\modules\quanly\models\Phuongxa; // Không cần nữa
use app\modules\quanly\models\TrangThaiXuLy;
use app\modules\quanly\models\TruNuocCcc;
use app\modules\quanly\models\VuViec;
use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * DashboardController (Phiên bản Bảng Điều hành Nghiệp vụ v4)
 * Gỡ bỏ logic lọc theo Phường/Xã.
 * Thêm điều kiện status = 1 cho tất cả các truy vấn.
 */
class DashboardController extends QuanlyBaseController
{
    /**
     * Hiển thị Bảng điều hành Quản lý đô thị.
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionIndex()
    {
        // --- 1. TÌNH TRẠNG XỬ LÝ VỤ VIỆC (BIỂU ĐỒ TRÒN BÊN PHẢI) ---
        $dataByStatus = \app\modules\quanly\models\VuViec::find()
            ->select(['trang_thai_hien_tai_id', 'count' => 'COUNT(*)'])
            ->where(['status' => 1])
            ->groupBy('trang_thai_hien_tai_id')->with('trangThaiHienTai')
            ->asArray()->all();
        
        $statusChartData = [
            'labels' => ArrayHelper::getColumn($dataByStatus, fn($item) => $item['trangThaiHienTai']['ten_trang_thai'] ?? 'N/A'),
            'data' => array_map('intval', ArrayHelper::getColumn($dataByStatus, 'count')),
        ];

        // --- 2. DỮ LIỆU ĐÁNH GIÁ (ĐỎ, VÀNG, XANH) CHO BIỂU ĐỒ CỘT CHÍNH ---
        // Helper function để lấy số lượng theo cột đánh giá linh hoạt
        $getCountByAttr = function ($modelClass, $searchKeyword, $attribute = 'danh_gia') {
            return (int) $modelClass::find()
                ->where(['status' => 1])
                ->andWhere(['ilike', $attribute, $searchKeyword])
                ->count();
        };

        $chartData = [
            'labels' => ['Tắc nghẽn giao thông', 'Vệ sinh môi trường', 'Trật tự đô thị', 'Ngập úng', 'Tập kết rác'],
            'do' => [
                $getCountByAttr('app\modules\quanly\models\UnTacGiaoThong', '%đỏ%'),
                $getCountByAttr('app\modules\quanly\models\DiemDenVsmt', '%đỏ%'),
                $getCountByAttr('app\modules\quanly\models\TratTuDoThi', '%đỏ%', 'ghi_chu'), // Trật tự đô thị dùng cột ghi_chu
                $getCountByAttr('app\modules\quanly\models\NgapUng', '%đỏ%'),
                0,
            ],
            'vang' => [
                $getCountByAttr('app\modules\quanly\models\UnTacGiaoThong', '%vàng%'),
                $getCountByAttr('app\modules\quanly\models\DiemDenVsmt', '%vàng%'),
                $getCountByAttr('app\modules\quanly\models\TratTuDoThi', '%vàng%', 'ghi_chu'), // Trật tự đô thị dùng cột ghi_chu
                $getCountByAttr('app\modules\quanly\models\NgapUng', '%vàng%'),
                0,
            ],
            'xanh' => [
                $getCountByAttr('app\modules\quanly\models\UnTacGiaoThong', '%xanh%'),
                $getCountByAttr('app\modules\quanly\models\DiemDenVsmt', '%xanh%'),
                $getCountByAttr('app\modules\quanly\models\TratTuDoThi', '%xanh%', 'ghi_chu'), // Trật tự đô thị dùng cột ghi_chu
                $getCountByAttr('app\modules\quanly\models\NgapUng', '%xanh%'),
                (int) \app\modules\quanly\models\TapKetRac::find()->where(['status' => 1])->count(), // Tập kết rác gán vào Xanh (Hạ tầng)
            ],
        ];

        // --- 3. DỮ LIỆU CÁC LỚP CHUYÊN ĐỀ (PHẦN BÊN DƯỚI) ---
        $layerData = [
            'unTacGiaoThong' => [
                'title' => 'Tắc nghẽn giao thông',
                'chart' => [
                    'do' => $chartData['do'][0],
                    'vang' => $chartData['vang'][0],
                    'xanh' => $chartData['xanh'][0],
                ],
                'statusChart' => $statusChartData, // Giả sử biểu đồ tròn là tổng thể (do thiếu dữ liệu filter)
            ],
            'veSinhMoiTruong' => [
                'title' => 'Vệ sinh môi trường (Điểm đen VSMT)',
                'chart' => [
                    'do' => $chartData['do'][1],
                    'vang' => $chartData['vang'][1],
                    'xanh' => $chartData['xanh'][1],
                ],
                'statusChart' => $statusChartData,
            ],
            'tratTuDoThi' => [
                'title' => 'Trật tự đô thị',
                'chart' => [
                    'do' => $chartData['do'][2],
                    'vang' => $chartData['vang'][2],
                    'xanh' => $chartData['xanh'][2],
                ],
                'statusChart' => $statusChartData,
            ],
            'ngapUng' => [
                'title' => 'Ngập úng',
                'chart' => [
                    'do' => $chartData['do'][3],
                    'vang' => $chartData['vang'][3],
                    'xanh' => $chartData['xanh'][3],
                ],
                'statusChart' => $statusChartData,
            ],
            'tapKetRac' => [
                'title' => 'Điểm tập kết rác',
                'chart' => [
                    'do' => $chartData['do'][4],
                    'vang' => $chartData['vang'][4],
                    'xanh' => $chartData['xanh'][4],
                ],
                'statusChart' => $statusChartData,
            ],
        ];

        // === RENDER VIEW ===
        return $this->render('index', [
            'statusChartData' => $statusChartData,
            'chartData' => $chartData,
            'layerData' => $layerData,
        ]);
    }
}

