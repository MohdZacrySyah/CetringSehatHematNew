@extends('layouts.app')
@section('title', 'Beranda - Catering Sehat Hemat')

@push('styles')
<style>
    .main-header {
        background: #879b55;
        border-radius: 9px;
        display: flex;
        align-items: center;
        padding: 15px 22px;
        margin: 25px 3vw 21px 3vw;
        position: relative;
        box-shadow: 0 2px 8px #c2d5a032;
        min-width: 0;
    }
    .hamburger-menu {
        font-size: 1.6rem;
        color: #fff;
        cursor: pointer;
        margin-right: 18px;
        padding: 5px;
        background: none;
        border: none;
        line-height: 1;
        display: flex;
        align-items: center;
    }
    .main-search-container {
        flex: 1;
        position: relative;
        max-width: 470px;
        min-width: 0;
        margin: 0 auto;
    }
    .search-input {
        width: 100%;
        padding: 12px 40px 12px 15px;
        border: none;
        border-radius: 20px;
        background: rgba(255,255,255,0.88);
        font-size: 1rem;
        outline: none;
        color: #556b2f;
    }
    .search-icon {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #888;
        font-size: 1.1rem;
        pointer-events: none;
    }
    #suggestionsBox {
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.11);
        max-height: 300px;
        overflow-y: auto;
        width: 95vw;
        max-width: 490px;
        margin: 9px auto 0;
        display: none;
        z-index: 200;
        position: relative;
    }
    .suggestion-item {
        padding: 13px 19px;
        cursor: pointer;
        border-bottom: 1px solid #e3e6d8;
        color: #4A572A;
        display: flex;
        align-items: center;
        transition: background 0.2s;
    }
    .suggestion-item:hover { background: #f7fbe7; }
    .suggestion-item:last-child {border-bottom: none;}
    .suggestion-item i { margin-right: 12px; color: #879b55; font-size: 1.13rem;}

    #searchResultWrapper {
        display: flex; flex-direction: column; align-items: center; min-height: 300px; display: none;
    }
    #searchResultWrapper.show {display: flex;}
    .search-result-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.11);
        width: 92vw;
        max-width: 330px;
        text-align: center;
    }
    .search-result-card img {
        width: 100%; height: 185px; border-radius: 12px; object-fit: cover; margin-bottom: 14px; border: 4px solid #f8f8f8;
    }
    .search-result-card h4 { margin: 0 0 7px 0; font-size: 1.13rem; color: #4A572A; }
    .search-result-card p { margin: 0 0 15px 0; color: #879b55; font-weight: bold; font-size: 1.1rem;}
    .search-result-card button {
        background: #879b55; border: none; color: #fff;
        font-weight: bold; border-radius: 10px;
        padding: 10px 26px; font-size: .99rem;
        cursor: pointer; width: 100%;
    }
    .search-result-card button:hover { background: #556b2f; }

    .menu-list-area {
        display: flex; flex-direction: column;
        gap: 18px; max-width: 680px; margin: 0 auto; padding: 0 2vw 22px 2vw;
        width: 100%;
        min-width: 0;
    }
    .menu-card {
        background: #e0e9cf;
        display: flex; align-items: center;
        border-radius: 12px; box-shadow: 0 2px 8px #879b5520;
        padding: 12px 16px; transition: background 0.2s;
        min-width: 0;
        gap: 14px;
        /* Tambahkan relative agar link bisa diatur */
        position: relative;
    }
    .menu-card:hover { background: #c2d5a0; }
    
    /* Link Wrapper untuk area klik */
    .menu-link-wrapper {
        display: flex;
        align-items: center;
        gap: 14px;
        flex: 1;
        text-decoration: none;
        color: inherit;
        min-width: 0; /* Fix flex overflow */
    }

    .menu-thumb { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; }
    .menu-info { flex: 1; min-width: 0;}
    .menu-title { font-size: 1.1rem; color: #3d4621; font-weight: 650; margin-bottom: 4px; white-space:nowrap; overflow: hidden; text-overflow: ellipsis;}
    .menu-price { font-size: .99rem; color: #556B2F; }
    
    .menu-action button {
        background: #879b55; border: none; color: #fff;
        font-weight: bold; border-radius: 10px;
        padding: 9px 18px; font-size: 0.98rem;
        cursor: pointer; transition: background 0.2s;
        min-width: 75px;
        /* Pastikan tombol di atas link */
        z-index: 2; 
        position: relative;
    }
    .menu-action button:hover { background: #556b2f; }

    .toast-show {
        position: fixed;
        top: 25px;
        left: 50%;
        transform: translateX(-50%);
        background: #4A572A;
        color: #fff;
        padding: 14px 35px;
        border-radius: 12px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.09);
        font-size: 1.09rem;
        z-index: 9999;
        animation: fadeToast 0.5s, hideToast 3s 1s forwards;
    }
    @keyframes fadeToast { from { opacity: 0; } to { opacity: 1; } }
    @keyframes hideToast { to { opacity: 0; top: 0px; } }

    /* GRID PAKET HEMAT */
    #paketHematWrapper {
        padding-top: 10px;
    }
    #paketHematWrapper h3{
        text-align:center;
        margin:15px 0 25px 0;
        color:#3d4621;
        font-weight:700;
    }

    .paket-grid {
        display: grid;
        grid-template-columns: repeat(3, 130px);
        gap: 18px 20px;
        justify-content: center;
        padding-bottom: 40px;
    }
    .paket-card{
        background:#e0e9cf;
        border-radius:15px;
        box-shadow:0 2px 8px #879b5520;
        overflow:hidden;
        width:130px;
        display: flex;
        flex-direction: column;
    }
    /* Link wrapper untuk paket */
    .paket-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }
    .paket-card img{
        width:100%;
        height:90px;
        object-fit:cover;
    }
    .paket-info{
        padding:6px 8px 10px 8px;
        text-align:left;
    }
    .paket-info h6{
        font-size:.74rem;
        font-weight:600;
        color:#3d4621;
        margin:0 0 4px 0;
    }
    .paket-info p{
        color:#556B2F;
        font-weight:600;
        font-size:.75rem;
        margin:0 0 6px 0;
    }
    .paket-info button{
        width:100%;
        border:none;
        border-radius:8px;
        background:#879b55;
        color:#fff;
        font-size:.75rem;
        font-weight:600;
        padding:5px 0;
        cursor:pointer;
    }
    .paket-info button:hover{
        background:#556b2f;
    }

    @media (max-width:990px){
        .main-header, .menu-list-area {max-width: 97vw;}
    }
    @media (max-width:660px){
        .main-header {margin-left:4px; margin-right:4px; padding: 10px 7px;}
        .main-search-container {max-width: 98vw;}
        .menu-list-area {padding-left: 1.5vw; padding-right: 1.5vw;}
        .menu-card {gap: 8px;}
    }
    @media (max-width:600px){
        .paket-grid{
            grid-template-columns: repeat(2,130px);
        }
    }
    @media (max-width:500px){
        .main-header {padding: 7px 4px;}
        .menu-thumb {width: 46px; height: 46px;}
        .menu-card {padding: 8px 6px;}
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
    <button class="hamburger-menu" onclick="openSidebar()" type="button">
        <i class="fa-solid fa-bars"></i>
    </button>
    <div class="main-search-container">
        <input type="text" class="search-input" placeholder="Pilih Menu Makanan" id="searchInput"
               onfocus="showSearchSuggestions()" oninput="liveSearch()">
        <span class="search-icon">
            <i class="fa-solid fa-magnifying-glass"></i>
        </span>
    </div>
</div>

<div id="suggestionsBox"></div>

<div id="searchResultWrapper">
    <div id="singleResultArea"></div>
</div>

{{-- GRID PAKET HEMAT SEHAT --}}
<div id="paketHematWrapper" style="display:none;">
    <h3>Paket Makanan Sehat Mu!</h3>
    <div class="paket-grid">
        @foreach(($paketHemat ?? collect()) as $menu)
            <div class="paket-card">
                {{-- WRAPPER LINK KE DETAIL MENU --}}
                <a href="{{ route('menu.detail', $menu->id) }}" class="paket-link">
                    <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}">
                </a>
                
                <div class="paket-info">
                    <a href="{{ route('menu.detail', $menu->id) }}" class="paket-link">
                        <h6>{{ $menu->name }}</h6>
                    </a>
                    <p>Rp. {{ number_format($menu->price, 0, ',', '.') }}</p>
                    
                    {{-- Form Tambah ke Keranjang (Tanpa Link) --}}
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $menu->id }}">
                        <input type="hidden" name="name" value="{{ $menu->name }}">
                        <input type="hidden" name="price" value="{{ $menu->price }}">
                        <input type="hidden" name="image" value="{{ asset('storage/' . $menu->image) }}">
                        <button type="submit">Tambah</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>

{{-- LIST MENU NORMAL --}}
<div class="menu-list-area" id="menuListNormal">
    @foreach($menus as $menu)
    <div class="menu-card"
         data-id="{{ $menu->id }}"
         data-name="{{ $menu->name }}"
         data-price="{{ $menu->price }}"
         data-image="{{ asset('storage/' . $menu->image) }}">
         
        {{-- WRAPPER LINK KE DETAIL MENU (Membungkus Gambar & Info) --}}
        <a href="{{ route('menu.detail', $menu->id) }}" class="menu-link-wrapper">
            <img class="menu-thumb" src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}">
            <div class="menu-info">
                <div class="menu-title">{{ $menu->name }}</div>
                <div class="menu-price">RP. {{ number_format($menu->price, 0, ',', '.') }}</div>
            </div>
        </a>

        {{-- Tombol Aksi (Di luar Link) --}}
        <div class="menu-action">
            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $menu->id }}">
                <input type="hidden" name="name" value="{{ $menu->name }}">
                <input type="hidden" name="price" value="{{ $menu->price }}">
                <input type="hidden" name="image" value="{{ asset('storage/' . $menu->image) }}">
                <button type="submit">Tambah</button>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endsection

