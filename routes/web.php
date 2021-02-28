<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// public
Route::get('/', function () {
    return view('public.beranda');
    // return abort(500);
});

Route::get('/galeris', 'GaleriController@index');
Route::get('/galeris/{slug}', 'GaleriController@show');

// Route::get('/info', function () {
//     phpinfo();
// });

Route::group(['prefix' => 'perencanaan-kinerja'], function(){

    Route::get('/', 'PerencanaanController@index');

    Route::get('/rpjmd', 'PerencanaanController@rpjmd');

    Route::get('/renstra', 'PerencanaanController@renstra');
    Route::get('/renstra/{organisasi_no}', 'PerencanaanController@dataRenstra');

    Route::get('/rkt-opd/{organisasi_no}', 'PerencanaanController@RktOpd');
    Route::post('/rkt-opd/data', 'PerencanaanController@dataRktOpd');

    Route::get('/iku-opd/{organisasi_no}', 'PerencanaanController@dataIkuRenstra');

    Route::get('/pk-opd/{organisasi_no}', 'PerencanaanController@pkOpd');
    Route::post('/pk-opd/data', 'PerencanaanController@dataPkOpd');

    Route::get('/rkt', 'PerencanaanController@rkt');
    Route::post('/rkt/dataRkt', 'PerencanaanController@dataRktKab');

    Route::get('/iku', 'PerencanaanController@ikuRpjmd');

    Route::get('/pk', 'PerencanaanController@pkKab');
    Route::post('/pk/data', 'PerencanaanController@dataPkKab');

    Route::post('/rkt/dataRKT', 'PerencanaanController@dataRkt');

    Route::get('/pohon-kinerja', 'PerencanaanController@pohon_kinerja');
});

Route::group(['prefix' => 'capaian-kinerja'], function(){
    Route::get('/','CapaianController@index');
    Route::post('/data','CapaianController@data');
    Route::get('/indikator-sasaran', 'CapaianController@isRpjmd');
    Route::get('/indikator-program', 'CapaianController@ipRpjmd');
    // Route::get('/indikator-sasaran-opd', 'CapaianController@isRenstra');
    // Route::get('/indikator-program-opd', 'CapaianController@renstra2');
    // Route::get('/indikator-kegiatan-opd', 'CapaianController@renstra3');
    Route::get('/indikator-opd/{organisasi_no}', 'CapaianController@isRenstra');
    Route::get('/get-modal/{id}/triwulan/{triwulan}/tahun/{tahun}', 'CapaianController@getModal');
    // Route::get('/indikator-program-opd/{organisasi_no}', 'CapaianController@dataRktOpd');
    // Route::get('/indikator-kegiatan-opd/{organisasi_no}', 'CapaianController@dataIkuRenstra');
});

Route::group(['prefix' => 'pelaporan-kinerja'], function(){
    Route::get('/','PelaporanController@index');
    Route::get('form/{organisasi_no}','PelaporanController@form');
    Route::post('download-lkjip','PelaporanController@download');
    
});

Route::group(['prefix' => 'evaluasi-kinerja'], function(){
    Route::get('/','EvaluasiController@index_lhe');
    Route::post('/requestTahun','EvaluasiController@requestTahun');
    // Route::get('/create','EvaluasiController@create');
    // Route::post('/store','EvaluasiController@store');
    
});

Route::group(['prefix' => 'cascading'], function(){
    Route::get('/','CascadingController@index');
    Route::get('/kabupaten','CascadingController@kab');
    // Route::get('/pohon_kinerja','CascadingController@pohonKinerja');
    Route::get('/pohon-kinerja','CascadingController@pohonKinerja');
    Route::get('/pohon-kinerja-rpjmd', 'CascadingController@pohonKinerjaRpjmd');
    // Route::post('/data_pohon_kinerja','CascadingController@dataPohonKinerja');
    Route::post('/pohon-kinerja/data','CascadingController@dataPohonKinerja');
    Route::post('/pohon-kinerja-rpjmd/data','CascadingController@dataPohonKinerjaRpjmd');
    Route::get('/opd/{organisasi_no}','CascadingController@opd');
    Route::get('/opd/data/{organisasi_no}','CascadingController@opd');
    Route::post('download-cascading-rpjmd','CascadingController@download_cascading_rpjmd');
    
});

    Route::get('survei-skm','Admin\SKMController@index');
    Route::post('survei-skm/store','Admin\SKMController@store');

// admin
Auth::routes();

