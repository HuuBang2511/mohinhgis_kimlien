<?php

namespace app\modules\quanly\controllers;

use app\modules\quanly\base\QuanlyBaseController;
use Yii;

/**
 * DashboardController v7
 * - Bỏ hoàn toàn VuViec / statusChartData
 * - Donut tổng = tổng hợp đỏ/vàng/xanh từ 5 lớp
 * - layerData không còn statusChart
 */
class DashboardController extends QuanlyBaseController
{
    public function actionIndex()
    {
        // ── HELPER: đếm IN() chính xác, tránh vấn đề ilike/tiếng Việt ──────
        $countIn = function (string $modelClass, string $column, array $values): int {
            return (int) $modelClass::find()
                ->where(['status' => 1])
                ->andWhere(['in', $column, $values])
                ->count();
        };

        // ── TAP KET RAC: phân loại theo cohatang ────────────────────────────
        $tapKetRacDo   = $countIn(\app\modules\quanly\models\TapKetRac::class, 'cohatang', ['Chưa có hạ tầng']);
        $tapKetRacXanh = (int) \app\modules\quanly\models\TapKetRac::find()
            ->where(['status' => 1])
            ->andWhere(['not in', 'cohatang', ['Chưa có hạ tầng']])
            ->andWhere(['IS NOT', 'cohatang', null])
            ->count();
        $tapKetRacTong = (int) \app\modules\quanly\models\TapKetRac::find()->where(['status' => 1])->count();
        $tapKetRacVang = max(0, $tapKetRacTong - $tapKetRacDo - $tapKetRacXanh);

        // ── CHART DATA: 5 lớp × 3 màu ───────────────────────────────────────
        $chartData = [
            'labels' => ['Tắc nghẽn GT', 'Vệ sinh MT', 'Trật tự ĐT', 'Ngập úng', 'Tập kết rác'],

            'do' => [
                $countIn(\app\modules\quanly\models\UnTacGiaoThong::class, 'danh_gia', [
                    'Thường xuyên ùn tắc (ĐỎ)',
                ]),
                $countIn(\app\modules\quanly\models\DiemDenVsmt::class, 'danh_gia', ['Đỏ', 'ĐỎ', 'đỏ']),
                $countIn(\app\modules\quanly\models\TratTuDoThi::class,  'ghi_chu',  ['Đỏ', 'ĐỎ', 'đỏ']),
                $countIn(\app\modules\quanly\models\NgapUng::class,      'danh_gia', ['Đỏ', 'ĐỎ', 'đỏ']),
                $tapKetRacDo,
            ],
            'vang' => [
                $countIn(\app\modules\quanly\models\UnTacGiaoThong::class, 'danh_gia', [
                    'Ùn tắc vào các giờ cao điểm (Vàng)',
                    'Ùn tắc vào các giờ đưa đón con đi học (Vàng)',
                ]),
                $countIn(\app\modules\quanly\models\DiemDenVsmt::class, 'danh_gia', ['Vàng', 'vàng', 'VÀNG']),
                $countIn(\app\modules\quanly\models\TratTuDoThi::class,  'ghi_chu',  ['Vàng', 'vàng', 'VÀNG']),
                $countIn(\app\modules\quanly\models\NgapUng::class,      'danh_gia', ['Vàng', 'vàng', 'VÀNG']),
                $tapKetRacVang,
            ],
            'xanh' => [
                $countIn(\app\modules\quanly\models\UnTacGiaoThong::class, 'danh_gia', [
                    'Ùn tắc vào các giờ cao điểm (Xanh)',
                ]),
                $countIn(\app\modules\quanly\models\DiemDenVsmt::class, 'danh_gia', ['Xanh', 'xanh', 'XANH']),
                $countIn(\app\modules\quanly\models\TratTuDoThi::class,  'ghi_chu',  ['Xanh', 'xanh', 'XANH']),
                $countIn(\app\modules\quanly\models\NgapUng::class,      'danh_gia', ['Xanh', 'xanh', 'XANH']),
                $tapKetRacXanh,
            ],
        ];

        // ── DONUT TỔNG: gộp đỏ/vàng/xanh từ 5 lớp ──────────────────────────
        $summaryChartData = [
            'labels' => ['Đỏ (Nghiêm trọng)', 'Vàng (Trung bình)', 'Xanh (Nhẹ / Đạt)'],
            'data'   => [
                array_sum($chartData['do']),
                array_sum($chartData['vang']),
                array_sum($chartData['xanh']),
            ],
        ];

        // ── LAYER DATA ────────────────────────────────────────────────────────
        $layerData = [
            'unTacGiaoThong' => [
                'title' => 'Tắc nghẽn giao thông',
                'chart' => ['do' => $chartData['do'][0], 'vang' => $chartData['vang'][0], 'xanh' => $chartData['xanh'][0]],
            ],
            'veSinhMoiTruong' => [
                'title' => 'Vệ sinh môi trường (Điểm đen VSMT)',
                'chart' => ['do' => $chartData['do'][1], 'vang' => $chartData['vang'][1], 'xanh' => $chartData['xanh'][1]],
            ],
            'tratTuDoThi' => [
                'title' => 'Trật tự đô thị',
                'chart' => ['do' => $chartData['do'][2], 'vang' => $chartData['vang'][2], 'xanh' => $chartData['xanh'][2]],
            ],
            'ngapUng' => [
                'title' => 'Ngập úng',
                'chart' => ['do' => $chartData['do'][3], 'vang' => $chartData['vang'][3], 'xanh' => $chartData['xanh'][3]],
            ],
            'tapKetRac' => [
                'title' => 'Điểm tập kết rác',
                'chart' => ['do' => $chartData['do'][4], 'vang' => $chartData['vang'][4], 'xanh' => $chartData['xanh'][4]],
            ],
        ];

        return $this->render('index', [
            'chartData'        => $chartData,
            'summaryChartData' => $summaryChartData,
            'layerData'        => $layerData,
        ]);
    }
}