@extends('layouts.main')
@section('title', $title)

@section('content')
    @php
        $user = Auth::user();
        $imgPath = !empty($user->photo) ? $user->photo : (!empty($user->google_avatar) ? $user->google_avatar : null);

        if ($imgPath) {
            $imgUrl = Str::startsWith($imgPath, 'http') ? $imgPath : Storage::url($imgPath);
            if (!Str::startsWith($imgPath, 'http') && Storage::disk('public')->exists($imgPath)) {
                $imgUrl .= '?v=' . Storage::disk('public')->lastModified($imgPath);
            }
        } else {
            $imgUrl = asset('default-user.png');
        }
    @endphp

    <div class="bg-background-base min-h-screen pb-20 transition-colors duration-300">
        {{-- Hero Header Profile --}}
        {{-- jadi titik  --}}
        <div class="bg-background-dark py-12 transition-colors border-b border-card-border">
            <div class="max-w-4xl mx-auto px-4 text-center">
                <h1 class="text-3xl font-black tracking-tighter text-text-light uppercase">Account Settings</h1>
                <p class="text-text-muted text-sm mt-1">Manage your professional health profile</p>
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-4 -mt-12 relative z-10 profile-wrapper">
            <form action="{{ route('test.profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                @csrf
                @method('PATCH')

                {{-- AVATAR SECTION --}}
                <div class="flex flex-col items-center mb-10">
                    <div class="relative group avatar-container">
                        <div
                            class="size-40 md:size-48 rounded-full p-1.5 bg-background-base border-4 border-primary shadow-glow relative overflow-hidden">
                            <img src="{{ $imgUrl }}" id="profilePreview"
                                class="w-full h-full object-cover rounded-full" alt="Avatar">

                            {{-- Camera Overlay (Hanya muncul saat editing via CSS class) --}}
                            <label for="photoInput" id="cameraIcon"
                                class="absolute inset-0 bg-black/60 flex flex-col items-center justify-center text-white cursor-pointer opacity-0 transition-opacity duration-300 hidden">
                                <span class="material-icons-round text-3xl">photo_camera</span>
                                <span class="text-[10px] font-bold uppercase mt-1">Change Photo</span>
                            </label>
                        </div>
                        <input type="file" id="photoInput" name="photo" class="hidden" accept="image/*">
                    </div>
                    <h2 class="text-2xl font-black text-text-light mt-4 tracking-tight">{{ $user->username }}</h2>
                    <span
                        class="px-3 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-black uppercase tracking-widest border border-primary/20">FitLife
                        Member</span>
                </div>

                {{-- INFORMATION CARD --}}
                <div class="bg-card-dark rounded-3xl shadow-soft border border-card-border overflow-hidden">
                    <div class="p-6 md:p-10">
                        <div class="flex items-center gap-3 mb-8 border-l-4 border-primary pl-4">
                            <h3 class="text-lg font-black text-text-light uppercase tracking-wider">Informasi Pribadi</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Nama --}}
                            <div class="space-y-1.5">
                                <label class="text-[11px] font-black text-text-muted uppercase tracking-widest ml-1">Nama
                                    Lengkap</label>
                                <input type="text" name="name"
                                    class="editable w-full h-12 px-4 bg-background-base border border-card-border rounded-xl text-text-light font-medium focus:ring-2 focus:ring-primary transition-all outline-none read-only:opacity-70"
                                    value="{{ old('name', $user->username) }}" readonly>
                            </div>

                            {{-- Email --}}
                            <div class="space-y-1.5">
                                <label class="text-[11px] font-black text-text-muted uppercase tracking-widest ml-1">Email
                                    Address</label>
                                <input type="email" name="email"
                                    class="editable w-full h-12 px-4 bg-background-base border border-card-border rounded-xl text-text-light font-medium focus:ring-2 focus:ring-primary transition-all outline-none read-only:opacity-70"
                                    value="{{ old('email', $user->email) }}" readonly>
                            </div>

                            {{-- Telepon --}}
                            <div class="space-y-1.5">
                                <label class="text-[11px] font-black text-text-muted uppercase tracking-widest ml-1">Nomor
                                    Telepon</label>
                                <input type="text" name="phone"
                                    class="editable w-full h-12 px-4 bg-background-base border border-card-border rounded-xl text-text-light font-medium focus:ring-2 focus:ring-primary transition-all outline-none read-only:opacity-70"
                                    value="{{ old('phone', $user->phone) }}" readonly>
                            </div>

                            {{-- Tgl Lahir --}}
                            <div class="space-y-1.5">
                                <label class="text-[11px] font-black text-text-muted uppercase tracking-widest ml-1">Tanggal
                                    Lahir</label>
                                <input type="date" name="birthdate"
                                    class="editable w-full h-12 px-4 bg-background-base border border-card-border rounded-xl text-text-light font-medium focus:ring-2 focus:ring-primary transition-all outline-none read-only:opacity-70"
                                    value="{{ old('birthdate', $user->birthdate) }}" readonly>
                            </div>

                            {{-- Berat --}}
                            <div class="space-y-1.5">
                                <label class="text-[11px] font-black text-text-muted uppercase tracking-widest ml-1">Berat
                                    Badan (kg)</label>
                                <input type="number" name="weight"
                                    class="editable w-full h-12 px-4 bg-background-base border border-card-border rounded-xl text-text-light font-medium focus:ring-2 focus:ring-primary transition-all outline-none read-only:opacity-70"
                                    value="{{ old('weight', $user->weight) }}" readonly>
                            </div>

                            {{-- Tinggi --}}
                            <div class="space-y-1.5">
                                <label class="text-[11px] font-black text-text-muted uppercase tracking-widest ml-1">Tinggi
                                    Badan (cm)</label>
                                <input type="number" name="height"
                                    class="editable w-full h-12 px-4 bg-background-base border border-card-border rounded-xl text-text-light font-medium focus:ring-2 focus:ring-primary transition-all outline-none read-only:opacity-70"
                                    value="{{ old('height', $user->height) }}" readonly>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="mt-12 flex justify-end items-center gap-3 pt-8 border-t border-card-border">
                            <button type="button" id="editBtn"
                                class="flex items-center gap-2 px-8 py-3 bg-primary text-background-base font-black rounded-xl shadow-glow hover:bg-primary-hover transition-all transform hover:-translate-y-1">
                                <span class="material-icons-round text-sm">edit</span>
                                Edit Profile
                            </button>

                            <button type="button" id="cancelBtn"
                                class="hidden px-6 py-3 border border-card-border text-text-muted font-bold rounded-xl hover:bg-red-500/10 hover:text-red-500 transition-all">
                                Batal
                            </button>

                            <button type="submit" id="saveBtn"
                                class="hidden flex items-center gap-2 px-8 py-3 bg-primary text-background-base font-black rounded-xl shadow-glow hover:bg-primary-hover transition-all transform hover:-translate-y-1">
                                <span class="material-icons-round text-sm">save</span>
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            {{-- Logout Section --}}
            <div class="mt-8 text-center">
                <form action="{{ route('auth.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 bg-red-500/10 text-red-500 font-bold rounded-xl border border-red-500/20 hover:bg-red-500 hover:text-white transition-all">
                        <span class="material-icons-round text-sm">logout</span>
                        Logout Account
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        (function() {
            const editBtn = document.getElementById('editBtn');
            const saveBtn = document.getElementById('saveBtn');
            const cancelBtn = document.getElementById('cancelBtn');
            const cameraIcon = document.getElementById('cameraIcon');
            const profileWrapper = document.querySelector('.profile-wrapper');
            const editableInputs = document.querySelectorAll('.editable');
            const photoInput = document.getElementById('photoInput');
            const profilePreview = document.getElementById('profilePreview');

            function toggleEditMode(isEditing) {
                if (isEditing) {
                    editBtn.classList.add('hidden');
                    saveBtn.classList.remove('hidden');
                    cancelBtn.classList.remove('hidden');
                    cameraIcon.classList.remove('hidden');
                    cameraIcon.classList.add('opacity-100');
                    editableInputs.forEach(i => i.removeAttribute('readonly'));
                    editableInputs[0].focus();
                } else {
                    editBtn.classList.remove('hidden');
                    saveBtn.classList.add('hidden');
                    cancelBtn.classList.add('hidden');
                    cameraIcon.classList.add('hidden');
                    editableInputs.forEach(i => i.setAttribute('readonly', 'readonly'));
                }
            }

            editBtn.addEventListener('click', () => toggleEditMode(true));

            cancelBtn.addEventListener('click', () => {
                // Gunakan reload atau kembalikan value manual jika ingin lebih smooth
                window.location.reload();
            });

            photoInput.addEventListener('change', function(e) {
                const file = e.target.files && e.target.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = function(ev) {
                    profilePreview.src = ev.target.result;
                };
                reader.readAsDataURL(file);
            });
        })();
    </script>
@endsection