Route::group(['middleware' => 'auth'], function(){

    // Route::group(['middleware' => 'admin'], function(){

    // });

    // Route::group(['middleware' => 'user'], function(){

    // });
        Route::get('/home', 'HomeController@index')->name('home');

        Route::group(['prefix' => 'data'], function(){
        Route::get('/users', 'UserController@dataUser')->name('data.users'); //datatables
        Route::get('/orgs', 'OrganisasiController@dataOrgs')->name('data.orgs'); //datatables
        Route::get('/sats', 'SatuanController@dataSatuan')->name('data.sats'); //datatables
        Route::get('/prgrms', 'ProgramController@dataPrgrm')->name('data.prgrms'); //datatables
        Route::get('/kegiatans', 'KegiatanController@dataKeg')->name('data.keg'); //datatables
        Route::get('/pegs', 'PegawaiController@dataPegawai')->name('data.peg'); //datatables
        });

        // route user index
            Route::get('user/profile','UserController@indexUser');

        Route::group(['prefix' => 'master'], function(){
            Route::livewire('/user', 'user-index');
            Route::livewire('/organisasi', 'organisasi-index');
            Route::livewire('/program', 'program-index');
            Route::livewire('/kegiatan', 'kegiatan-index');
            Route::livewire('/satuan', 'satuan-index');
            // Route::resource('user','UserController');
            Route::get('user/cetak','UserController@print')->name('print.user');
            // Route::resource('organisasi','OrganisasiController');
            // Route::resource('program','ProgramController');
            // Route::resource('kegiatan','KegiatanController');
            // Route::resource('satuan','SatuanController');

            Route::group(['prefix' => 'galeri'], function(){
                Route::get('/list','GaleriController@admin');
                Route::get('/add','GaleriController@add');
                Route::post('/store','GaleriController@store');
                Route::get('/edit/{id}','GaleriController@edit');
                Route::put('/update/{id}','GaleriController@update');
                Route::get('/destroy/{id}','GaleriController@destroy');
            });
            
        });

            Route::resource('/pegawai','PegawaiController');
            Route::post('pegawai/dataPegawai', 'PegawaiController@dataPegawai');

            Route::group(['prefix' => 'skp'], function(){

                // admin skp
                Route::get('/fetch', 'Admin\SkpController@fetch');
                Route::get('/fetch-pegawai', 'Admin\SkpController@fetch_pegawai');
                Route::post('/get-pegawai', 'Admin\SkpController@get_pegawai');
                Route::get('/', 'Admin\SkpController@index');
                Route::get('/filter-skp/{id}', 'Admin\SkpController@filter_skp');
                Route::get('/detail/{id}', 'Admin\SkpController@detail');
                Route::post('/store', 'Admin\SkpController@store');
                Route::get('/edit/{id}', 'Admin\SkpController@edit');
                Route::put('/update/{id}', 'Admin\SkpController@update');
                Route::post('/destroy/{id}', 'Admin\SkpController@destroy');

            });

            // admin
            Route::group(['prefix' => 'admin', 'middleware' => 'Admin'], function(){
                // master
                Route::group(['prefix' => 'master'], function(){
                    Route::group(['prefix' => 'user'], function(){
                        Route::get('/', 'Admin\UserController@index');
                        Route::get('/fetch', 'Admin\UserController@fetch');
                        Route::get('/fetch_organisasi', 'Admin\UserController@fetch_organisasi');
                        Route::post('/store', 'Admin\UserController@store');
                        Route::get('/edit/{id}', 'Admin\UserController@edit');
                        Route::put('/update/{id}', 'Admin\UserController@update');
                        Route::get('/destroy/{id}', 'Admin\UserController@destroy');
                    });

                    Route::get('organisasi', 'Admin\OrganisasiController@index');
                    Route::get('/program', 'Admin\ProgramController@index');
                    Route::get('/kegiatan', 'Admin\KegiatanController@index');
                    Route::get('/satuan', 'Admin\SatuanController@index');

                    Route::group(['prefix' => 'galeri'], function(){
                        Route::get('/list','GaleriController@admin');
                        Route::get('/add','GaleriController@add');
                        Route::post('/store','GaleriController@store');
                        Route::get('/edit/{id}','GaleriController@edit');
                        Route::put('/update/{id}','GaleriController@update');
                        Route::get('/destroy/{id}','GaleriController@destroy');
                    });
                });

                // pegawai
                Route::group(['prefix' => 'pegawai'], function(){
                    Route::get('/fetch/{organisasi_no}', 'Admin\PegawaiController@fetch');
                    Route::get('/', 'Admin\PegawaiController@index');
                });

                Route::group(['prefix' => 'skp'], function(){
                    Route::get('/fetch', 'Admin\SkpController@fetch');
                    Route::get('/fetch-pegawai/{organisasi_no}', 'Admin\SkpController@fetch_pegawai');
                    Route::get('/fetch-organisasi', 'Admin\SkpController@fetch_organisasi');
                    Route::post('/get-pegawai', 'Admin\SkpController@get_pegawai');
                    Route::get('/', 'Admin\SkpController@index');
                    Route::get('/filter-skp/{id}', 'Admin\SkpController@filter_skp');
                    Route::get('/detail/{id}', 'Admin\SkpController@detail');
                    Route::post('/store', 'Admin\SkpController@store');
                    Route::get('/edit/{id}', 'Admin\SkpController@edit');
                    Route::put('/update/{id}', 'Admin\SkpController@update');
                    Route::get('/delete/{id}', 'Admin\SkpController@delete');
                    Route::post('/destroy', 'Admin\SkpController@destroy');
                });

                Route::group(['prefix' => 'iki'], function(){
                    Route::get('/fetch', 'Admin\IkiController@fetch');
                    Route::get('/fetch-organisasi', 'Admin\IkiController@fetch_organisasi');
                    Route::get('/fetch-pegawai-pimpinan/{organisasi_no}', 'Admin\IkiController@fetch_pegawai_pimpinan');
                    Route::get('/fetch-satuan', 'Admin\IkiController@fetch_satuan');
                    Route::post('/get-pegawai', 'Admin\IkiController@get_pegawai');
                    Route::get('/', 'Admin\IkiController@index');
                    Route::get('/filter-iki/{id}', 'Admin\IkiController@filter_iki');
                    Route::get('/detail/{id}', 'Admin\IkiController@detail');
                    Route::post('/store', 'Admin\IkiController@store');
                    Route::get('/edit/{id}', 'Admin\IkiController@edit');
                    Route::put('/update/{id}', 'Admin\IkiController@update');
                    Route::post('/destroy/{id}', 'Admin\IkiController@destroy');
                });


                Route::group(['prefix' => 'iku'], function(){
                    Route::post('/fetch', 'Admin\IkuController@fetch');
                    Route::get('/fetch-indikator_sasaran/{organisasi_no}', 'Admin\IkuController@fetch_indikator_sasaran');
                    Route::get('/fetch-organisasis', 'Admin\IkuController@fetch_organisasis');
                    Route::get('/', 'Admin\IkuController@index');
                    Route::get('/detail/{id}', 'Admin\IkuController@detail');
                    Route::post('/store', 'Admin\IkuController@store');
                    Route::get('/edit/{id}', 'Admin\IkuController@edit');
                    Route::put('/update/{id}', 'Admin\IkuController@update');
                    Route::post('/destroy', 'Admin\IkuController@destroy');
                });


                Route::group(['prefix' => 'perjanjian-kinerja'], function(){

                    Route::group(['prefix' => 'eselon-2'], function(){
                        Route::post('/fetch', 'Admin\PKEselon2Controller@fetch');
                        Route::get('/fetch-indikator-sasaran/{organisasi_no}', 'Admin\PKEselon2Controller@fetch_indikator_sasaran');
                        Route::get('/fetch-program', 'Admin\PKEselon2Controller@fetch_program');
                        Route::get('/fetch-jabatan', 'Admin\PKEselon2Controller@fetch_jabatan');
                        Route::get('/fetch-satuan', 'Admin\PKEselon2Controller@fetch_satuan');
                        Route::get('/', 'Admin\PKEselon2Controller@index');
                        Route::post('/store', 'Admin\PKEselon2Controller@store');
                        Route::get('/edit/{id}', 'Admin\PKEselon2Controller@edit');
                        Route::put('/update/{id}', 'Admin\PKEselon2Controller@update');
                        Route::post('/destroy/{id}', 'Admin\PKEselon2Controller@destroy');
                    });

                    Route::group(['prefix' => 'eselon-3'], function(){
                        Route::post('/fetch', 'Admin\PKEselon3Controller@fetch');
                        Route::get('/fetch-indikator_sasaran', 'Admin\PKEselon3Controller@fetch_indikator_sasaran');
                        Route::get('/fetch-program', 'Admin\PKEselon3Controller@fetch_program');
                        Route::get('/fetch-jabatan', 'Admin\PKEselon3Controller@fetch_jabatan');
                        Route::get('/fetch-satuan', 'Admin\PKEselon3Controller@fetch_satuan');
                        Route::get('/', 'Admin\PKEselon3Controller@index');
                        Route::post('/store', 'Admin\PKEselon3Controller@store');
                        Route::get('/edit/{id}', 'Admin\PKEselon3Controller@edit');
                        Route::put('/update/{id}', 'Admin\PKEselon3Controller@update');
                        Route::post('/destroy/{id}', 'Admin\PKEselon3Controller@destroy');
                    });


                    Route::group(['prefix' => 'eselon-4'], function(){
                        Route::post('/fetch', 'Admin\PKEselon4Controller@fetch');
                        Route::get('/fetch-indikator_sasaran', 'Admin\PKEselon4Controller@fetch_indikator_sasaran');
                        Route::get('/fetch-kegiatan', 'Admin\PKEselon4Controller@fetch_kegiatan');
                        Route::get('/fetch-jabatan', 'Admin\PKEselon4Controller@fetch_jabatan');
                        Route::get('/fetch-satuan', 'Admin\PKEselon4Controller@fetch_satuan');
                        Route::get('/', 'Admin\PKEselon4Controller@index');
                        Route::post('/store', 'Admin\PKEselon4Controller@store');
                        Route::get('/edit/{id}', 'Admin\PKEselon4Controller@edit');
                        Route::put('/update/{id}', 'Admin\PKEselon4Controller@update');
                        Route::post('/destroy/{id}', 'Admin\PKEselon4Controller@destroy');
                    });

                });


                Route::group(['prefix' => 'skm'], function(){
                    Route::get('/fetch', 'Admin\SkmAdminController@fetch');
                    Route::get('/', 'Admin\SkmAdminController@index');
                });

                Route::group(['prefix' => 'monitoring'], function(){
		            Route::get('/skp', 'Admin\MonitoringController@skp');
		            Route::get('/fetch-skp', 'Admin\MonitoringController@fetch_skp');
		            Route::get('/cetak-skp', 'Admin\MonitoringController@cetak_skp_pdf');

		            Route::get('/', 'Admin\MonitoringController@lkjip');
		            Route::get('/iki', 'Admin\MonitoringController@iki');
		            Route::get('/lkjip', 'Admin\MonitoringController@lkjip');
		            Route::get('/capaian', 'Admin\MonitoringController@capaian');
		            Route::get('/pk', 'Admin\MonitoringController@pk');
		            Route::get('/cetak-pk', 'Admin\MonitoringController@cetak_pk_pdf');
		            Route::get('/cetak-iki', 'Admin\MonitoringController@cetak_iki_pdf');
		            Route::get('/cetak-lkjip', 'Admin\MonitoringController@cetak_lkjip_pdf');
		            Route::get('/cetak-iku', 'Admin\MonitoringController@cetak_iku_pdf');
		            Route::get('/cetak-cascading', 'Admin\MonitoringController@cetak_cascading_pdf');
		            Route::get('/cascading-cross-cutting', 'Admin\MonitoringController@cascading_cross_cutting');
		            Route::get('/iku', 'Admin\MonitoringController@iku');
		        });

                Route::group(['prefix' => 'sistem'], function(){
                    Route::get('/integrasi', 'Admin\IntegrasiController@index');
                    Route::get('/integrasi/getPegawai', 'Admin\IntegrasiController@getPegawai');
                    Route::get('/integrasi/getJabatan', 'Admin\IntegrasiController@getJabatan');
                    Route::get('/integrasi/get-api-simpeg', 'API\Simpeg\SimpegIntegrasiController@index');
                    Route::get('/integrasi/get-jabatan-simpeg', 'API\Simpeg\JabatanSimpegController@index');


                    Route::get('/control-sistem', 'Admin\ControlSistemController@index');
                });


            });

            // end admin

            // user
            Route::group(['prefix' => 'user', 'middleware' => 'User'], function(){

                Route::group(['prefix' => 'perencanaan'], function(){
                    Route::group(['prefix' => 'renstra'], function(){
                        Route::group(['prefix' => 'tujuan-renstra'], function(){
                            Route::get('/fetch', 'User\TujuanRenstraController@fetch');
                            Route::get('/', 'User\TujuanRenstraController@index');
                        });

                        Route::group(['prefix' => 'sasaran-renstra'], function(){
                            Route::get('/fetch', 'User\SasaranRenstraController@fetch');
                            Route::get('/', 'User\SasaranRenstraController@index');
                        });

                        Route::group(['prefix' => 'program-kegiatan-renstra'], function(){
                            Route::get('/fetch', 'User\ProgramKegiatanRenstraController@fetch');
                            Route::get('/', 'User\ProgramKegiatanRenstraController@index');
                        });

                    });

                });

                Route::group(['prefix' => 'rkt'], function(){
                    Route::post('/fetch', 'User\RktController@fetch');
                    Route::get('/', 'User\RktController@index');
                });

                Route::group(['prefix' => 'skp'], function(){
                    Route::get('/fetch', 'User\SkpController@fetch');
                    Route::get('/fetch-pegawai', 'User\SkpController@fetch_pegawai');
                    Route::post('/get-pegawai', 'User\SkpController@get_pegawai');
                    Route::get('/', 'User\SkpController@index');
                    Route::get('/filter-skp/{id}', 'User\SkpController@filter_skp');
                    Route::get('/detail/{id}', 'User\SkpController@detail');
                    Route::post('/store', 'User\SkpController@store');
                    Route::get('/edit/{id}', 'User\SkpController@edit');
                    Route::put('/update/{id}', 'User\SkpController@update');
                    Route::post('/destroy/{id}', 'User\SkpController@destroy');
                });

                Route::group(['prefix' => 'iki'], function(){
                    Route::get('/fetch', 'User\IkiController@fetch');
                    Route::get('/fetch-pegawai-pimpinan', 'User\IkiController@fetch_pegawai_pimpinan');
                    Route::get('/fetch-satuan', 'User\IkiController@fetch_satuan');
                    Route::post('/get-pegawai', 'User\IkiController@get_pegawai');
                    Route::get('/', 'User\IkiController@index');
                    Route::get('/filter-iki/{id}', 'User\IkiController@filter_iki');
                    Route::get('/detail/{id}', 'User\IkiController@detail');
                    Route::post('/store', 'User\IkiController@store');
                    Route::get('/edit/{id}', 'User\IkiController@edit');
                    Route::put('/update/{id}', 'User\IkiController@update');
                    Route::post('/destroy/{id}', 'User\IkiController@destroy');
                });

                Route::group(['prefix' => 'iku'], function(){
                    Route::post('/fetch', 'User\IkuController@fetch');
                    Route::get('/fetch-indikator_sasaran', 'User\IkuController@fetch_indikator_sasaran');
                    Route::get('/', 'User\IkuController@index');
                    Route::get('/detail/{id}', 'User\IkuController@detail');
                    Route::post('/store', 'User\IkuController@store');
                    Route::get('/edit/{id}', 'User\IkuController@edit');
                    Route::put('/update/{id}', 'User\IkuController@update');
                    Route::post('/destroy', 'User\IkuController@destroy');
                });

                Route::group(['prefix' => 'perjanjian-kinerja'], function(){

                    Route::group(['prefix' => 'eselon-2'], function(){
                        Route::post('/fetch', 'User\PKEselon2Controller@fetch');
                        Route::get('/fetch-indikator_sasaran', 'User\PKEselon2Controller@fetch_indikator_sasaran');
                        Route::get('/fetch-program/{tahun}', 'User\PKEselon2Controller@fetch_program');
                        Route::get('/fetch-jabatan', 'User\PKEselon2Controller@fetch_jabatan');
                        Route::get('/fetch-satuan', 'User\PKEselon2Controller@fetch_satuan');
                        Route::get('/', 'User\PKEselon2Controller@index');
                        Route::post('/store', 'User\PKEselon2Controller@store');
                        Route::post('/dpa', 'User\PKEselon2Controller@dpa');
                        Route::get('/edit/{id}', 'User\PKEselon2Controller@edit');
                        Route::put('/update/{id}', 'User\PKEselon2Controller@update');
                        Route::post('/destroy/{id}', 'User\PKEselon2Controller@destroy');
                    });

                    Route::group(['prefix' => 'eselon-3'], function(){
                        Route::post('/fetch', 'User\PKEselon3Controller@fetch');
                        // Route::get('/fetch-indikator_sasaran', 'User\PKEselon3Controller@fetch_indikator_sasaran');
                        Route::get('/fetch-program/{tahun}', 'User\PKEselon3Controller@fetch_program');
                        Route::get('/fetch-jabatan', 'User\PKEselon3Controller@fetch_jabatan');
                        Route::get('/fetch-satuan', 'User\PKEselon3Controller@fetch_satuan');
                        Route::get('/', 'User\PKEselon3Controller@index');
                        Route::post('/store', 'User\PKEselon3Controller@store');
                        Route::post('/dpa', 'User\PKEselon3Controller@dpa');
                        Route::get('/edit/{id}', 'User\PKEselon3Controller@edit');
                        Route::put('/update/{id}', 'User\PKEselon3Controller@update');
                        Route::post('/destroy/{id}', 'User\PKEselon3Controller@destroy');
                    });


                    Route::group(['prefix' => 'eselon-4'], function(){
                        Route::post('/fetch', 'User\PKEselon4Controller@fetch');
                        Route::get('/fetch-indikator_sasaran/{organisasi_no}', 'User\PKEselon4Controller@fetch_indikator_sasaran');
                        Route::get('/fetch-kegiatan/{tahun}', 'User\PKEselon4Controller@fetch_kegiatan');
                        Route::get('/fetch-jabatan', 'User\PKEselon4Controller@fetch_jabatan');
                        Route::get('/fetch-satuan', 'User\PKEselon4Controller@fetch_satuan');
                        Route::get('/', 'User\PKEselon4Controller@index');
                        Route::post('/store', 'User\PKEselon4Controller@store');
                        Route::post('/dpa', 'User\PKEselon4Controller@dpa');
                        Route::get('/edit/{id}', 'User\PKEselon4Controller@edit');
                        Route::put('/update/{id}', 'User\PKEselon4Controller@update');
                        Route::post('/destroy/{id}', 'User\PKEselon4Controller@destroy');
                    });

                });


                Route::group(['prefix' => 'pengukuran-kinerja'], function(){
                    Route::post('/fetch', 'User\PengukuranKinerjaController@fetch');
                    Route::get('/', 'User\PengukuranKinerjaController@index');
                    Route::post('/detail', 'User\PengukuranKinerjaController@detail');
                    Route::put('/update/{id}', 'User\PengukuranKinerjaController@update');
                    Route::post('/cetak', 'User\PengukuranKinerjaController@cetak');
                });

                Route::group(['prefix' => 'lkjip'], function(){
                    Route::post('/fetch', 'User\LkjipController@fetch');
                    Route::get('/', 'User\LkjipController@index');
                    Route::post('/store', 'User\LkjipController@store');
                    Route::post('/destroy/{id}', 'User\LkjipController@destroy');
                    Route::get('/download/{id}', 'User\LkjipController@download');
                });

                Route::group(['prefix' => 'cascading'], function(){
                    Route::post('/fetch', 'User\CascadingController@fetch');
                    Route::get('/', 'User\CascadingController@index');
                    Route::post('/store', 'User\CascadingController@store');
                    Route::post('/destroy/{id}', 'User\CascadingController@destroy');
                    Route::get('/download/{id}', 'User\CascadingController@download');
                });

                Route::group(['prefix' => 'lhe'], function(){
                    Route::post('/fetch', 'User\LheController@fetch');
                    Route::get('/', 'User\LheController@index');
                    Route::put('/update/{id}', 'User\LheController@update');
                });

                Route::group(['prefix' => 'pegawai'], function(){
                    Route::get('/fetch', 'User\PegawaiController@fetch');
                    Route::get('/', 'User\PegawaiController@index');
                    Route::get('/search/{nip}', 'User\PegawaiController@search');
                    Route::get('/simpan/{id}', 'User\PegawaiController@simpan');
                    Route::get('/delete/{id}', 'User\PegawaiController@delete');
                    Route::get('/cetak-pk-pdf/{id}', 'User\PegawaiController@cetak_pk_pdf');
                    Route::get('/cetak-pk-word/{id}', 'User\PegawaiController@cetak_pk_word');
                });

                Route::group(['prefix' => 'cetak'], function(){
                    Route::get('/', 'User\CetakController@index');
                    Route::get('/cetak-pk-pdf', 'User\CetakController@cetak_pk_pdf');
                    Route::get('/cetak-pk-word/{id}', 'User\CetakController@cetak_pk_word');
                });


            });

            
            // Route::resource('skp','SkpController');
            // Route::get('skp/dataSkp/{id}','SkpController@dataSkp');
            // Route::post('skp/getPegawai','SkpController@get_pegawai');
            // Route::get('skp_cek_pejabat/{status}','SkpController@skp_cek_pejabat');
            // Route::post('skp/indexRequest','SkpController@indexRequest');


            Route::resource('iki','IkiController');
            // Route::get('create_iki','IkiController@test');
            Route::post('iki/dataPegawai','IkiController@get_pegawai');
            Route::get('iki/dataIki/{id}','IkiController@dataIki');
            Route::post('dataRequest','IkiController@dataRequest');
            // Route::post('iki','IkiController@index');
            Route::resource('sasaran','SasaranController');
            Route::get('sasaran/ajax/{id}','SasaranController@ajax');    
        // });
        // Route::resource('master_user','UserController');
        // Route::get('user/create', 'UserController@create');
        // Route::post('user/update','UserController@store')->name('user.update');



        Route::group(['prefix' => 'perencanaan'], function(){

           // pk
            Route::resource('perjanjian-kinerja','PerjanjianKinerjaController');
            Route::post('perjanjian-kinerja/data','PerjanjianKinerjaController@dataPk');

            // eselon 3
            Route::get('pk/create-eselon-III','PerjanjianKinerjaController@create_eselon_III');
            Route::post('perjanjian-kinerja/store-eselon-III','PerjanjianKinerjaController@store_eselon_III');
            Route::get('perjanjian-kinerja/edit-eselon-III/{id}','PerjanjianKinerjaController@edit_eselon_III');
            Route::put('perjanjian-kinerja/update-eselon-III/{id}','PerjanjianKinerjaController@update_eselon_III');
            Route::delete('perjanjian-kinerja/destroy-eselon-III/{id}','PerjanjianKinerjaController@destroy_eselon_III');

            // eselon 4
            Route::get('pk/create-eselon-IV','PerjanjianKinerjaController@create_eselon_IV');
            Route::post('perjanjian-kinerja/store-eselon-IV','PerjanjianKinerjaController@store_eselon_IV');
            Route::get('perjanjian-kinerja/edit-eselon-IV/{id}','PerjanjianKinerjaController@edit_eselon_IV');
            Route::put('perjanjian-kinerja/update-eselon-IV/{id}','PerjanjianKinerjaController@update_eselon_IV');
            Route::delete('perjanjian-kinerja/destroy-eselon-IV/{id}','PerjanjianKinerjaController@destroy_eselon_IV');

            // //renstra-baru
            // Route::get('rencana-strategis-opd','RencanaStrategisController@index');

            Route::get('rencana-strategis/tambah-tujuan','RencanaStrategisController@tambahTujuan');
            Route::post('rencana-strategis/tambah-tujuan/store','RencanaStrategisController@storeTujuan');

            Route::get('rencana-strategis/tambah-indikator-tujuan','RencanaStrategisController@tambahIndikatorTujuan');
            Route::post('rencana-strategis/tambah-indikator-tujuan/store','RencanaStrategisController@storeIndikatorTujuan');
            
            Route::get('rencana-strategis/tambah-sasaran','RencanaStrategisController@tambahSasaran');
            Route::post('rencana-strategis/tambah-sasaran/store','RencanaStrategisController@storeSasaran');
            Route::get('rencana-strategis/sasaran/edit/{id}','RencanaStrategisController@edit_sasaran');
            Route::put('rencana-strategis/sasaran/update/{id}','RencanaStrategisController@update_sasaran');
            Route::get('rencana-strategis/sasaran/delete/{id}','RencanaStrategisController@destroy_sasaran');

            Route::get('rencana-strategis/tambah-indikator-sasaran','RencanaStrategisController@tambahIndikatorSasaran');
            Route::post('rencana-strategis/tambah-indikator-sasaran/store','RencanaStrategisController@storeIndikatorSasaran');
            Route::get('rencana-strategis/indikator-sasaran/edit/{id}','RencanaStrategisController@edit_indikator_sasaran');
            Route::put('rencana-strategis/indikator-sasaran/update/{id}','RencanaStrategisController@update_indikator_sasaran');
            Route::get('rencana-strategis/indikator-sasaran/delete/{id}','RencanaStrategisController@destroy_indikator_sasaran');


            // tujuan renstra
            Route::get('rencana-strategis','RencanaStrategisController@index');
            Route::get('rencana-strategis/show/{id}','RencanaStrategisController@show');
            Route::get('rencana-strategis/edit/{id}','RencanaStrategisController@edit');
            Route::put('rencana-strategis/update/{id}','RencanaStrategisController@update');
            Route::get('rencana-strategis/delete/{id}','RencanaStrategisController@destroy');


            Route::post('rencana-strategis/dataRenstra','RencanaStrategisController@dataRenstra');

            
            
            Route::resource('rpjmd','RpjmdController');
            
            Route::resource('rpjmd-visi_misi','RpjmdController');

            Route::resource('rpjmd-tujuan','TujuanRpjmdController');
            Route::resource('rpjmd-sasaran','SasaranRpjmdController');
            Route::resource('rpjmd-program','ProgramRpjmdController');
            Route::get('rpjmd-indikator-program-target/create','ProgramRpjmdController@tambahIndikator');



            //RENSTRA LAMA
            Route::resource('renstra-tujuan','TujuanRenstraController');
            Route::post('renstra-tujuan/dataTujuan','TujuanRenstraController@dataRenstra');
            // Route::resource('renstra-tujuan','TujuanRenstraController');

            // indikator tujuan renstra
            Route::get('renstra-tujuan-indikator/create','TujuanRenstraController@createIndikatorRenstra');
            Route::post('renstra-tujuan-indikator/storeIndikatorRenstra','TujuanRenstraController@storeIndikatorRenstra');
            Route::get('renstra-tujuan-indikator/editIndikatorRenstra/{id}','TujuanRenstraController@editIndikatorRenstra');
            Route::put('renstra-tujuan-indikator/updateIndikatorRenstra/{id}','TujuanRenstraController@updateIndikatorRenstra');
            Route::delete('renstra-tujuan-indikator/destroyIndikatorRenstra/{id}','TujuanRenstraController@destroyIndikatorRenstra');
            Route::get('renstra-tujuan-indikator/ajax/{id}','TujuanRenstraController@ajaxTujuanRenstra');

            // Route::get('program/create','ProgramRpjmdController@create');


            // sasaran renstra
            Route::resource('renstra-sasaran','SasaranRenstraController');
            Route::post('renstra-sasaran/dataSasaran','SasaranRenstraController@dataRenstra');
            Route::get('renstra-sasaran/ajax/{id}','SasaranRenstraController@ajax');

            // indikator sasaran renstra
            Route::get('renstra-indikator-sasaran/create','SasaranRenstraController@createIndikatorSasaran');
            Route::post('renstra-indikator-sasaran/storeIndikatorSasaran','SasaranRenstraController@storeIndikatorSasaran');
            Route::get('renstra-indikator-sasaran/editIndikatorSasaran/{id}','SasaranRenstraController@editIndikatorSasaran');
            Route::put('renstra-indikator-sasaran/updateIndikatorSasaran/{id}','SasaranRenstraController@updateIndikatorSasaran');
            Route::delete('renstra-indikator-sasaran/destroyIndikatorSasaran/{id}','SasaranRenstraController@destroyIndikatorSasaran');
            Route::get('renstra-indikator-sasaran/ajaxIndikator/{id}','SasaranRenstraController@ajaxIndikator');
            Route::get('renstra-sasaran/ajax/{id}','SasaranRenstraController@ajax');
            // Route::post('renstra-sasaran/data', 'SasaranRenstraController@data')->name('sasarandynamic.data');

            Route::resource ('renstra-program','ProgKegRenstraController');


            Route::get('renstra-program-indikator/tambah','ProgKegRenstraController@createProgramIndikator');
            Route::post('renstra-program-indikator/store','ProgKegRenstraController@storeProgramIndikator');
            Route::get('renstra-program-indikator/edit/{id}','ProgKegRenstraController@editProgramIndikator');
            Route::put('renstra-program-indikator/update/{id}','ProgKegRenstraController@updateProgramIndikator');
            Route::delete('renstra-program-indikator/destroy/{id}','ProgKegRenstraController@destroyProgramIndikator');
            Route::get('renstra-program-indikator/ajaxIndikator/{org_no}','ProgKegRenstraController@ajaxProgramIndikator');

            Route::get('renstra-kegiatan-indikator/tambah','ProgKegRenstraController@createKegiatanIndikator');
            Route::post('renstra-kegiatan-indikator/store','ProgKegRenstraController@storeKegiatanIndikator');

            Route::get('renstra-program/ajaxIndikator/{id}','ProgKegRenstraController@ajaxIndikator');
            Route::get('renstra-program/ajaxProgram/{id}','ProgKegRenstraController@ajaxProgram');
            Route::post('renstra-program/dataProgram','ProgKegRenstraController@dataProgram');

            Route::get ('renstra-kegiatan','ProgKegRenstraController@kegiatan');
            Route::post('renstra-kegiatan/dataKegiatan','ProgKegRenstraController@dataKegiatan');





            Route::resource('rkt-kab','RktController');
            Route::post('rkt-kab/dataRkt','RktController@dataRkt');
            Route::resource('rkt-opd','RktOpdController');
            Route::post('rkt-opd/dataRkt','RktOpdController@dataRKT');
            Route::get('rkt-sasaran/editRKT/{id}','SasaranRenstraController@editRKT');
            Route::put('rkt-sasaran/updateRKT/{id}','SasaranRenstraController@updateRKT');

            Route::get ('rkt-program','ProgKegRenstraController@programRkt');
            Route::post('rkt-program/dataProgram','ProgKegRenstraController@dataProgramRKT');

            Route::get ('rkt-kegiatan','ProgKegRenstraController@kegiatanRkt');
            Route::post('rkt-kegiatan/dataKegiatan','ProgKegRenstraController@dataKegiatanRKT');


            Route::resource ('iku-rpjmd','IkuRpjmdController');

            Route::resource ('iku-renstra','IkuRenstraController');
            Route::post('iku-renstra/dataIku','IkuRenstraController@dataIku');


            Route::get('upload-cascading-rpjmd','CascadingController@index_upload_cascading_rpjmd');
            Route::post('download-cascading-rpjmd','CascadingController@download_cascading_rpjmd');
            Route::post('data-upload-cascading-rpjmd','CascadingController@data_upload_cascading_rpjmd');
            Route::post('upload-cascading-rpjmd/store','CascadingController@upload_cascading_rpjmd');
            Route::delete('upload-cascading-rpjmd/delete/{id}','CascadingController@delete_upload_cascading_rpjmd');



        });

			Route::delete('perencanaan/iku-renstra/destroy/{id}','IkuRenstraController@destroy');
			Route::put('perencanaan/renstra-program/update/{id}','ProgKegRenstraController@update');

        Route::group(['prefix' => 'capaian'], function(){

            Route::get('/','CapaianAdminController@index');
            Route::get('sasaran/edit/{id}','CapaianAdminController@edit_sasaran');
            Route::put('sasaran/update/{id}','CapaianAdminController@update_sasaran');
            Route::post('capaianRequest','CapaianAdminController@dataRequest');

            Route::get('/test','CapaianAdminController@indexTest');
            Route::post('capaianRequestTest','CapaianAdminController@dataRequestTest');
        });



        Route::group(['prefix' => 'laporan'], function(){

            Route::resource('/lkjip','LkjipController');
            Route::post('/upload-lkjip','LkjipController@upload');
            Route::post('/download-lkjip','LkjipController@download');
            Route::post('/dataRequest','LkjipController@dataRequest');
            // Route::get('/ajax-view-lkjip/{id}','LkjipController@ajax_view_lkjip');
            Route::get('/lkjip/download/{organisasi_no}','LkjipController@download');
            
        });

        Route::group(['prefix' => 'evaluasi'], function(){

            Route::resource('/lhe','EvaluasiController');
            Route::post('/requestLhe','EvaluasiController@requestLhe');
            
        });


});


