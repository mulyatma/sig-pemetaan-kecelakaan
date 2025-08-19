<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand" style="padding-top: 16px; ">
            <a href="{{ route('admin.dashboard') }}"
                style="font-size:12px; line-height:1.2; display:block; text-align:center; padding-bottom: 10px;">
                SIG Laka Lantas<br>Kab. Brebes
            </a>
            <hr style="margin:4px 0; border-top:1px solid #ccc;">
        </div>

        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.dashboard') }}">Sig</a>
        </div>
        <ul class="sidebar-menu">

            <li class="nav-item dropdown ">
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-link "><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>

            <li class="nav-item dropdown ">
                <a href="{{ route('admin.kecelakaan.index') }}"
                    class="nav-link "><i class="fas fa-fire"></i><span>Data Kecelakaan</span></a>
            </li>

            <li class="nav-item dropdown ">
                <a href="{{ route('admin.rekap.index') }}"
                    class="nav-link "><i class="fas fa-fire"></i><span>Rekap Data Kecelakaan</span></a>
            </li>

            <li class="nav-item dropdown ">
                <a href="{{ route('admin.clustering.index') }}"
                    class="nav-link "><i class="fas fa-fire"></i><span>Clustering</span></a>
            </li>

            <li class="nav-item dropdown ">
                <a href="{{ route('admin.clustering.map') }}"
                    class="nav-link "><i class="fas fa-fire"></i><span>Peta Clustering</span></a>
            </li>
    </aside>
</div>