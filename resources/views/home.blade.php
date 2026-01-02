@extends('layouts.app')

@section('title', 'Beranda - Catering Sehat Hemat')

@push('styles')
<style>
    /* === GLOBAL & LAYOUT === */
    .main-header {
        background: #556B2F; /* Hijau Utama */
        padding: 20px;
        position: relative;
        z-index: 50;
        box-shadow: 0 4px 15px rgba(85, 107, 47, 0.1);
    }
    
    .header-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .hamburger-menu {
        color: white;
        font-size: 1.5rem;
        background: none;
        border: none;
        cursor: pointer;
    }

    /* === SEARCH BAR === */
    .main-search-container {
        position: relative;
        max-width: 100%;
    }

    .search-input {
        width: 100%;
        padding: 14px 48px 14px 20px;
        border: none;
        border-radius: 16px;
        background: white;
        font-size: 1rem;
        color: #333;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        outline: none;
    }

    .search-icon {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #888;
        font-size: 1.2rem;
        pointer-events: none;
    }

    /* === HERO SECTION (BANNER) === */
    .hero-section {
        background: linear-gradient(180deg, #556B2F 0%, #768d46 100%);
        padding: 10px 20px 40px 20px;
        border-radius: 0 0 30px 30px;
        margin-bottom: 30px;
        color: white;
        position: relative;
        overflow: hidden;
    }
    
    /* Dekorasi Background */
    .hero-circle-1 {
        position: absolute;
        top: -20px;
        right: -20px;
        width: 150px;
        height: 150px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }
    .hero-circle-2 {
        position: absolute;
        bottom: 20px;
        left: -30px;
        width: 100px;
        height: 100px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    .hero-title {
        font-size: 1.5rem;
        font-weight: 800;
        margin-bottom: 8px;
        line-height: 1.3;
        position: relative;
        z-index: 10;
    }
    .hero-subtitle {
        font-size: 0.9rem;
        opacity: 0.9;
        position: relative;
        z-index: 10;
        max-width: 80%;
    }

    /* === HORIZONTAL SCROLL (PILIHAN SEHAT) === */
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 20px;
        margin-bottom: 16px;
    }
    .section-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1f2937;
    }
    .see-all {
        font-size: 0.85rem;
        color: #556B2F;
        text-decoration: none;
        font-weight: 600;
    }

    .horizontal-scroll-wrapper {
        display: flex;
        overflow-x: auto;
        padding: 0 20px 20px 20px;
        gap: 16px;
        -webkit-overflow-scrolling: touch;
        scroll-snap-type: x mandatory;
    }
    /* Hide scrollbar */
    .horizontal-scroll-wrapper::-webkit-scrollbar { display: none; }
    
    .card-sehat {
        min-width: 160px;
        width: 160px;
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        scroll-snap-align: center;
        border: 1px solid #f0f0f0;
        display: flex;
        flex-direction: column;
    }
    
    .card-sehat img {
        width: 100%;
        height: 110px;
        object-fit: cover;
    }
    
    .card-sehat-content {
        padding: 12px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .card-sehat h4 {
        font-size: 0.9rem;
        font-weight: 700;
        color: #333;
        margin: 0 0 4px 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .card-sehat p {
        font-size: 0.85rem;
        color: #556B2F;
        font-weight: 600;
        margin: 0 0 10px 0;
    }
    
    .btn-add-mini {
        margin-top: auto;
        width: 100%;
        background: #556B2F;
        color: white;
        border: none;
        padding: 8px;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: background 0.2s;
    }
    .btn-add-mini:hover { background: #435725; }

    /* === GRID MENU (REKOMENDASI) === */
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        padding: 0 20px 40px 20px;
    }
    
    .card-menu {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        border: 1px solid #f0f0f0;
        transition: transform 0.2s;
        position: relative; /* Untuk badge kategori */
    }
    .card-menu:hover { transform: translateY(-3px); }
    
    .card-menu img {
        width: 100%;
        height: 130px;
        object-fit: cover;
    }
    
    .card-menu-content {
        padding: 12px;
    }
    
    .card-menu h3 {
        font-size: 0.95rem;
        font-weight: 700;
        color: #333;
        margin: 0 0 4px 0;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .card-menu .desc {
        font-size: 0.75rem;
        color: #888;
        margin-bottom: 12px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 2.4em; /* Fixed height for alignment */
    }
    
    .card-menu-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .price-tag {
        font-size: 0.9rem;
        font-weight: 700;
        color: #556B2F;
    }
    
    .btn-add-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #f0fdf4;
        color: #556B2F;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background 0.2s;
    }
    .btn-add-circle:hover {
        background: #556B2F;
        color: white;
    }

    /* Badge Kategori di Grid (Opsional, agar user tau kategorinya) */
    .category-badge-small {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(255, 255, 255, 0.9);
        padding: 4px 8px;
        border-radius: 8px;
        font-size: 0.7rem;
        font-weight: 600;
        color: #556B2F;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    /* === SEARCH SUGGESTIONS === */
    #suggestionsBox {
        position: absolute;
        top: 130px; /* Adjust based on header+hero height approx */
        left: 20px;
        right: 20px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        z-index: 100;
        display: none;
        max-height: 300px;
        overflow-y: auto;
    }
    .suggestion-item {
        padding: 12px 16px;
        border-bottom: 1px solid #f0f0f0;
        color: #333;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .suggestion-item:last-child { border-bottom: none; }
    .suggestion-item:hover { background: #f9fafb; }
    
    .suggestion-cat {
        font-size: 0.75rem;
        color: #888;
        margin-left: auto;
        background: #f3f4f6;
        padding: 2px 6px;
        border-radius: 4px;
    }

    /* === SEARCH RESULT CARD === */
    #searchResultWrapper {
        display: none;
        padding: 20px;
        justify-content: center;
        flex-direction: column;
        align-items: center;
        gap: 20px;
    }
    #searchResultWrapper.show { display: flex; }
    
    .result-card {
        background: white;
        border-radius: 20px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        width: 100%;
        max-width: 300px;
    }
    .result-card img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-radius: 12px;
        margin-bottom: 16px;
    }
    .result-card h4 {
        font-size: 1.2rem;
        color: #333;
        margin-bottom: 8px;
    }
    .result-card p {
        font-size: 1.1rem;
        color: #556B2F;
        font-weight: 700;
        margin-bottom: 20px;
    }
    .result-card button {
        width: 100%;
        padding: 12px;
        background: #556B2F;
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
    }

    /* === TOAST === */
    .toast-show {
        position: fixed;
        top: 25px;
        left: 50%;
        transform: translateX(-50%);
        background: #333;
        color: #fff;
        padding: 12px 24px;
        border-radius: 50px;
        font-size: 0.9rem;
        z-index: 9999;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        animation: fadeToast 0.5s, hideToast 0.5s 3s forwards;
    }
    @keyframes fadeToast { from { opacity: 0; transform: translate(-50%, -20px); } to { opacity: 1; transform: translate(-50%, 0); } }
    @keyframes hideToast { to { opacity: 0; transform: translate(-50%, -20px); } }

    /* Responsive */
    @media (min-width: 768px) {
        .menu-grid { grid-template-columns: repeat(3, 1fr); }
    }
    @media (min-width: 1024px) {
        .menu-grid { grid-template-columns: repeat(4, 1fr); }
    }
</style>
@endpush

@section('content')

@if(session('success'))
<div id="toast-notification" class="toast-show">
    {{ session('success') }}
</div>
@endif

<div class="main-header">
    <div class="header-top">
        <button class="hamburger-menu" onclick="openSidebar()" type="button">
            <i class="fa-solid fa-bars"></i>
        </button>
        <div style="color: white; font-weight: bold; font-size: 1.1rem;">Catering Sehat</div>
        <div style="width: 24px;"></div> </div>

    <div class="main-search-container">
        <input type="text" class="search-input" placeholder="Cari menu, snack, atau sehat..." id="searchInput"
               onfocus="showSearchSuggestions()" oninput="liveSearch()">
        <i class="fa-solid fa-magnifying-glass search-icon"></i>
    </div>
</div>

<div id="suggestionsBox"></div>

<div class="hero-section">
    <div class="hero-circle-1"></div>
    <div class="hero-circle-2"></div>
    
    <div class="hero-title">
        Nikmati Makanan<br>Sehat & Hemat
    </div>
    <div class="hero-subtitle">
        Pesan katering harian tanpa ribet, langsung antar ke tempatmu.
    </div>
</div>

<div id="searchResultWrapper">
    </div>

<div id="defaultContent">
    
    @if(isset($makananSehat) && $makananSehat->count() > 0)
    <div class="section-header">
        <span class="section-title">Pilihan Sehat 🥗</span>
        <a href="{{ url('/menu') }}" class="see-all">Lihat Semua</a>
    </div>

    <div class="horizontal-scroll-wrapper">
        @foreach($makananSehat as $item)
        <div class="card-sehat">
            <a href="{{ route('menu.detail', $item->id) }}">
                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
            </a>
            <div class="card-sehat-content">
                <h4>{{ $item->name }}</h4>
                <p>Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $item->id }}">
                    <input type="hidden" name="name" value="{{ $item->name }}">
                    <input type="hidden" name="price" value="{{ $item->price }}">
                    <input type="hidden" name="image" value="{{ asset('storage/' . $item->image) }}">
                    <button type="submit" class="btn-add-mini">
                        <i class="fa-solid fa-plus"></i> Pesan
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <div class="section-header" style="margin-top: 30px;">
        <span class="section-title">Rekomendasi Lainnya 🔥</span>
    </div>

    <div class="menu-grid">
        @foreach($menus as $menu)
        <div class="card-menu"
             data-id="{{ $menu->id }}"
             data-name="{{ $menu->name }}"
             data-price="{{ $menu->price }}"
             data-image="{{ asset('storage/' . $menu->image) }}"
             data-category="{{ $menu->category }}"> <a href="{{ route('menu.detail', $menu->id) }}">
                <div class="category-badge-small">{{ ucfirst(str_replace('_', ' ', $menu->category)) }}</div>
                <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}">
            </a>
            
            <div class="card-menu-content">
                <a href="{{ route('menu.detail', $menu->id) }}" style="text-decoration:none;">
                    <h3>{{ $menu->name }}</h3>
                </a>
                <div class="desc">{{ $menu->description ?? 'Rasa otentik yang lezat.' }}</div>
                
                <div class="card-menu-footer">
                    <span class="price-tag">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                    
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $menu->id }}">
                        <input type="hidden" name="name" value="{{ $menu->name }}">
                        <input type="hidden" name="price" value="{{ $menu->price }}">
                        <input type="hidden" name="image" value="{{ asset('storage/' . $menu->image) }}">
                        <button type="submit" class="btn-add-circle">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>