// get Api Integrasi

Route::get('php_info', function(){
	 phpinfo();
});

Route::get('qr-code', function () 
{
  return QRCode::text('QR Code Generator for Laravel!')->png();    
});


Route::get('sakip-2021/permen-90/mapping-all', function(){

    $url = '192.168.15.125/e-planning/api-permen90/all';

        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch);
        curl_close($ch);      
        $res_api = json_decode($output);

        if(count(DB::table('mapping_13_90')->get()) == 0)
        {
            foreach ($res_api as $value) {
                DB::table('mapping_13_90')->insert([
                    'kegiatan_no13' => $value->kegiatan_no13,
                    'kegiatan13' => $value->kegiatan13,
                    'program_no13' => $value->program_no13,
                    'program_nama13' => $value->program_nama13,
                    'kode_sub_kegiatan90' => $value->kode_sub_kegiatan90,
                    'nama_sub90' => $value->nama_sub90,
                    'kode_kegiatan90' => $value->kode_kegiatan90,
                    'nama_kegiatan90' => $value->nama_kegiatan90,
                    'kode_program90' => $value->kode_program90,
                    'nama_program90' => $value->nama_program90,
                    'kode_urusan90' => $value->kode_urusan90,
                    'nama_urusan' => $value->nama_urusan,
                    'bidang_urusan' => $value->bidang_urusan,
                    'keterangan_mapping' => $value->keterangan_mapping,
                    'organisasi_no' => $value->organisasi_no,
                    'organisasi_nama' => $value->organisasi_nama
                ]);
            }
        }


        return 'success';
});


