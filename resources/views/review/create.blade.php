@extends('layouts.app')
@section('title', 'Tulis Ulasan')

@push('styles')
<style>
    /* === GLOBAL SETUP === */
    body {
        background-color: #f8fafc; /* Slate-50: Lebih bersih */
        font-family: 'Poppins', sans-serif;
        color: #334155; /* Slate-700 */
    }
    
    /* === HEADER === */
    .review-header {
        background: white;
        padding: 1rem 1.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #e2e8f0;
        position: sticky;
        top: 0;
        z-index: 50;
    }
    .header-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: #1e293b;
    }
    .icon-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        color: #64748b;
        transition: all 0.2s;
        text-decoration: none;
        border: none;
        background: transparent;
        cursor: pointer;
    }
    .icon-btn:hover {
        background-color: #f1f5f9;
        color: #0f172a;
    }
    .icon-btn.danger:hover {
        background-color: #fef2f2;
        color: #ef4444;
    }
    .icon-svg {
        width: 24px;
        height: 24px;
    }

    /* === CONTAINER === */
    .review-container {
        max-width: 560px;
        margin: 2rem auto;
        padding: 0 1rem 3rem 1rem;
    }
    
    .review-card {
        background: white;
        border-radius: 1.5rem;
        padding: 2rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    }

    /* === PRODUCT INFO === */
    .product-summary {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2rem;
        padding: 1rem;
        background-color: #f8fafc;
        border-radius: 1rem;
        border: 1px solid #e2e8f0;
    }
    .product-thumb {
        width: 64px;
        height: 64px;
        border-radius: 0.75rem;
        object-fit: cover;
        background-color: #e2e8f0;
    }
    .product-details h3 {
        font-size: 1rem;
        font-weight: 700;
        color: #334155;
        margin: 0 0 0.25rem 0;
        line-height: 1.25;
    }
    .product-details p {
        font-size: 0.875rem;
        color: #64748b;
        margin: 0;
    }

    /* === RATING STARS === */
    .rating-container {
        text-align: center;
        margin-bottom: 2.5rem;
    }
    .rating-label {
        display: block;
        font-size: 1rem;
        font-weight: 600;
        color: #475569;
        margin-bottom: 1rem;
    }
    .star-wrapper {
        display: inline-flex;
        gap: 0.5rem;
        flex-direction: row-reverse;
    }
    .star-wrapper input { display: none; }
    .star-wrapper label {
        cursor: pointer;
        color: #cbd5e1; /* Abu-abu */
        transition: color 0.2s, transform 0.1s;
    }
    .star-svg {
        width: 42px;
        height: 42px;
        fill: currentColor;
    }
    /* Hover & Checked State */
    .star-wrapper input:checked ~ label,
    .star-wrapper label:hover,
    .star-wrapper label:hover ~ label {
        color: #fbbf24; /* Amber-400 */
        transform: scale(1.1);
    }

    /* === FORMS === */
    .form-group { margin-bottom: 1.5rem; }
    .form-label {
        display: block;
        font-size: 0.925rem;
        font-weight: 600;
        color: #334155;
        margin-bottom: 0.5rem;
    }
    .input-control {
        width: 100%;
        padding: 0.875rem 1rem;
        background-color: white;
        border: 2px solid #e2e8f0;
        border-radius: 1rem;
        font-size: 0.95rem;
        color: #1e293b;
        transition: all 0.2s;
        outline: none;
    }
    .input-control:focus {
        border-color: #556B2F;
        box-shadow: 0 0 0 3px rgba(85, 107, 47, 0.1);
    }
    textarea.input-control {
        min-height: 140px;
        resize: none;
        line-height: 1.6;
    }

    /* === UPLOAD AREA === */
    .upload-area {
        position: relative;
        border: 2px dashed #cbd5e1;
        border-radius: 1rem;
        background-color: #f8fafc;
        min-height: 160px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        text-align: center;
        padding: 1.5rem;
    }
    .upload-area:hover {
        border-color: #556B2F;
        background-color: #fcfdf9; /* Hijau sangat muda */
    }
    .upload-icon {
        width: 48px;
        height: 48px;
        color: #94a3b8;
        margin-bottom: 0.75rem;
        transition: color 0.2s;
    }
    .upload-area:hover .upload-icon { color: #556B2F; }
    .upload-hint { font-size: 0.875rem; color: #64748b; }
    
    /* PREVIEW */
    .preview-box {
        display: none;
        position: relative;
        width: 100%;
        height: 200px;
        border-radius: 1rem;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        margin-top: 1rem;
    }
    .preview-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .btn-remove-img {
        position: absolute;
        top: 12px;
        right: 12px;
        background: rgba(255, 255, 255, 0.9);
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        color: #ef4444;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: transform 0.2s;
    }
    .btn-remove-img:hover { transform: scale(1.1); }

    /* === SUBMIT BUTTON === */
    .btn-submit {
        display: block;
        width: 100%;
        padding: 1rem;
        background-color: #556B2F; /* Hijau Utama */
        color: white;
        font-weight: 700;
        font-size: 1rem;
        border-radius: 1rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 4px 6px -1px rgba(85, 107, 47, 0.2);
    }
    .btn-submit:hover:not(:disabled) {
        background-color: #445725;
        transform: translateY(-2px);
    }
    .btn-submit:disabled {
        background-color: #cbd5e1;
        cursor: not-allowed;
        box-shadow: none;
        transform: none;
    }
</style>
@endpush

@section('content')

<div class="review-header">
    <a href="{{ route('order.detail', $order->id) }}" class="icon-btn">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="icon-svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
        </svg>
    </a>
    <span class="header-title">Ulasan Produk</span>
    <a href="{{ route('dashboard') }}" class="icon-btn danger">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="icon-svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
        </svg>
    </a>
</div>

<div class="review-container">
    <div class="review-card">
        
        <div class="product-summary">
            @php
                $item = $order->items->first();
                // Fallback image logic
                $imgSrc = 'https://via.placeholder.com/64?text=Menu';
                if ($item->menu && $item->menu->image) {
                    $imgSrc = asset('storage/' . $item->menu->image);
                } elseif ($item->menu_image) {
                    $imgSrc = asset('storage/' . $item->menu_image);
                }
            @endphp
            <img src="{{ $imgSrc }}" alt="Menu" class="product-thumb">
            <div class="product-details">
                <h3>{{ $item->menu_name ?? 'Pesanan Katering' }}</h3>
                <p>Order ID: #{{ $order->order_number }}</p>
            </div>
        </div>

        <form action="{{ route('review.store', $order->id) }}" method="POST" enctype="multipart/form-data" id="reviewForm">
            @csrf
            
            <div class="rating-container">
                <span class="rating-label">Bagaimana kepuasan Anda?</span>
                <div class="star-wrapper">
                    @for ($i = 5; $i >= 1; $i--)
                        <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}">
                        <label for="star{{ $i }}" title="{{ $i }} Bintang">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="star-svg">
                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                            </svg>
                        </label>
                    @endfor
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Apa yang paling Anda suka?</label>
                <input type="text" name="question" class="input-control" 
                       placeholder="Contoh: Rasanya enak banget, porsi pas..." required>
            </div>

            <div class="form-group">
                <label class="form-label">Ceritakan pengalaman lengkapnya</label>
                <textarea name="review_text" class="input-control" 
                          placeholder="Berikan detail tentang rasa, pengiriman, atau pelayanan..." required></textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Foto Bukti (Opsional)</label>
                
                <input type="file" id="mediaInput" name="media" accept="image/*" style="display: none;">
                
                <label for="mediaInput" class="upload-area" id="uploadLabel">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="upload-icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                    </svg>
                    <span class="upload-hint">Ketuk untuk mengambil atau pilih foto</span>
                </label>

                <div class="preview-box" id="previewBox">
                    <img id="mediaPreview" class="preview-image">
                    <button type="button" class="btn-remove-img" onclick="removeImage()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 18px; height: 18px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-submit" id="btnSubmit" disabled>
                Kirim Ulasan
            </button>

        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // --- 1. VALIDASI FORM REAL-TIME ---
    const form = document.getElementById('reviewForm');
    const btnSubmit = document.getElementById('btnSubmit');
    const requiredInputs = form.querySelectorAll('input[type="text"], textarea, input[name="rating"]');

    function checkForm() {
        let isValid = true;
        
        // Cek Text Input & Textarea
        form.querySelectorAll('input[type="text"], textarea').forEach(el => {
            if (!el.value.trim()) isValid = false;
        });

        // Cek Radio Rating
        const rating = form.querySelector('input[name="rating"]:checked');
        if (!rating) isValid = false;

        btnSubmit.disabled = !isValid;
    }

    requiredInputs.forEach(input => {
        input.addEventListener('input', checkForm);
        input.addEventListener('change', checkForm);
    });

    // --- 2. PREVIEW GAMBAR ---
    const mediaInput = document.getElementById('mediaInput');
    const previewBox = document.getElementById('previewBox');
    const mediaPreview = document.getElementById('mediaPreview');
    const uploadLabel = document.getElementById('uploadLabel');

    mediaInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                mediaPreview.src = e.target.result;
                uploadLabel.style.display = 'none'; // Sembunyikan label
                previewBox.style.display = 'block'; // Munculkan preview
            }
            reader.readAsDataURL(file);
        }
    });

    // --- 3. HAPUS GAMBAR ---
    window.removeImage = function() {
        mediaInput.value = ''; // Reset file input
        previewBox.style.display = 'none'; // Sembunyikan preview
        uploadLabel.style.display = 'flex'; // Munculkan label lagi
    }
</script>
@endpush