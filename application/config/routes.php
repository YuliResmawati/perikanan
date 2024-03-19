<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['sitemap.xml'] = 'sitemap';

/************* Start Manifest Routing *************/
$route['manifest/browserconfig\.xml'] = 'manifest/browserconfig';
$route['manifest/site\.webmanifest'] = 'manifest/site';
/************* End Manifest Routing *************/

#== Core Routes ==#
$route['masuk'] = 'auth';
$route['logout'] = 'auth/do_logout';

## frontend routes ##
$route['kontak'] = 'frontend/contact';
$route['visi-misi'] = 'frontend/visi_misi';
$route['profil-dkpp'] = 'frontend/profile_dkpp';
$route['struktur-dkpp'] = 'frontend/struktur_dkpp';
$route['gallery-dkpp'] = 'frontend/gallery_dkpp';
$route['gallery-video'] = 'frontend/gallery_dkpp/index_video';

$route['pegawai'] = 'frontend/data_pegawai';
$route['pegawai/page'] = 'frontend/data_pegawai';
$route['pegawai/page/(:any)'] = 'frontend/data_pegawai/index/$1';
$route['pegawai/(:any)'] = 'frontend/data_pegawai/detail/$1';

$route['berita'] = 'frontend/berita';
$route['berita/page'] = 'frontend/berita';
$route['berita/page/(:any)'] = 'frontend/berita/index/$1';
$route['berita/(:any)'] = 'frontend/berita/detail/$1';

$route['announcement'] = 'frontend/announcement';
$route['announcement/page'] = 'frontend/announcement';
$route['announcement/page/(:any)'] = 'frontend/announcement/index/$1';

$route['publication'] = 'frontend/publication';
$route['publication/page'] = 'frontend/publication';
$route['publication/page/(:any)'] = 'frontend/publication/index/$1';

$route['panel-harga'] = 'frontend/panel_harga_chart';
$route['panel-harga/page'] = 'frontend/panel_harga_chart';
$route['panel-harga/page/(:any)'] = 'frontend/panel_harga_chart/index/$1';
$route['panel-harga/(:any)'] = 'frontend/panel_harga_chart/detail/$1';

$route['article'] = 'frontend/article';
$route['article/page'] = 'frontend/article';
$route['article/page/(:any)'] = 'frontend/article/index/$1';
$route['article/(:any)'] = 'frontend/article/detail/$1';

$route['layanan-pengaduan'] = 'frontend/layanan_pengaduan';
$route['layanan-pengaduan/process'] = 'frontend/layanan_pengaduan/process';

$route['isi-survei'] = 'frontend/skm';
$route['isi-survei/sendRankiangApis'] = 'frontend/skm/sendRankiangApis';

$route['daftar-sekolah'] = 'frontend/school';
$route['daftar-sekolah/(:any)'] = 'frontend/school/detail/$1';
$route['daftar-sekolah/(:any)/page'] = 'frontend/school/detail/$1';
$route['daftar-sekolah/(:any)/page/(:any)'] = 'frontend/school/detail/$1';