Route::get('sakip-2021/permen-90/usulan-rankhir', function(){

    $url = '192.168.15.125/e-planning/api-permen90/usulanrankhir';

        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch);
        curl_close($ch);      
        $res_api = json_decode($output);

        if(count(DB::table('usulanrankhir')->get()) == 0)
        {
            foreach ($res_api->data as $value) {
                DB::table('usulanrankhir')->insert([
                    'organisasi_no' => $value->organisasi_no,
                    'id_usulan' => $value->id_usulan,
                    'program_no' => $value->program_no,
                    'program_nama' => $value->program_nama,
                    'kegiatan_no' => $value->kegiatan_no,
                    'kegiatan_nama' => $value->kegiatan_nama,
                    'pagu' => $value->pagu,
                    'pagu_verifikasi' => $value->pagu_verifikasi
                ]);
            }
        }


        return 'success';
});


Route::get('sakip-2021/permen-90/mapping90', function(){

    $url = '192.168.15.125/e-planning/api-permen90/mapping90';

        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch);
        curl_close($ch);      
        $res_api = json_decode($output);

        if(count(DB::table('mapping90')->get()) == 0)
        {
            foreach ($res_api->data as $value) {
                DB::table('mapping90')->insert([
                    'id' => $value->id,
                    'kegiatan_no' => $value->kegiatan_no,
                    'sub_kegiatan_no' => $value->sub_kegiatan_no,
                    'kodesubkegiatan' => $value->kodesubkegiatan,
                    'keterangan' => $value->keterangan,
                    'created_by' => $value->created_by,
                    'updated_by' => $value->updated_by,
                    'created_at' => $value->created_at,
                    'updated_at' => $value->updated_at
                ]);
            }
        }


        return 'success';
});


