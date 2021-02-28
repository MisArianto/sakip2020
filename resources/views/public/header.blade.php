<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a href="/" class="navbar-brand"><img src="{{ asset('img/E-SAKIP_COLOR.png') }}" height="32px;"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link btn btn-outline-info" href="{{ url('galeri') }}"><i class="fa fa-image"></i> Galeri</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle btn btn-outline-info" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-book"></i> Dokumen
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ url('perencanaan-kinerja') }}">Perencanaan Kinerja</a>
            <a class="dropdown-item" href="{{ url('capaian-kinerja') }}">Pengukuran Kinerja</a>
              <a class="dropdown-item" href="{{ url('pelaporan-kinerja') }}">Pelaporan Kinerja</a>
              <a class="dropdown-item" href="{{ url('evaluasi-kinerja') }}">Evaluasi Kinerja</a>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link btn btn-outline-info" href="{{ url('survei-skm') }}"><i class="fa fa-book"></i> Survei SKM</a>
          </li>
          <li class="nav-item">
            <a class="nav-link btn btn-outline-info" href="{{ url('login') }}"><i class="fa fa-lock"></i> Login</a>
          </li>
        </ul>
      </div>
    </div>
</nav> 