@endsection

@push('scripts')
<script>
    let PRODUCTS = [];

    document.addEventListener('DOMContentLoaded', function() {
        // Ambil data produk termasuk KATEGORI dari DOM
        const menuItems = document.querySelectorAll('.card-menu');
        PRODUCTS = Array.from(menuItems).map(item => ({
            id: item.dataset.id,
            name: item.dataset.name,
            price: item.dataset.price,
            image: item.dataset.image,
            category: item.dataset.category || '' // Ambil kategori
        }));

        // Toast Notification Auto Hide
        const toast = document.getElementById('toast-notification');
        if (toast) {
            setTimeout(function(){ toast.style.display = 'none'; }, 3500);
        }
    });

    // === LOGIC SEARCH ===
    function showSearchSuggestions() {
        const input = document.getElementById('searchInput');
        const suggestionsBox = document.getElementById('suggestionsBox');
        
        // Jika input kosong, tampilkan semua produk sebagai saran
        if (input.value.trim() === '') {
            renderSuggestions(PRODUCTS);
            suggestionsBox.style.display = 'block';
        }
    }

    function liveSearch() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toUpperCase();
        const suggestionsBox = document.getElementById('suggestionsBox');
        const defaultContent = document.getElementById('defaultContent');
        const searchResultWrapper = document.getElementById('searchResultWrapper');
        const heroSection = document.querySelector('.hero-section');

        // Jika input kosong, kembalikan ke tampilan awal
        if (filter.length === 0) {
            suggestionsBox.style.display = 'block';
            renderSuggestions(PRODUCTS); 
            defaultContent.style.display = 'block';
            heroSection.style.display = 'block';
            searchResultWrapper.classList.remove('show');
            return;
        }

        // Sembunyikan konten default & hero saat mengetik
        defaultContent.style.display = 'none';
        heroSection.style.display = 'none';
        searchResultWrapper.classList.remove('show');

        // LOGIC PENCARIAN (NAMA ATAU KATEGORI)
        const matches = PRODUCTS.filter(product => 
            product.name.toUpperCase().includes(filter) || 
            product.category.toUpperCase().includes(filter)
        );

        if (matches.length > 0) {
            renderSuggestions(matches);
            suggestionsBox.style.display = 'block';
        } else {
            suggestionsBox.style.display = 'block';
            suggestionsBox.innerHTML = `<div class="suggestion-item" style="color:red; justify-content:center;">Menu tidak ditemukan</div>`;
        }
    }

    function renderSuggestions(items) {
        const box = document.getElementById('suggestionsBox');
        box.innerHTML = '';
        items.forEach(product => {
            const div = document.createElement('div');
            div.className = 'suggestion-item';
            // Tampilkan Nama Menu dan Kategorinya (Kecil di kanan)
            div.innerHTML = `
                <div style="display:flex; align-items:center; gap:8px; width:100%">
                    <i class="fa-solid fa-utensils text-gray-400"></i> 
                    <span>${product.name}</span>
                    <span class="suggestion-cat">${product.category.replace('_',' ')}</span>
                </div>
            `;
            div.onclick = () => selectResult(product);
            box.appendChild(div);
        });
    }

    function selectResult(product) {
        const suggestionsBox = document.getElementById('suggestionsBox');
        const searchResultWrapper = document.getElementById('searchResultWrapper');
        const searchInput = document.getElementById('searchInput');
        const heroSection = document.querySelector('.hero-section');

        // Isi input dengan nama yang dipilih
        searchInput.value = product.name;
        
        // Sembunyikan saran & konten default & hero
        suggestionsBox.style.display = 'none';
        document.getElementById('defaultContent').style.display = 'none';
        heroSection.style.display = 'none';

        // Tampilkan Kartu Hasil Pencarian
        searchResultWrapper.classList.add('show');
        searchResultWrapper.innerHTML = `
            <div class="result-card">
                <a href="/menu/${product.id}">
                    <img src="${product.image}" alt="${product.name}">
                </a>
                <h4>${product.name}</h4>
                <p>Rp ${parseInt(product.price).toLocaleString('id-ID')}</p>
                <div style="margin-bottom:15px;">
                    <span style="background:#f3f4f6; color:#666; padding:4px 10px; border-radius:10px; font-size:0.8rem;">
                        Kategori: ${product.category.replace('_',' ').toUpperCase()}
                    </span>
                </div>
                
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="${product.id}">
                    <input type="hidden" name="name" value="${product.name}">
                    <input type="hidden" name="price" value="${product.price}">
                    <input type="hidden" name="image" value="${product.image}">
                    <button type="submit">Tambah ke Keranjang</button>
                </form>
            </div>
        `;
    }

    // Tutup suggestions jika klik di luar
    document.addEventListener('click', function(e) {
        const container = document.querySelector('.main-header');
        const box = document.getElementById('suggestionsBox');
        const input = document.getElementById('searchInput');
        const heroSection = document.querySelector('.hero-section');
        
        if (!container.contains(e.target) && !box.contains(e.target)) {
            box.style.display = 'none';
            // Jika input kosong, kembalikan tampilan default
            if(input.value === '') {
                document.getElementById('defaultContent').style.display = 'block';
                heroSection.style.display = 'block';
                document.getElementById('searchResultWrapper').classList.remove('show');
            }
        }
    });
</script>
@endpush