Route::get('sakip-2021/permen-90/subkegiatan90', function(){

    $url = '192.168.15.125/e-planning/api-permen90/subkegiatan90';

        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch);
        curl_close($ch);      
        $res_api = json_decode($output);

        if(count(DB::table('subkegiatan90')->get()) == 0)
        {
            foreach ($res_api->data as $value) {
                DB::table('subkegiatan90')->insert([
                    'id' => $value->id,
                    'kode_u' => $value->kode_u,
                    'kode_bu' => $value->kode_bu,
                    'kode_p' => $value->kode_p,
                    'kode_k' => $value->kode_k,
                    'kode_sk' => $value->kode_sk,
                    'nama' => $value->nama,
                    'uraisubkegiatan' => $value->uraisubkegiatan,
                    'kodesubkegiatan' => $value->kodesubkegiatan,
                    'kode_subkegiatan' => $value->kode_subkegiatan,
                    'sub_kegiatan_no' => $value->sub_kegiatan_no,
                    'sub_kegiatan_no2' => $value->sub_kegiatan_no2,
                    'sub_kegiatan_no3' => $value->sub_kegiatan_no3,
                    'induk_kegiatan' => $value->induk_kegiatan,
                    'created_by' => $value->created_by,
                    'updated_by' => $value->updated_by,
                    'created_at' => $value->created_at,
                    'updated_at' => $value->updated_at
                ]);
            }
        }


        return 'success';
});


