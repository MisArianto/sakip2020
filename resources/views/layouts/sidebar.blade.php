{{-- <aside class="main-sidebar" >

      @if(Auth::user()->level == 1)
      <ul class="sidebar-menu" data-widget="tree">
        <li>-</li>
        <li class="treeview">
          <a href="#" style="color: #eaeaea;">
            <i class="lnr lnr-cog">&nbsp; </i> <span>Master</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="/master/user" data-turbolinks-action="replace"> User</a></li>
            <li><a href="/master/organisasi"> Organisasi</a></li>
            <li><a href="/master/program"> Program</a></li>
            <li><a href="/master/kegiatan"> Kegiatan</a></li>
            <li><a href="/master/satuan"> Satuan</a></li>
            <li><a href="{{url('master/galeri/list')}}"> Galeri</a></li>
          </ul>
        </li>
        
        <li class="treeview">
          <a href="#" style="color: #eaeaea;">
            <i class="lnr lnr-users">&nbsp; </i> <span>Data Pegawai</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('pegawai.index')}}"> Data Pegawai</a></li>
            <li><a href="{{route('skp.index')}}"> SKP</a></li>
            <li><a href="{{route('iki.index')}}"> IKI</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#" style="color: #eaeaea;">
            <i class="lnr lnr-list">&nbsp; </i> <span>Perencanaan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{url('perencanaan/rpjmd')}}"> RPJMD</a></li>
            <li><a href="{{url('perencanaan/rencana-strategis')}}"> Renstra</a></li>
            <li><a href="{{url('perencanaan/upload-cascading-rpjmd')}}"> cascading RPJMD</a></li>
            
            <li class="treeview">
              <a href="#"> RKT
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{url ('perencanaan/rkt-kab')}}"> RKT Kabupaten</a></li>
                <li><a href="{{url ('perencanaan/rkt-opd')}}"> RKT OPD</a></li>
                
              </ul>
            </li>
            <li class="treeview">
              <a href="#"> IKU
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{url ('perencanaan/iku-rpjmd')}}"> IKU Kabupaten</a></li>
                <li><a href="{{url ('perencanaan/iku-renstra')}}"> IKU OPD</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#"> Perjanjian Kinerja
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"> PK Kabupaten</a></li>
               <li class="treeview">
                  <a href="#"> PK OPD 
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="{{ route('perjanjian-kinerja.index') }}"> PK Eselon II</a></li>
                    <li><a href="#"> PK Eselon III</a></li>
                    <li><a href="#"> PK Eselon IV</a></li>
                  </ul>
                </li>
                
              </ul>
            </li>
          </ul>
        </li>
        
        <li class="treeview">
        <a href="{{ url('capaian') }}" style="color: #eaeaea;">
            <i class="lnr lnr-chart-bars">&nbsp; </i> <span>Pengukuran</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @if(Auth::user()->level == 1)
            <li><a href="{{ url('capaian') }}">Capaian Kabupaten</a></li>
            @endif
            <li><a href="{{ url('capaian') }}">Capaian OPD</a></li>
            
          </ul>
        </li>
        <li class="treeview">
          <a href="#" style="color: #eaeaea;">
            <i class="lnr lnr-checkmark-circle">&nbsp; </i> <span>Pelaporan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('lkjip.index') }}">LKjIP</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#" style="color: #eaeaea;">
            <i class="lnr lnr-magic-wand"> </i>&nbsp; <span>Evaluasi</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('lhe.index') }}">Laporan Hasil Evaluasi</a></li>
          </ul>
        </li>
      </ul>
      @endif


      @if(Auth::user()->level == 2)
        <ul class="sidebar-menu" data-widget="tree">
        <li>-</li>
        <li class="treeview">
          <a href="#" style="color: #eaeaea;">
            <i class="lnr lnr-cog">&nbsp; </i> <span>Master</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ url('user/profile')}}">Data User</a></li>
          </ul>
        </li>
        
        <li class="treeview">
          <a href="#" style="color: #eaeaea;">
            <i class="lnr lnr-users">&nbsp; </i> <span>Data Pegawai</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('pegawai.index')}}"> Data Pegawai</a></li>
            <li><a href="{{url('skp')}}"> SKP</a></li>
            <li><a href="{{route('iki.index')}}"> IKI</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#" style="color: #eaeaea;">
            <i class="lnr lnr-list">&nbsp; </i> <span>Perencanaan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{url('perencanaan/rpjmd')}}"> RPJMD</a></li>
            <li>
              <a href="{{url('perencanaan/rencana-strategis')}}"> Renstra &nbsp;<span style="background-color: red;" class="badge badge-pill badge-primary">Baru</span></a>
            </li>
            
            <li class="treeview">
              <a href="#"> RKT
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{url ('perencanaan/rkt-kab')}}"> RKT Kabupaten</a></li>
                <li><a href="{{url ('perencanaan/rkt-opd')}}"> RKT OPD</a></li>
                
              </ul>
            </li>

            <li class="treeview">
              <a href="#"> IKU
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{url ('perencanaan/iku-rpjmd')}}"> IKU Kabupaten</a></li>
                <li><a href="{{url ('perencanaan/iku-renstra')}}"> IKU OPD</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#"> Perjanjian Kinerja
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"> PK Kabupaten</a></li>
               <li class="treeview">
                  <a href="#"> PK OPD 
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="{{route('perjanjian-kinerja.index')}}"> PK Eselon II</a></li>
                  </ul>
                </li>
              </ul>
            </li>

            <li class="treeview">
              <a href="#"> Cascading
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{url ('perencanaan/upload-cascading-rpjmd')}}"> Cascading RPJMD</a></li>
              </ul>
            </li>
            

          </ul>
        </li>
        <li class="treeview">
        <a href="{{ url('capaian') }}" style="color: #eaeaea;">
            <i class="lnr lnr-chart-bars">&nbsp; </i> <span>Pengukuran</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ url('capaian') }}">Capaian</a></li>
            
          </ul>
        </li>
        <li class="treeview">
          <a href="#" style="color: #eaeaea;">
            <i class="lnr lnr-checkmark-circle">&nbsp; </i> <span>Pelaporan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('lkjip.index') }}">LKjIP</a></li>
          </ul>
        </li>
      </ul>
      @endif

    </section>
  </aside>

 --}}

 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('home') }}">
      <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
      </div>
      <div class="sidebar-brand-text mx-3">E-SAKIP</div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item">
      <a class="nav-link" href="{{ url('home') }}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
  </li>

  @if(Auth::user()->level == 1)
  <!-- Master -->
  <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
          aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
          <span>Master</span>
      </a>
      <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
              <a class="collapse-item" href="/admin/master/user">User</a>
              <a class="collapse-item" href="/admin/master/organisasi">Organisasi</a>
              <a class="collapse-item" href="/admin/master/program">Program</a>
              <a class="collapse-item" href="/admin/master/kegiatan">Kegiatan</a>
              <a class="collapse-item" href="/admin/master/satuan">Satuan</a>
          </div>
      </div>
  </li>

  <!-- Pegawai -->
  <li class="nav-item">
      <a class="nav-link" href="{{url('admin/pegawai')}}">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>Pegawai</span>
      </a>
  </li>

  <!-- SKP -->
  <li class="nav-item">
      <a class="nav-link" href="{{url('admin/skp')}}">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>SKP</span>
      </a>
  </li>

  <!-- IKI -->
  <li class="nav-item">
      <a class="nav-link" href="{{url('admin/iki')}}">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>IKI</span>
      </a>
  </li>

  <!-- IKU -->
  <li class="nav-item">
      <a class="nav-link" href="{{url('admin/iku')}}">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>IKU</span>
      </a>
  </li>

  <!-- PK -->
  <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pk"
          aria-expanded="true" aria-controls="pk">
          <i class="fas fa-fw fa-cog"></i>
          <span>Perjanian Kinerja</span>
      </a>
      <div id="pk" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
              <a class="collapse-item" href="{{ url('admin/perjanjian-kinerja/eselon-2') }}">Eselon II</a>
              <a class="collapse-item" href="{{ url('admin/perjanjian-kinerja/eselon-3') }}">Eselon III</a>
              <a class="collapse-item" href="{{ url('admin/perjanjian-kinerja/eselon-4') }}">Eselon IV</a>
          </div>
      </div>
  </li>

  <!-- IKU -->
  <li class="nav-item">
      <a class="nav-link" href="{{url('admin/skm')}}">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>SKM</span>
      </a>
  </li>

  <!-- Monitoring -->
  <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#monitoring"
          aria-expanded="true" aria-controls="monitoring">
          <i class="fas fa-fw fa-cog"></i>
          <span>Monitoring</span>
      </a>
      <div id="monitoring" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
              <a class="collapse-item" href="{{ url('admin/monitoring/skp') }}">SKP</a>
          </div>
      </div>
  </li>

  <!-- Integrasi -->
  <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#sistem"
          aria-expanded="true" aria-controls="sistem">
          <i class="fas fa-fw fa-cog"></i>
          <span>Sistem</span>
      </a>
      <div id="sistem" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
              <a class="collapse-item" href="{{ url('admin/sistem/integrasi') }}">Integrasi</a>
          </div>
      </div>
  </li>

  @endif



  @if(Auth::user()->level == 2)

  <!-- perencanaan -->
  <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#renstra"
          aria-expanded="true" aria-controls="renstra">
          <i class="fas fa-fw fa-cog"></i>
          <span>Renstra</span>
      </a>
      <div id="renstra" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
              <a class="collapse-item" href="{{ url('user/perencanaan/renstra/tujuan-renstra') }}">Tujuan</a>
              <a class="collapse-item" href="{{ url('user/perencanaan/renstra/sasaran-renstra') }}">Sasaran</a>
              <a class="collapse-item" href="{{ url('user/perencanaan/renstra/program-kegiatan-renstra') }}">Program & Kegiatan</a>
          </div>
      </div>
  </li>


  <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#perencanaan"
          aria-expanded="true" aria-controls="perencanaan">
          <i class="fas fa-fw fa-cog"></i>
          <span>Perencanaan</span>
      </a>
      <div id="perencanaan" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
              <a class="collapse-item" href="{{ url('user/rkt') }}">RKT</a>
              <a class="collapse-item" href="{{ url('user/pegawai') }}">Pegawai</a>
              <a class="collapse-item" href="{{ url('user/skp') }}">SKP</a>
              <a class="collapse-item" href="{{ url('user/iki') }}">IKI</a>
              <a class="collapse-item" href="{{ url('user/iku') }}">IKU</a>
          </div>
      </div>
  </li>




  <!-- RKT -->
  <!-- <li class="nav-item">
      <a class="nav-link" href="{{url('user/rkt')}}">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>RKT</span>
      </a>
  </li> -->

  <!-- Pegawai -->
  <!-- <li class="nav-item">
      <a class="nav-link" href="{{url('user/pegawai')}}">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>Pegawai</span>
      </a>
  </li> -->

  <!-- SKP -->
  <!-- <li class="nav-item">
      <a class="nav-link" href="{{url('user/skp')}}">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>SKP</span>
      </a>
  </li> -->

  <!-- IKI -->
  <!-- <li class="nav-item">
      <a class="nav-link" href="{{url('user/iki')}}">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>IKI</span>
      </a>
  </li> -->


  <!-- IKU -->
  <!-- <li class="nav-item">
      <a class="nav-link" href="{{url('user/iku')}}">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>IKU</span>
      </a>
  </li> -->

  <!-- PK -->
  <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pk"
          aria-expanded="true" aria-controls="pk">
          <i class="fas fa-fw fa-cog"></i>
          <span>Perjanian Kinerja</span>
      </a>
      <div id="pk" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
              <a class="collapse-item" href="{{ url('user/perjanjian-kinerja/eselon-2') }}">Eselon II</a>
              <a class="collapse-item" href="{{ url('user/perjanjian-kinerja/eselon-3') }}">Eselon III</a>
              <a class="collapse-item" href="{{ url('user/perjanjian-kinerja/eselon-4') }}">Eselon IV</a>
          </div>
      </div>
  </li>



  <!-- IKU -->
  <li class="nav-item">
      <a class="nav-link" href="{{url('user/pengukuran-kinerja')}}">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>Pengukuran Kinerja</span>
      </a>
  </li>
  
  <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#laporan"
          aria-expanded="true" aria-controls="laporan">
          <i class="fas fa-fw fa-cog"></i>
          <span>Laporan Kinerja</span>
      </a>
      <div id="laporan" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
              <a class="collapse-item" href="{{ url('user/lkjip') }}">LKJIP</a>
              <a class="collapse-item" href="{{ url('user/lhe') }}">LHE</a>
          </div>
      </div>
  </li>

  <!-- LKJIP -->
  <!-- <li class="nav-item">
      <a class="nav-link" href="{{url('user/lkjip')}}">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>LKJIP</span>
      </a>
  </li> -->

  <!-- LHE -->
  <!-- <li class="nav-item">
      <a class="nav-link" href="{{url('user/lhe')}}">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>LHE</span>
      </a>
  </li> -->

  <!-- cascading -->
  <li class="nav-item">
      <a class="nav-link" href="{{url('user/cascading')}}">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>Cascading</span>
      </a>
  </li>

  <!-- Cetak -->
  <li class="nav-item">
      <a class="nav-link" href="{{url('user/cetak')}}">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>Cetak</span>
      </a>
  </li>

  @endif


  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

 

</ul>
<!-- End of Sidebar -->