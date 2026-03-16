<?php

namespace app\modules;


use app\widgets\maps\layers\TileLayer;

class APPConfig
{
    public function convertRoute($route)
    {
        return '.' . str_replace('/', '.', $route) . '.index';
    }

    public static $SITENAME = 'GIS - Cấp nước';
    public static $CONFIG = [
        'adminSidebar' => [
            [
                'name' => 'Quản lý người dùng',
                'icon' => 'fa fa-users',
                'url' => '/auth/user/index',
                'key' => '.auth.user.index',
                'hasChild' => false,
            ],
            [
                'name' => 'Quản lý nhóm quyền',
                'icon' => 'fa fa-th-list',
                'url' => '/user/auth-group',
                'key' => '.user.auth-group.index',
                'hasChild' => false,
            ],
            [
                'name' => 'Quản lý quyền truy cập',
                'icon' => 'fa fa-th-list',
                'url' => '/user/auth-role',
                'key' => '.user.auth-role.index',
                'hasChild' => false,
            ],
            [
                'name' => 'Quản lý hoạt động',
                'icon' => 'fa fa-th-list',
                'url' => '/user/auth-action',
                'key' => '.user.auth-action.index',
                'hasChild' => false,
            ],
        ],
        
        'quanly' => [
            
            [
                'name' => 'Cán bộ',
                'icon' => 'fa fa-list',
                'url' => 'quanly/can-bo',
                'key'=>'quanly.can-bo.index',
                'hasChild' => false,
            ],
            [
                'name' => 'Đơn vị',
                'icon' => 'fa fa-list',
                'url' => 'quanly/don-vi',
                'key'=>'quanly.don-vi.index',
                'hasChild' => false,
            ],
            
        ],
        'lopanninh' => [
            [
                'name' => 'Mục tiêu trọng điểm',
                'icon' => 'fa fa-list',
                'url' => 'quanly/muctieu-trongdiem',
                'key'=>'quanly.muctieu-trongdiem.index',
                'hasChild' => false,
            ],
            [
                'name' => 'Khu vực phức tạp an ninh',
                'icon' => 'fa fa-list',
                'url' => 'quanly/khuvuc-phuctap-an-ninh',
                'key'=>'quanly.khuvuc-phuctap-an-ninh.index',
                'hasChild' => false,
            ],
        ],
        'loptrattuxahoi' => [
            [
                'name' => 'Cơ sở kinh doanh có điều kiện',
                'icon' => 'fa fa-list',
                'url' => 'quanly/cosokinhdoanh-codk',
                'key'=>'quanly.cosokinhdoanh-codk.index',
                'hasChild' => false,
            ],
            [
                'name' => 'Điểm tệ nạn xã hội',
                'icon' => 'fa fa-list',
                'url' => 'quanly/diem-tenannxh',
                'key'=>'quanly.diem-tenannxh.index',
                'hasChild' => false,
            ],
        ],
        'lopquanlydancu' => [
            [
                'name' => 'Nóc gia',
                'icon' => 'fa fa-list',
                'url' => 'quanly/noc-gia',
                'key'=>'quanly.noc-gia.index',
                'hasChild' => false,
            ],
            [
                'name' => 'Hộ gia đình',
                'icon' => 'fa fa-list',
                'url' => 'quanly/ho-gia-dinh',
                'key'=>'quanly.ho-gia-dinh.index',
                'hasChild' => false,
            ],
            [
                'name' => 'Người dân',
                'icon' => 'fa fa-list',
                'url' => 'quanly/nguoi-dan',
                'key'=>'quanly.nguoi-dan.index',
                'hasChild' => false,
            ],
            [
                'name' => 'Thông tin cư trú',
                'icon' => 'fa fa-list',
                'url' => 'quanly/thongtin-cutru',
                'key'=>'quanly.thongtin-cutru.index',
                'hasChild' => false,
            ],
            [
                'name' => 'Import thông tin dân cư',
                'icon' => 'fa fa-list',
                'url' => 'quanly/noc-gia/import',
                'key'=>'quanly.noc-gia.import',
                'hasChild' => false,
            ],
        ],
        'loptuantra' => [
            [
                'name' => 'Camera an ninh',
                'icon' => 'fa fa-list',
                'url' => 'quanly/camera-an-ninh',
                'key'=>'quanly.camera-an-ninh.index',
                'hasChild' => false,
            ],
            [
                'name' => 'Chốt tuần tra',
                'icon' => 'fa fa-list',
                'url' => 'quanly/chot-tuantre',
                'key'=>'quanly.chot-tuantre.index',
                'hasChild' => false,
            ],
        ],
        'lopvuviec' => [
            [
                'name' => 'Vụ việc',
                'icon' => 'fa fa-list',
                'url' => 'quanly/vu-viec',
                'key'=>'quanly.vu-viec.index',
                'hasChild' => false,
            ],
            [
                'name' => 'Điểm nhạy cảm',
                'icon' => 'fa fa-list',
                'url' => 'quanly/diem-nhay-cam',
                'key'=>'quanly.diem-nhay-cam.index',
                'hasChild' => false,
            ],
            [
                'name' => 'Điểm trọng điểm',
                'icon' => 'fa fa-list',
                'url' => 'quanly/diem-trong-diem',
                'key'=>'quanly.diem-trong-diem.index',
                'hasChild' => false,
            ],
        ],
        'loppccc' => [
            [
                'name' => 'Trụ nước PCCC',
                'icon' => 'fa fa-list',
                'url' => 'quanly/tru-nuoc-ccc',
                'key'=>'quanly.tru-nuoc-ccc.index',
                'hasChild' => false,
            ],
            [
                'name' => 'Nguồn nước PCCC',
                'icon' => 'fa fa-list',
                'url' => 'quanly/nguon-nuoc-ccc',
                'key'=>'quanly.nguon-nuoc-ccc.index',
                'hasChild' => false,
            ],
            [
                'name' => 'Cơ sở nguy cơ cháy nổ',
                'icon' => 'fa fa-list',
                'url' => 'quanly/cosonguyco-chayno',
                'key'=>'quanly.cosonguyco-chayno.index',
                'hasChild' => false,
            ],
        ],
        'lopdtmt' => [
            [
                'name' => 'Ùn tắc giao thông',
                'icon' => 'fa fa-list',
                'url' => 'quanly/un-tac-giao-thong',
                'key'=>'quanly.un-tac-giao-thong.index',
                'hasChild' => false,
            ],
            [
                'name' => 'Trật tự đô thị',
                'icon' => 'fa fa-list',
                'url' => 'quanly/trat-tu-do-thi',
                'key'=>'quanly.trat-tu-do-thi.index',
                'hasChild' => false,
            ],
            [
                'name' => 'Điểm tập kết rác',
                'icon' => 'fa fa-list',
                'url' => 'quanly/tap-ket-rac',
                'key'=>'quanly.tap-ket-rac.index',
                'hasChild' => false,
            ],
            [
                'name' => 'Ngập úng',
                'icon' => 'fa fa-list',
                'url' => 'quanly/ngap-ung',
                'key'=>'quanly.ngap-ung.index',
                'hasChild' => false,
            ],
            [
                'name' => 'Điểm đen vsmt',
                'icon' => 'fa fa-list',
                'url' => 'quanly/diem-den-vsmt',
                'key'=>'quanly.diem-den-vsmt.index',
                'hasChild' => false,
            ],
        ],
        'import' => [
            [
                'name' => 'Import dữ liệu',
                'icon' => 'fa fa-list',
                'url' => 'quanly/noc-gia/import-table',
                'key'=>'quanly.noc-gia.import-table',
                'hasChild' => false,
            ],
        ],
        'map' => [
           
            [
                'name' => 'Bản đồ',
                'icon' => 'fa fa-map',
                'url' => 'quanly/map/vuviec',
                'key'=>'quanly.map.vuviec',
                'hasChild' => false,
            ]
        ],
        'danhmuc' => [
            [
                'name' => 'Giới tính',
                'icon' => 'fa fa-list',
                'url' => 'quanly/danhmuc/dm-gioitinh',
                'key'=>'quanly.danhmuc.dm-gioitinh.index',
                'hasChild' => false,
            ],
            [
                'name' => 'Quan hệ chủ hộ',
                'icon' => 'fa fa-list',
                'url' => 'quanly/danhmuc/dm-quanhechuho',
                'key'=>'quanly.danhmuc.dm-quanhechuho.index',
                'hasChild' => false,
            ],
            [
                'name' => 'Loại cư trú',
                'icon' => 'fa fa-list',
                'url' => 'quanly/danhmuc/dm-loaicutru',
                'key'=>'quanly.danhmuc.dm-loaicutru.index',
                'hasChild' => false,
            ],
            [
                'name' => 'Phường xã',
                'icon' => 'fa fa-list',
                'url' => 'quanly/phuongxa',
                'key'=>'quanly.phuongxa.index',
                'hasChild' => false,
            ],
            [
                'name' => 'Khu phố',
                'icon' => 'fa fa-list',
                'url' => 'quanly/kp',
                'key'=>'quanly.kp.index',
                'hasChild' => false,
            ],
        ],

    ];

