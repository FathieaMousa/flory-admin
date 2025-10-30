@extends('layouts.master')

@section('title', 'Edit Profile - Flory Admin')

@section('content')
<div class="container py-4">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header text-center bg-light border-0 py-4">
            <h4 class="fw-bold text-secondary mb-0">🌸 Edit Admin Profile</h4>
        </div>

        <div class="card-body px-5 py-4">
            @if(session('success'))
                <div class="alert alert-success text-center">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger text-center">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <!--صورة البروفايل -->
                <div class="text-center mb-4">
                    <img
                        id="avatarPreview"
                        src="{{ session('admin_avatar') ? asset('storage/' . session('admin_avatar')) : asset('assets/flory-app.jpg') }}"
                        alt="Admin Avatar"
                        class="rounded-circle shadow border border-2 border-light"
                        width="120" height="120"
                        style="object-fit: cover; transition: 0.3s;">
                </div>

                <!-- الاسم -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Admin Name</label>
                    <input type="text" name="name" value="{{ old('name', session('admin_name', 'Admin')) }}" class="form-control" required>
                </div>

                <!-- اختيار الصورة -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Profile Image</label>
                    <input type="file" name="avatar" id="avatarInput" class="form-control" accept="image/*">
                    <small class="text-muted">Allowed: JPG, PNG (max 2MB)</small>
                </div>

                <hr class="my-4">

                <!--كلمة المرور -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">New Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Leave empty to keep current password">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>

                <!-- زر الحفظ -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-lg px-5 text-white" style="background-color:#ee9ca7;">
                        <i class="bi bi-save me-2"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // عند اختيار صورة جديدة، يتم عرضها فورًا
    document.getElementById('avatarInput').addEventListener('change', function (event) {
        const file = event.target.files[0];
        const preview = document.getElementById('avatarPreview');

        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.classList.add('border-success');
            };
            reader.readAsDataURL(file);
        } else {
            preview.src = "{{ asset('assets/default-avatar.png') }}";
        }
    });
</script>
@endsection