@push('scripts')
<script>
    let PRODUCTS = [];

    document.addEventListener('DOMContentLoaded', function() {
        const menuItems = document.querySelectorAll('.menu-card');
        PRODUCTS = Array.from(menuItems).map(item => ({
            id: item.dataset.id,
            name: item.dataset.name,
            price: item.dataset.price,
            image: item.dataset.image,
        }));

        const toast = document.getElementById('toast-notification');
        if (toast) {
            setTimeout(function(){ toast.classList.remove('toast-show'); }, 3000);
            setTimeout(function(){ toast.style.display = 'none'; }, 3500);
        }
    });

    function showSearchSuggestions() {
        const suggestionsBox = document.getElementById('suggestionsBox');
        const searchInput = document.getElementById('searchInput');
        const menuListNormal = document.getElementById('menuListNormal');
        const searchResultWrapper = document.getElementById('searchResultWrapper');
        const paketHematWrapper = document.getElementById('paketHematWrapper');

        menuListNormal.style.display = 'none';
        searchResultWrapper.classList.remove('show');
        paketHematWrapper.style.display = 'none';

        if (searchInput.value.length === 0 && PRODUCTS.length > 0) {
            suggestionsBox.style.display = 'block';
            suggestionsBox.innerHTML = '';

            // semua menu biasa
            PRODUCTS.forEach(product => {
                const suggestion = document.createElement('div');
                suggestion.className = 'suggestion-item';
                suggestion.innerHTML = `<i class="fa-regular fa-circle"></i> ${product.name}`;
                suggestion.onclick = () => selectResult(product);
                suggestionsBox.appendChild(suggestion);
            });

            // item paling bawah: Paket Hemat Sehat
            const paketItem = document.createElement('div');
            paketItem.className = 'suggestion-item';
            paketItem.innerHTML = `<i class="fa-regular fa-circle"></i> Paket Hemat Sehat`;
            paketItem.onclick = () => showPaketHemat();
            suggestionsBox.appendChild(paketItem);
        }
    }

    function liveSearch() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toUpperCase();
        const suggestionsBox = document.getElementById('suggestionsBox');
        const menuListNormal = document.getElementById('menuListNormal');
        const searchResultWrapper = document.getElementById('searchResultWrapper');
        const paketHematWrapper = document.getElementById('paketHematWrapper');

        if (filter.length === 0) {
            showSearchSuggestions();
            return;
        }

        menuListNormal.style.display = 'none';
        searchResultWrapper.classList.remove('show');
        paketHematWrapper.style.display = 'none';

        const matches = PRODUCTS.filter(product =>
            product.name.toUpperCase().includes(filter)
        );

        suggestionsBox.style.display = 'block';
        suggestionsBox.innerHTML = '';

        if (matches.length > 0) {
            matches.forEach(product => {
                const suggestion = document.createElement('div');
                suggestion.className = 'suggestion-item';
                suggestion.innerHTML = `<i class="fa-regular fa-circle"></i> ${product.name}`;
                suggestion.onclick = () => selectResult(product);
                suggestionsBox.appendChild(suggestion);
            });
        }

        const keyword = filter.trim();
        if (keyword.includes('PAKET') || keyword.includes('HEMAT')) {
            const paketItem = document.createElement('div');
            paketItem.className = 'suggestion-item';
            paketItem.innerHTML = `<i class="fa-regular fa-circle"></i> Paket Hemat Sehat`;
            paketItem.onclick = () => showPaketHemat();
            suggestionsBox.appendChild(paketItem);
        }

        if (matches.length === 0 && !(keyword.includes('PAKET') || keyword.includes('HEMAT'))) {
            suggestionsBox.innerHTML = `
                <div class="suggestion-item" style="justify-content:center;color:#ab3d36;">
                    <i class="fa-solid fa-circle-exclamation" style="margin-right:8px;"></i> Menu tidak tersedia
                </div>
            `;
        }
    }

    function showPaketHemat() {
        const suggestionsBox = document.getElementById('suggestionsBox');
        const menuListNormal = document.getElementById('menuListNormal');
        const searchResultWrapper = document.getElementById('searchResultWrapper');
        const paketHematWrapper = document.getElementById('paketHematWrapper');
        const searchInput = document.getElementById('searchInput');

        searchInput.value = 'Paket Hemat Sehat';
        suggestionsBox.style.display = 'none';
        menuListNormal.style.display = 'none';
        searchResultWrapper.classList.remove('show');
        paketHematWrapper.style.display = 'block';
    }

    function selectResult(product) {
        const suggestionsBox = document.getElementById('suggestionsBox');
        const singleResultArea = document.getElementById('singleResultArea');
        const searchInput = document.getElementById('searchInput');
        const menuListNormal = document.getElementById('menuListNormal');
        const searchResultWrapper = document.getElementById('searchResultWrapper');
        const paketHematWrapper = document.getElementById('paketHematWrapper');

        suggestionsBox.style.display = 'none';
        menuListNormal.style.display = 'none';
        paketHematWrapper.style.display = 'none';
        searchInput.value = product.name;
        searchResultWrapper.classList.add('show');

        // UPDATE JS: Tambahkan Link pada Gambar Hasil Pencarian
        singleResultArea.innerHTML = `
            <div class="search-result-card">
                <a href="/menu/${product.id}">
                    <img src="${product.image}" alt="${product.name}">
                </a>
                <h4>${product.name}</h4>
                <p>RP. ${parseInt(product.price).toLocaleString('id-ID')}</p>
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="${product.id}">
                    <input type="hidden" name="name" value="${product.name}">
                    <input type="hidden" name="price" value="${product.price}">
                    <input type="hidden" name="image" value="${product.image}">
                    <button type="submit">Tambah</button>
                </form>
            </div>
        `;
    }

    document.addEventListener('click', function(e) {
        const searchInput = document.getElementById('searchInput');
        const suggestionsBox = document.getElementById('suggestionsBox');
        const searchContainer = document.querySelector('.main-search-container');
        const menuListNormal = document.getElementById('menuListNormal');
        const searchResultWrapper = document.getElementById('searchResultWrapper');
        const paketHematWrapper = document.getElementById('paketHematWrapper');

        if (!searchContainer.contains(e.target) && !suggestionsBox.contains(e.target)) {
            if (searchInput.value.length === 0) {
                suggestionsBox.style.display = 'none';
                menuListNormal.style.display = 'flex';
                searchResultWrapper.classList.remove('show');
                paketHematWrapper.style.display = 'none';
            }
        }
    });
</script>
@endpush