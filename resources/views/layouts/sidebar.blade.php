<div class="sidebar" data-color="orange">
    <!--
        Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
        Tip 2: you can also add an image using data-image tag
    -->
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="" class="simple-text">
                Naive Bayes
            </a>
        </div>

        <ul class="nav">
            <li class="active">
                <a href="{{ URL('/') }}">
                    <i class="pe-7s-graph"></i>
                    <p>Beranda</p>
                </a>
            </li>
            <li>
                <a href="{{ URL('tweet') }}">
                    <i class="pe-7s-server"></i>
                    <p>Daftar Tweet</p>
                </a>
            </li>
            <li>
                <a href="{{ URL('tweet/preprocessing') }}">
                    <i class="pe-7s-news-paper"></i>
                    <small>Daftar Preprocessing</small>
                </a>
            </li>
            <li>
                <a href="{{ URL('tweet/unduh') }}">
                    <i class="pe-7s-download"></i>
                    <p>Unduh tweet</p>
                </a>
            </li>
            <li>
                <a href="{{ URL('preprocessing') }}">
                    <i class="pe-7s-pen"></i>
                    <p>Preprocessing</p>
                </a>
            </li>
           <li>
                <a href="{{ URL('klasifikasi') }}">
                    <i class="pe-7s-graph3"></i>
                    <p>Analisis</p>
                </a>
            </li>
            <li>
                <a href="{{ URL('training') }}">
                    <i class="pe-7s-note2"></i>
                    <p>Tweet Training</p>
                </a>
            </li>
            <li>
                <a href="{{ URL('training/add') }}">
                    <i class="pe-7s-eyedropper"></i>
                    <small>Tambah tweet training</small>
                </a>
            </li>
            <!--<li>
                <a href="table.html">
                    <i class="pe-7s-note2"></i>
                    <p>Table List</p>
                </a>
            </li>
            <li class="active-pro">
                <a href="upgrade.html">
                    <i class="pe-7s-rocket"></i>
                    <p>Upgrade to PRO</p>
                </a>
            </li> -->
        </ul>
    </div>
</div>