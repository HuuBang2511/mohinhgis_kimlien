<?php
/**
 * BẢNG ĐIỀU KHIỂN QUẢN LÝ ĐÔ THỊ
 * Thiết kế cho Quản lý đô thị với 5 lớp chuyên đề
 *
 * @var yii\web\View $this
 * @var array $statusChartData
 * @var array $chartData
 * @var array $layerData
 */

use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$this->title = 'BẢNG ĐIỀU KHIỂN QUẢN LÝ ĐÔ THỊ';
$this->params['breadcrumbs'][] = $this->title;

// Mã hóa dữ liệu để truyền cho JavaScript
$statusChartDataJson = Json::encode($statusChartData);
$chartDataJson = Json::encode($chartData);
$layerDataJson = Json::encode($layerData);

// URL Bản đồ
$mapUrl = Url::to(['/quanly/map/vuviec']);
?>

<!-- Include CSS & JS for libraries -->
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/lucide@latest"></script>

<style>
    body {
        background-color: #f1f5f9; /* slate-100 */
    }
    .card {
        background-color: white;
        border-radius: 0.75rem; /* rounded-xl */
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px 0 rgba(0, 0, 0, 0.02);
        border: 1px solid #e2e8f0; /* slate-200 */
        display: flex;
        flex-direction: column;
    }
    .card-title {
        font-size: 1.125rem; /* text-lg */
        font-weight: 600; /* font-semibold */
        color: #1e293b; /* slate-800 */
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #e2e8f0; /* slate-200 */
        display: flex;
        align-items: center;
        text-transform: uppercase;
        color: #64748b;
        font-size: 0.875rem;
    }
    .card-title i {
        width: 1.25rem;
        height: 1.25rem;
        margin-right: 0.75rem;
    }
    .card-content {
        padding: 1.5rem;
        flex-grow: 1;
    }
    .section-title {
        font-size: 1.25rem;
        font-style: italic;
        font-weight: bold;
        color: #000;
        margin-top: 2rem;
        margin-bottom: 1rem;
    }
    .doughnut-wrapper {
        position: relative;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .doughnut-center {
        position: absolute;
        text-align: center;
        pointer-events: none;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    .doughnut-center-value {
        font-size: 2.5rem;
        font-weight: 700;
        color: #1e293b;
        line-height: 1;
    }
    .doughnut-center-label {
        font-size: 0.75rem;
        color: #64748b;
        margin-top: 4px;
    }
    
    /* Responsive Chart heights */
    .main-chart-container { height: 400px; }
    @media (max-width: 1024px) {
        .main-chart-container { height: 300px; }
        .doughnut-center-value { font-size: 2rem; }
    }
</style>

<div class="quanly-dashboard p-4 sm:p-6 lg:p-8 space-y-6">
    
    <!-- === Header === -->
    <div class="flex flex-wrap justify-between items-center gap-4 mb-2">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 uppercase"><?= Html::encode($this->title) ?></h1>
             <p class="text-slate-500 mt-1">TỔNG HỢP THÔNG TIN TRẬT TỰ ĐÔ THỊ PHƯỜNG KIM LIÊN TRONG TUẦN</p>
        </div>
        <div class="flex gap-3 items-center">
            <!-- Nút bấm chuyển sang bản đồ -->
            <a href="<?= Html::encode($mapUrl) ?>" target="_blank" class="flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg shadow-sm transition-colors">
                <i data-lucide="map" class="w-4 h-4 mr-2"></i>
                Chuyển Tới Bản Đồ
            </a>
        </div>
    </div>

    <!-- === TỔNG QUAN TẤT CẢ CÁC LỚP === -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Biểu đồ cột tổng hợp 5 lớp -->
        <div class="card lg:col-span-2">
            <h2 class="card-title justify-center text-center">TỔNG HỢP THÔNG TIN TRẬT TỰ ĐÔ THỊ PHƯỜNG KIM LIÊN 2026</h2>
            <div class="card-content main-chart-container w-full">
                <canvas id="mainBarChart"></canvas>
            </div>
            <!-- Custom Legend -->
            <div class="flex justify-center items-center gap-6 pb-4">
                <div class="flex items-center gap-2"><span class="w-3 h-3 bg-red-600 inline-block"></span> Đỏ</div>
                <div class="flex items-center gap-2"><span class="w-3 h-3 bg-yellow-400 inline-block"></span> Vàng</div>
                <div class="flex items-center gap-2"><span class="w-3 h-3 bg-green-500 inline-block"></span> Xanh</div>
            </div>
        </div>

        <!-- Tình Trạng Xử Lý Tất Cả Vụ Việc -->
        <div class="card">
            <h2 class="card-title text-green-600">
                <i data-lucide="pie-chart" class="text-green-500"></i>Tình Trạng Xử Lý Vụ Việc
            </h2>
            <div class="card-content main-chart-container w-full">
                <div class="doughnut-wrapper">
                    <canvas id="mainStatusChart"></canvas>
                    <div class="doughnut-center" id="mainDoughnutCenter">
                        <div class="doughnut-center-value" id="mainDoughnutTotal">-</div>
                        <div class="doughnut-center-label">Tổng vụ việc</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- === TỔNG QUAN CHI TIẾT TỪNG LỚP CHUYÊN ĐỀ === -->
    <?php
    // keys trùng khớp với mảng PHP
    $layers = ['unTacGiaoThong', 'veSinhMoiTruong', 'tratTuDoThi', 'ngapUng', 'tapKetRac']; 
    ?>
    
    <?php foreach ($layers as $index => $layerKey): ?>
        <?php $layer = $layerData[$layerKey]; ?>
        <h3 class="section-title">Tổng quan / <?= Html::encode($layer['title']) ?></h3>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Biểu đồ cột Từng Lớp -->
            <div class="card lg:col-span-2">
                <h2 class="card-title justify-center text-center uppercase">TỔNG HỢP</h2>
                <div class="card-content" style="height: 350px;">
                    <canvas id="barChart_<?= $layerKey ?>"></canvas>
                </div>
                <div class="flex justify-center items-center gap-6 pb-4">
                     <p class="font-semibold text-gray-700"><?= Html::encode($layer['title']) ?></p>
                </div>
            </div>

            <!-- Tình Trạng Xử Lý Của Lớp Đó -->
            <div class="card">
                <h2 class="card-title text-green-600">
                    <i data-lucide="pie-chart" class="text-green-500"></i>Tình Trạng Xử Lý Vụ Việc
                </h2>
                <div class="card-content" style="height: 350px;">
                    <div class="doughnut-wrapper">
                        <canvas id="statusChart_<?= $layerKey ?>"></canvas>
                        <div class="doughnut-center">
                            <div class="doughnut-center-value total-val-<?= $layerKey ?>">-</div>
                            <div class="doughnut-center-label">Tổng vụ việc</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    <?php endforeach; ?>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    lucide.createIcons();

    // Data payload
    const chartData = <?= $chartDataJson ?>;
    const statusData = <?= $statusChartDataJson ?>;
    const layerData = <?= $layerDataJson ?>;

    // Common configurations
    const colorRed = '#dc2626'; // tailwind red-600
    const colorYellow = '#facc15'; // tailwind yellow-400
    const colorGreen = '#22c55e'; // tailwind green-500
    
    const chartColors = ['#3b82f6', '#ef4444', '#22c55e', '#a855f7', '#06b6d4', '#f97316', '#14b8a6', '#6366f1'];
    
    const commonBarConfig = {
        plugins: { 
            legend: { display: false },
            datalabels: {
                anchor: 'end',
                align: 'top',
                color: '#475569',
                font: { weight: 'bold' }
            }
        },
        scales: {
            y: { beginAtZero: true, grid: { color: '#e2e8f0' }, ticks: { color: '#64748b', stepSize: 1 } },
            x: { grid: { display: false }, ticks: { color: '#475569', font: { weight: '600' } } }
        },
        maintainAspectRatio: false,
        responsive: true
    };

    const commonDoughnutConfig = (total, idPrefix) => ({
        responsive: true,
        maintainAspectRatio: false,
        plugins: { 
            legend: { display: true, position: 'bottom', labels: { boxWidth: 12, usePointStyle: false, padding: 20 } },
        }, 
        cutout: '65%',
        onHover: function(evt, elements) {
            const totalEl = document.querySelector(`.total-val-${idPrefix}`);
            if (!totalEl) return;
            if (elements.length > 0) {
                const idx = elements[0].index;
                const val = statusData.data[idx];
                totalEl.textContent = val.toLocaleString('vi-VN');
            } else {
                totalEl.textContent = total.toLocaleString('vi-VN');
            }
        }
    });

    // Load Chart.js DataLabels plugin if it's available, otherwise fallback
    // We will use a custom plugin if chartjs-plugin-datalabels is missing
    const showValuesPlugin = {
        id: 'showValues',
        afterDatasetsDraw(chart, args, pluginOptions) {
            const { ctx, data } = chart;
            ctx.save();
            ctx.font = 'bold 12px sans-serif';
            ctx.fillStyle = '#475569';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'bottom';
            
            if(chart.config.type !== 'bar') return;
            
            data.datasets.forEach((dataset, i) => {
                const meta = chart.getDatasetMeta(i);
                meta.data.forEach((bar, index) => {
                    const value = dataset.data[index];
                    if (value > 0) {
                        ctx.fillText(value, bar.x, bar.y - 5);
                    }
                });
            });
            ctx.restore();
        }
    };


    // 1. MAIN BAR CHART
    const mainBarCtx = document.getElementById('mainBarChart')?.getContext('2d');
    if (mainBarCtx) {
        new Chart(mainBarCtx, {
            type: 'bar',
            data: {
                labels: chartData.labels,
                datasets: [
                    { label: 'Đỏ', backgroundColor: colorRed, data: chartData.do, barPercentage: 0.8, categoryPercentage: 0.7 },
                    { label: 'Vàng', backgroundColor: colorYellow, data: chartData.vang, barPercentage: 0.8, categoryPercentage: 0.7 },
                    { label: 'Xanh', backgroundColor: colorGreen, data: chartData.xanh, barPercentage: 0.8, categoryPercentage: 0.7 },
                ]
            },
            options: commonBarConfig,
            plugins: [showValuesPlugin]
        });
    }

    // 2. MAIN DOUGHNUT CHART
    const mainStatusCtx = document.getElementById('mainStatusChart')?.getContext('2d');
    if (mainStatusCtx) {
        const total = statusData.data.reduce((a, b) => a + b, 0);
        document.getElementById('mainDoughnutTotal').textContent = total.toLocaleString('vi-VN');
        // Custom onHover for main
        const doughnutOpts = commonDoughnutConfig(total, 'main');
        doughnutOpts.onHover = function(evt, elements) {
            const totalEl = document.getElementById('mainDoughnutTotal');
            if (!totalEl) return;
            if (elements.length > 0) {
                const idx = elements[0].index;
                const val = statusData.data[idx];
                totalEl.textContent = val.toLocaleString('vi-VN');
            } else {
                totalEl.textContent = total.toLocaleString('vi-VN');
            }
        };

        new Chart(mainStatusCtx, {
            type: 'doughnut',
            data: {
                labels: statusData.labels,
                datasets: [{ data: statusData.data, backgroundColor: chartColors, borderWidth: 3 }]
            },
            options: doughnutOpts
        });
    }

    // 3. INDIVIDUAL THEMATIC CHARTS
    const layers = ['unTacGiaoThong', 'veSinhMoiTruong', 'tratTuDoThi', 'ngapUng', 'tapKetRac'];
    
    layers.forEach(layerKey => {
        const lyr = layerData[layerKey];
        if(!lyr) return;

        // Sub Bar Chart
        const barCtx = document.getElementById(`barChart_${layerKey}`)?.getContext('2d');
        if (barCtx) {
            new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: [''], // Trống Label trục X vì hiển thị ở dưới
                    datasets: [
                        { label: 'Đỏ', backgroundColor: colorRed, data: [lyr.chart.do], barThickness: 40 },
                        { label: 'Vàng', backgroundColor: colorYellow, data: [lyr.chart.vang], barThickness: 40 },
                        { label: 'Xanh', backgroundColor: colorGreen, data: [lyr.chart.xanh], barThickness: 40 },
                    ]
                },
                options: commonBarConfig,
                plugins: [showValuesPlugin]
            });
        }

        // Sub Doughnut Chart
        const donutCtx = document.getElementById(`statusChart_${layerKey}`)?.getContext('2d');
        if (donutCtx) {
            // Sử dụng chung 1 bộ data cho nhanh (vì chưa có filter real).
            const subTotal = statusData.data.reduce((a, b) => a + b, 0);
            const totalEl = document.querySelector(`.total-val-${layerKey}`);
            if (totalEl) totalEl.textContent = subTotal.toLocaleString('vi-VN');
            
            new Chart(donutCtx, {
                type: 'doughnut',
                data: {
                    labels: statusData.labels,
                    datasets: [{ data: statusData.data, backgroundColor: chartColors, borderWidth: 3 }]
                },
                options: commonDoughnutConfig(subTotal, layerKey)
            });
        }
    });

});
</script>