    public static $ROOT_URL = 'app/';
    public static $URL_KEY = 'hcdcythd2022';
//    public static $HCMGIS_MAP = 'https://thuduc-maps.hcmgis.vn/thuducserver/gwc/service/wmts?layer=thuduc:thuduc_maps&style=&tilematrixset=EPSG:900913&Service=WMTS&Request=GetTile&Version=1.0.0&Format=image/png&TileMatrix=EPSG:900913:{z}&TileCol={x}&TileRow={y}';

    public static $BASEMAP = [
        'GoogleMap' => [
            'urlTemplate' => 'http://{s}.google.com/vt/lyrs=r&x={x}&y={y}&z={z}',
            'layerName' => 'Google Map',
            'clientOptions' => [
                'attribution' => '© GoogleMap contributors',
                'maxZoom' => 24,
                'subdomains' => ['mt0', 'mt1', 'mt2', 'mt3']
            ],
        ],
        'GoogleEarth' => [
            'urlTemplate' => 'http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',
            'layerName' => 'Ảnh vệ tinh',
            'clientOptions' => [
//                'attribution' => '© GoogleMap contributors',
                'maxZoom' => 24,
                'subdomains' => ['mt0', 'mt1', 'mt2', 'mt3']
            ],
        ],
//        'OpenStreetMap' => [
//            'urlTemplate' => 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
//            'layerName' => 'OSM',
//            'clientOptions' => [
//                'attribution' => '© OpenStreetMap contributors',
//                'maxZoom' => 22,
//            ],
//        ],

    ];

    public static function getUrl($url)
    {
        return \Yii::$app->homeUrl . self::$ROOT_URL . $url;
    }
}