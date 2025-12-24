@extends('layouts.app')
@section('title', 'Profil')

@push('styles')
<style>
    body {
        background: linear-gradient(180deg, #8B9D5E 0%, #B4C588 100%);
        margin: 0;
        padding: 0;
        min-height: 100vh;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    }
    .profile-container {
        max-width: 570px;
        margin: 27px auto 0 auto;
        padding: 0 2vw 86px 2vw;
    }
    .cart-header {
        background-color: #879b55;
        padding: 14px 0;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        position: relative;
        color: white;
        font-weight: bold;
        font-size: 1.17rem;
        border-radius: 9px;
        margin-bottom: 23px;
        letter-spacing: 0.005em;
    }
    .back-arrow {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 1.48rem;
        color: white;
        text-decoration: none;
        cursor: pointer;
        background: none;
        border: none;
        padding: 0;
        transition: opacity .2s;
    }
    .back-arrow:hover { opacity: 0.8; }

    .profile-photo-section {
        text-align: center;
        margin-bottom: 12px;
        margin-top: 8px;
    }
    .profile-photo {
        width: 104px;
        height: 104px;
        border-radius: 50%;
        background-color: #D4E1B8;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 3px solid #fff;
        box-shadow: 0 2px 12px #b4c58833;
        overflow: hidden;
        margin-bottom: 10px;
    }
    .profile-photo img, .profile-icon {
        width: 88px;
        height: 88px;
        object-fit: cover;
        border-radius: 50%;
    }
    .profile-icon { color: #A3B885; }

    .edit-profile-label {
        font-size: 1rem;
        font-weight: 600;
        color: #25320A;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }
    .edit-profile-label:hover {
        text-decoration: underline;
    }

    .form-card {
        background-color: #D4E1B8;
        border-radius: 17px;
        padding: 20px 16px;
        margin-top: 18px;
        box-shadow: 0 2px 15px #c2d5a02b;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .form-group {
        width: 100%;
    }
    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #31450e;
        margin-bottom: 4px;
        letter-spacing: 0.025em;
    }
    .form-value {
        width: 100%;
        padding: 12px 13px;
        border: none;
        border-radius: 8px;
        background-color: #E8EFD8;
        font-size: 15px;
        color: #24380a;
        box-sizing: border-box;
        font-family: inherit;
        font-weight: 500;
    }

    /* BUTTON LOGOUT */
    .logout-section {
        text-align: center;
        margin-top: 20px;
        margin-bottom: 20px;
    }
    .logout-button {
        background-color: #c74a43;
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 14px 32px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 3px 10px #c74a4333;
        transition: background .18s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .logout-button:hover {
        background-color: #a83832;
    }
    
    /* MODAL KONFIRMASI LOGOUT */
    .logout-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }
    .logout-modal.show {
        display: flex;
    }
    .logout-modal-content {
        background: #fff;
        border-radius: 15px;
        padding: 25px;
        max-width: 340px;
        width: 90%;
        text-align: center;
        box-shadow: 0 5px 20px rgba(0,0,0,0.3);
    }
    .logout-modal-icon {
        font-size: 3rem;
        color: #c74a43;
        margin-bottom: 15px;
    }
    .logout-modal-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 10px;
    }
    .logout-modal-text {
        font-size: 0.95rem;
        color: #666;
        margin-bottom: 25px;
    }
    .logout-modal-buttons {
        display: flex;
        gap: 12px;
        justify-content: center;
    }
    .logout-modal-btn {
        padding: 10px 24px;
        border: none;
        border-radius: 8px;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        transition: background .18s;
    }
    .logout-modal-btn-cancel {
        background: #e0e0e0;
        color: #333;
    }
    .logout-modal-btn-cancel:hover {
        background: #d0d0d0;
    }
    .logout-modal-btn-confirm {
        background: #c74a43;
        color: #fff;
    }
    .logout-modal-btn-confirm:hover {
        background: #a83832;
    }

    @media (max-width: 600px) {
        .profile-container {padding-left: 4px; padding-right: 4px;}
        .cart-header {font-size: 1rem; padding: 10px 0;}
    }
    @media (max-width: 400px) {
        .profile-photo {width:84px;height:84px;}
        .profile-photo img,.profile-icon{width:73px;height:73px;}
    }
</style>
@endpush

@section('content')
<div class="cart-header">
    <button class="back-arrow" onclick="window.history.back()" type="button">
        <i class="fa-solid fa-arrow-left"></i>
    </button>
    <span>Profil</span>
</div>

<div class="profile-container">
    <div class="profile-photo-section">
        <div class="profile-photo">
            @if($user->avatar)
                <img src="{{ asset('storage/'.$user->avatar) }}" alt="Profil">
            @else
                <svg class="profile-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    ircle cx="12" cy="7" r="4"></circle>
                </svg>
            @endif
        </div>
        <br>
        <a href="{{ route('profile.edit') }}" class="edit-profile-label">
            <i class="fa-solid fa-pen-to-square"></i> Edit Profil
        </a>
    </div>

    <div class="form-card">
        <div class="form-group">
            <label class="form-label">Nama Pengguna</label>
            <div class="form-value">{{ $user->name }}</div>
        </div>
        <div class="form-group">
            <label class="form-label">Alamat Lengkap</label>
            <div class="form-value">{{ $user->alamat ?? '-' }}</div>
        </div>
        <div class="form-group">
            <label class="form-label">No. Telpon</label>
            <div class="form-value">{{ $user->telp ?? '-' }}</div>
        </div>
        <div class="form-group">
            <label class="form-label">Email</label>
            <div class="form-value">{{ $user->email }}</div>
        </div>
        <div class="form-group">
            <label class="form-label">Password</label>
            <div class="form-value">••••••••</div>
        </div>
    </div>

   
</div>



@push('scripts')
<script>
    function showLogoutModal() {
        document.getElementById('logoutModal').classList.add('show');
    }

    function hideLogoutModal() {
        document.getElementById('logoutModal').classList.remove('show');
    }

    document.getElementById('logoutModal').addEventListener('click', function(e) {
        if (e.target === this) {
            hideLogoutModal();
        }
    });
</script>
@endpush
@endsection
