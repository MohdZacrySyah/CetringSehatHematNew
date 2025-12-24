@extends('layouts.app')
@section('title', 'Ulasan')

@push('styles')
<style>
    /* Override layout background */
    .main-wrapper {
        background: #f8f9fa !important;
        padding-bottom: 0 !important;
    }
    
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    body {
        background: #f8f9fa;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }
    
    .review-header {
        background: #fff;
        padding: 15px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        position: sticky;
        top: 0;
        z-index: 100;
    }
    
    .back-btn {
        font-size: 1.5rem;
        color: #333;
        cursor: pointer;
        text-decoration: none;
        padding: 5px;
    }
    
    .header-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
    }
    
    .close-btn {
        font-size: 2rem;
        color: #333;
        cursor: pointer;
        text-decoration: none;
        font-weight: 300;
        line-height: 1;
    }
    
    .review-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px 15px 100px 15px;
    }
    
    .question-section {
        margin-bottom: 15px;
    }
    
    .question-title {
        font-size: 0.85rem;
        color: #888;
        margin-bottom: 10px;
        font-weight: 400;
    }
    
    .input-box {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 14px 16px;
    }
    
    .input-box input {
        width: 100%;
        border: none;
        outline: none;
        font-size: 0.9rem;
        color: #333;
        font-family: inherit;
    }
    
    .input-box input::placeholder {
        color: #ccc;
        font-size: 0.85rem;
    }
    
    .review-section {
        margin-bottom: 15px;
    }
    
    .textarea-box {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 14px 16px;
        min-height: 140px;
    }
    
    .textarea-box textarea {
        width: 100%;
        border: none;
        outline: none;
        font-size: 0.9rem;
        color: #333;
        resize: none;
        min-height: 110px;
        font-family: inherit;
    }
    
    .textarea-box textarea::placeholder {
        color: #ccc;
        font-size: 0.85rem;
    }
    
    .media-section {
        margin-bottom: 20px;
    }
    
    .media-upload {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 60px 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        display: block;
    }
    
    .media-upload:hover {
        border-color: #aaa;
        background: #fafafa;
    }
    
    .camera-icon {
        font-size: 4rem;
        color: #333;
        margin-bottom: 15px;
    }
    
    .media-text {
        color: #999;
        font-size: 0.9rem;
        margin: 0;
    }
    
    .media-preview {
        max-width: 100%;
        max-height: 250px;
        margin: 0 auto;
        border-radius: 10px;
        display: none;
    }
    
    .media-upload.has-preview {
        padding: 15px;
    }
    
    .media-upload.has-preview .camera-icon,
    .media-upload.has-preview .media-text {
        display: none;
    }
    
    .rating-section {
        margin-bottom: 25px;
    }
    
    .rating-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 18px;
        display: block;
        font-size: 1rem;
    }
    
    .star-rating {
        display: flex;
        gap: 8px;
    }
    
    .star {
        font-size: 3rem;
        color: #d4d4d4;
        cursor: pointer;
        transition: color 0.15s;
    }
    
    .star:hover,
    .star.active {
        color: #FFD700;
    }
    
    .btn-submit {
        width: 100%;
        padding: 16px;
        background: #22c55e;
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .btn-submit:hover:not(:disabled) {
        background: #16a34a;
    }
    
    .btn-submit:disabled {
        background: #d1d5db;
        cursor: not-allowed;
    }
</style>
@endpush

@section('content')
<div class="review-header">
    <a href="{{ route('order.detail', $order->id) }}" class="back-btn">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <span class="header-title">Ulasan</span>
    <a href="{{ route('order.detail', $order->id) }}" class="close-btn">
        <i class="fa-solid fa-xmark"></i>
    </a>
</div>

<form action="{{ route('review.store', $order->id) }}" method="POST" enctype="multipart/form-data" id="reviewForm">
    @csrf
    <div class="review-container">
        <!-- Question Input -->
        <div class="question-section">
            <div class="question-title">apa yang bikin kamu merasa puas ?</div>
            <div class="input-box">
                <input type="text" 
                       name="question" 
                       placeholder="contoh : salad buahnya segar dan enak , dessert keju bikin nagih" 
                       required>
            </div>
        </div>

        <!-- Review Textarea -->
        <div class="review-section">
            <div class="textarea-box">
                <textarea name="review_text" 
                          placeholder="contoh : salad buahnya segar dan enak , dessert keju bikin nagih" 
                          required></textarea>
            </div>
        </div>

        <!-- Media Upload -->
        <div class="media-section">
            <label for="mediaInput" class="media-upload" id="mediaUploadLabel">
                <div class="camera-icon">
                    <i class="fa-solid fa-camera"></i>
                </div>
                <p class="media-text">kasih liat foto atau video produk</p>
                <img id="mediaPreview" class="media-preview">
            </label>
            <input type="file" 
                   id="mediaInput" 
                   name="media" 
                   accept="image/*,video/*" 
                   style="display: none;">
        </div>

        <!-- Rating Stars -->
        <div class="rating-section">
            <span class="rating-label">Rating</span>
            <div class="star-rating" id="starRating">
                <i class="fa-solid fa-star star" data-rating="1"></i>
                <i class="fa-solid fa-star star" data-rating="2"></i>
                <i class="fa-solid fa-star star" data-rating="3"></i>
                <i class="fa-solid fa-star star" data-rating="4"></i>
                <i class="fa-solid fa-star star" data-rating="5"></i>
            </div>
            <input type="hidden" name="rating" id="ratingInput" required>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn-submit" id="btnSubmit" disabled>
            Kirim Ulasan
        </button>
    </div>
</form>

@push('scripts')
<script>
    let selectedRating = 0;

    // Handle star rating
    document.querySelectorAll('.star').forEach(star => {
        star.addEventListener('click', function() {
            selectedRating = this.dataset.rating;
            document.getElementById('ratingInput').value = selectedRating;
            
            document.querySelectorAll('.star').forEach(s => {
                if (s.dataset.rating <= selectedRating) {
                    s.classList.add('active');
                } else {
                    s.classList.remove('active');
                }
            });
            
            checkFormValidity();
        });
    });

    // Handle media upload preview
    document.getElementById('mediaInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            const uploadLabel = document.getElementById('mediaUploadLabel');
            
            reader.onload = function(e) {
                const preview = document.getElementById('mediaPreview');
                preview.src = e.target.result;
                preview.style.display = 'block';
                uploadLabel.classList.add('has-preview');
            };
            reader.readAsDataURL(file);
        }
    });

    // Check form validity
    function checkFormValidity() {
        const question = document.querySelector('input[name="question"]').value.trim();
        const review = document.querySelector('textarea[name="review_text"]').value.trim();
        const rating = document.getElementById('ratingInput').value;
        
        document.getElementById('btnSubmit').disabled = !(question && review && rating);
    }

    // Add input listeners
    document.querySelector('input[name="question"]').addEventListener('input', checkFormValidity);
    document.querySelector('textarea[name="review_text"]').addEventListener('input', checkFormValidity);
</script>
@endpush
@endsection