Route::get('sakip-2021/permen-90/kegiatan90', function(){

    $url = '192.168.15.125/e-planning/api-permen90/kegiatan90';

        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch);
        curl_close($ch);      
        $res_api = json_decode($output);

        if(count(DB::table('kegiatan90')->get()) == 0)
        {
            foreach ($res_api->data as $value) {
                DB::table('kegiatan90')->insert([
                    'id' => $value->id,
                    'kode_u' => $value->kode_u,
                    'kode_bu' => $value->kode_bu,
                    'kode_p' => $value->kode_p,
                    'kode_k' => $value->kode_k,
                    'nama' => $value->nama,
                    'kode_kegiatan' => $value->kode_kegiatan,
                    'kode_kegiatan_2' => $value->kode_kegiatan_2,
                    'created_by' => $value->created_by,
                    'updated_by' => $value->updated_by,
                    'created_at' => $value->created_at,
                    'updated_at' => $value->updated_at
                ]);
            }
        }


        return 'success';
});


Route::get('sakip-2021/permen-90/program90', function(){

    $url = '192.168.15.125/e-planning/api-permen90/program90';

        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch);
        curl_close($ch);      
        $res_api = json_decode($output);

        if(count(DB::table('program90')->get()) == 0)
        {
            foreach ($res_api->data as $value) {
                DB::table('program90')->insert([
                    'id' => $value->id,
                    'kode_u' => $value->kode_u,
                    'kode_bu' => $value->kode_bu,
                    'kode_p' => $value->kode_p,
                    'nama' => $value->nama,
                    'kode_program' => $value->kode_program,
                    'kode_program2' => $value->kode_program2,
                    'induk' => $value->induk,
                    'created_by' => $value->created_by,
                    'updated_by' => $value->updated_by,
                    'created_at' => $value->created_at,
                    'updated_at' => $value->updated_at
                ]);
            }
        }


        return 'success';
});


Route::get('sakip-2021/permen-90/usulan90', function(){

    $url = '192.168.15.125/e-planning/api-permen90/usulan90';

        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch);
        curl_close($ch);      
        $res_api = json_decode($output);

        if(count(DB::table('usulan90')->get()) == 0)
        {
            foreach ($res_api->data as $value) {
                DB::table('usulan90')->insert([
                    'id' => $value->id,
                    'kode' => $value->kode,
                    'kode2' => $value->kode2,
                    'nama' => $value->nama,
                    'jenis' => $value->jenis,
                    'induk' => $value->induk,
                    'created_at' => $value->created_at,
                    'updated_at' => $value->updated_at
                ]);
            }
        }


        return 'success';
});