<div class="sidebar-wrapper">
    <div class="d-flex flex-column sidebar-heading align-items-center">
        <img src="{{ url('storage/FunventureLogo.png') }}" class="rounded-circle me-2" alt="Logo" width="40" height="40">
        <h4 class="text-white mt-2">FunventureOutdor</h4>
        <span class="badge bg-secondary-custom text-white" style="background-color: #70B2B2 !important;">Admin</span>
    </div>

    <div class="list-group list-group-flush mt-3">
        <a href="{{route('admin_index')}}" class="list-group-item @if(Route::is('admin_index')) active @endif">
            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
        </a>

        <a href="{{route('slider_index')}}" class="list-group-item @if(Route::is('slider_*')) active @endif">
            <i class="fas fa-images me-2"></i> Slider
        </a>

        <a href="{{route('categories_index')}}" class="list-group-item @if(Route::is('categories_*')) active @endif">
            <i class="fas fa-list me-2"></i> Kategori
        </a>

        <a href="{{route('products_index')}}" class="list-group-item @if(Route::is('products_*')) active @endif">
            <i class="fas fa-box me-2"></i> Produk
        </a>

        <a href="{{route('admin_transation_index')}}" class="list-group-item @if(Route::is('admin_transation_*')) active @endif">
            <i class="fas fa-exchange-alt me-2"></i> Transaksi
        </a>

        <a href="{{route('returns_index')}}" class="list-group-item @if(Route::is('returns_*')) active @endif">
            <i class="fas fa-history me-2"></i> Pengembalian
        </a>

        <a href="{{route('contents_index')}}" class="list-group-item @if(Route::is('contents_*')) active @endif">
            <i class="fas fa-file-alt me-2"></i> Konten
        </a>
    </div>
</div>