# 📊 Laporan Analisis Design Patterns — Proyek FitLife.id (Laravel)

> **Tanggal Analisis:** 29 April 2026  
> **Framework:** Laravel 10/11  
> **Jumlah File Dianalisis:** ~40+ file (Controllers, Models, Middleware, Routes, Views, Seeders, Factories, Providers)

---

## Ringkasan Eksekutif

Dari hasil analisis menyeluruh terhadap kode proyek FitLife.id, ditemukan **total 16 design pattern** yang terbagi dalam 3 kategori:

| Kategori | Jumlah Pattern | Contoh Utama |
|---|---|---|
| 🟢 **Creational** | 5 | Factory, Builder, Singleton, Prototype, Static Factory Method |
| 🔵 **Structural** | 6 | MVC, Facade, Composite, Adapter, Decorator, Proxy |
| 🟠 **Behavioral** | 5 | Template Method, Strategy, Chain of Responsibility, Observer, Command |

> [!NOTE]
> Sebagian besar pattern berasal dari **framework Laravel itu sendiri** yang secara arsitektural sudah menerapkan banyak design pattern. Beberapa pattern juga diimplementasikan secara **eksplisit** oleh developer di kode aplikasi.

---

## 🟢 1. CREATIONAL PATTERNS (Pola Penciptaan Objek)

Creational patterns berfokus pada **cara objek diciptakan**, menyembunyikan logika pembuatan objek agar lebih fleksibel.

---

### 1.1 Factory Method Pattern ✅

**Definisi:** Menyerahkan pembuatan objek ke subclass atau method khusus, tanpa menentukan class konkret secara langsung.

**Ditemukan di:**

#### a) Eloquent Model `create()` — Static Factory Method
Setiap kali kode memanggil `Model::create([...])`, Laravel menggunakan Factory Method untuk membuat instance model baru.

```php
// File: app/Http/Controllers/AuthCustomController.php (baris 29-34)
Account::create([
    'username' => $request->username,
    'email'    => $request->email,
    'password' => Hash::make($request->password),
    'role'     => 'user',
]);

// File: app/Http/Controllers/Admin/MenuController.php (baris 49)
Menu::create($data);

// File: app/Http/Controllers/HomeController.php (baris 72-78)
Perhitungan::create([
    'user_id'      => auth()->id(),
    'tinggi_badan' => $tinggi,
    'berat_badan'  => $berat,
    'bmi'          => $bmi,
    'status'       => $label,
]);
```

**Lokasi:** `AuthCustomController`, `GoogleController`, `Admin\ArtikelController`, `Admin\MenuController`, `Admin\UserController`, `Admin\KategoriController`, `HomeController`, `AuthApiController`

#### b) Database Factory — `UserFactory`
```php
// File: database/factories/UserFactory.php
class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'  => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            // ...
        ];
    }
}
```

**Penggunaan di** `DatabaseSeeder.php`:
```php
User::factory()->create([...]);
```

> [!TIP]
> Factory pattern ini memungkinkan pembuatan data dummy secara konsisten untuk testing dan seeding.

---

### 1.2 Builder Pattern ✅

**Definisi:** Membangun objek kompleks langkah demi langkah melalui method chaining.

**Ditemukan di:** Query Builder Eloquent — digunakan **secara masif** di seluruh controller.

```php
// File: app/Http/Controllers/ArtikelController.php (baris 20-31)
$query = Artikel::query();
if ($selectedKategori !== '') {
    $query->where('kategori', 'LIKE', '%' . $selectedKategori . '%');
}
if ($q !== '') {
    $query->where(function ($sub) use ($q) {
        $sub->where('judul', 'LIKE', "%{$q}%")
            ->orWhere('isi', 'LIKE', "%{$q}%");
    });
}
$artikels = $query->latest()->get();

// File: app/Http/Controllers/MenuController.php (baris 16-25)
$menus = Menu::query()
    ->when($search, function ($query, $search) {
        return $query->where('nama_menu', 'like', "%{$search}%")
            ->orWhere('deskripsi', 'like', "%{$search}%");
    })
    ->when($status, function ($query, $status) {
        return $query->where('target_status', $status);
    })
    ->latest()
    ->get();
```

**Lokasi:** `ArtikelController`, `MenuController`, `Admin\ArtikelController`, `Admin\MenuController`, `Admin\UserController`, `HomeController`, `GoogleController`

---

### 1.3 Singleton Pattern ✅

**Definisi:** Memastikan sebuah class hanya memiliki satu instance di seluruh aplikasi.

**Ditemukan di (dikelola Laravel):**

- **Application Container** — `app()` selalu mengembalikan instance yang sama
- **Auth Guard** — `Auth::user()` mengambil dari singleton
- **`auth()` helper** — singleton di balik layar

```php
// File: app/Http/Controllers/AuthCustomController.php
Auth::attempt($request->only('email', 'password'));
Auth::user()->role;
Auth::logout();

// File: app/Http/Controllers/ProfileController.php
$user = Auth::user();
```

---

### 1.4 Prototype Pattern ✅

**Definisi:** Membuat objek baru dengan meng-clone objek yang sudah ada.

**Ditemukan di (implisit via Laravel):**

```php
// File: app/Http/Controllers/ArtikelController.php (baris 20)
$query = Artikel::query(); // base query yang di-clone secara internal saat chaining
```

Setiap kali `query()` dipanggil, Eloquent membuat clone dari base query builder.

---

### 1.5 Static Factory Method Pattern ✅

**Definisi:** Menggunakan static method untuk membuat objek alih-alih constructor.

```php
// File: app/Http/Controllers/Api/AuthApiController.php (baris 26)
$token = $account->createToken('flutter_token')->plainTextToken;

// File: app/Http/Controllers/GoogleController.php
Socialite::driver('google')->redirect();
Socialite::driver('google')->stateless()->user();

// File: app/Http/Controllers/HomeController.php
Perhitungan::create([...]);
```

---

## 🔵 2. STRUCTURAL PATTERNS (Pola Struktur)

Structural patterns berfokus pada **komposisi objek dan class** untuk membentuk struktur yang lebih besar.

---

### 2.1 MVC (Model-View-Controller) Pattern ✅

**Definisi:** Memisahkan aplikasi menjadi 3 layer: Model (data), View (tampilan), Controller (logika).

> [!IMPORTANT]
> Ini adalah **pattern arsitektural utama** proyek ini. Seluruh kode diorganisir mengikuti MVC.

| Layer | Lokasi | File |
|---|---|---|
| **Model** | `app/Models/` | `Account.php`, `Artikel.php`, `Kategori.php`, `Menu.php`, `Perhitungan.php`, `User.php` |
| **View** | `resources/views/` | `pages/*.blade.php`, `admin/*.blade.php`, `auth/*.blade.php`, `layouts/*.blade.php` |
| **Controller** | `app/Http/Controllers/` | `HomeController`, `ArtikelController`, `MenuController`, dll. |

```
app/
├── Models/          ← MODEL
│   ├── Account.php
│   ├── Artikel.php
│   ├── Kategori.php
│   ├── Menu.php
│   └── Perhitungan.php
├── Http/
│   └── Controllers/ ← CONTROLLER
│       ├── HomeController.php
│       ├── ArtikelController.php
│       └── Admin/
│           ├── AdminController.php
│           └── ...
resources/
└── views/           ← VIEW
    ├── pages/
    ├── admin/
    └── layouts/
```

---

### 2.2 Facade Pattern ✅

**Definisi:** Menyediakan interface yang sederhana (static-like) ke subsystem yang kompleks.

**Ditemukan di:**

```php
// File: app/Http/Controllers/AuthCustomController.php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
Auth::attempt([...]);       // Facade ke AuthManager
Auth::user();               // Facade ke Guard
Hash::make($password);      // Facade ke Hasher

// File: app/Http/Controllers/ProfileController.php
use Illuminate\Support\Facades\Storage;
Storage::disk('public')->exists($user->photo);
Storage::disk('public')->delete($user->photo);

// File: app/Http/Controllers/GoogleController.php
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
Log::error('...');
Socialite::driver('google');

// File: app/Providers/AppServiceProvider.php
use Illuminate\Support\Facades\View;
View::composer('menu.nav', function ($view) { ... });

// File: app/Http/Controllers/Admin/AdminController.php
use Illuminate\Support\Facades\Schema;
Schema::hasColumn('accounts', 'is_active');
```

**Daftar Facade yang digunakan:**

| Facade | Digunakan Di | Subsystem |
|---|---|---|
| `Auth` | AuthCustomController, ProfileController, GoogleController, AuthApiController | Authentication |
| `Hash` | AuthCustomController, GoogleController, UserController, AuthApiController | Hashing |
| `Storage` | ProfileController, Admin\ArtikelController, Admin\MenuController, Admin\UserController, GoogleController | File System |
| `Log` | GoogleController | Logging |
| `Socialite` | GoogleController | OAuth |
| `View` | AppServiceProvider | View Engine |
| `Schema` | AdminController | Database Schema |
| `Route` | web.php, api.php | Routing |
| `DB` | MakananSeeder, PerhitunganSeeder | Database |
| `Str` | GoogleController, Admin\ArtikelController | String Utilities |

---

### 2.3 Composite Pattern ✅

**Definisi:** Menyusun objek dalam struktur pohon (tree) agar bisa diperlakukan secara seragam.

**Ditemukan di:**

#### a) Blade Template Inheritance
```php
// File: resources/views/layouts/main.blade.php
@yield('content')       // slot untuk child
@include('menu.nav')    // compose partial

// File: resources/views/layouts/admin.blade.php
@include('layouts.sidebar')
@yield('content')

// Child view compose ke parent:
// File: resources/views/pages/home.blade.php (expected)
@extends('layouts.main')
@section('content') ... @endsection
```

#### b) Middleware Stack
```php
// File: app/Http/kernel.php (baris 30-43)
'web' => [
    EncryptCookies::class,
    AddQueuedCookiesToResponse::class,
    StartSession::class,
    ShareErrorsFromSession::class,
    VerifyCsrfToken::class,
    SubstituteBindings::class,
],
```

---

### 2.4 Adapter Pattern ✅

**Definisi:** Mengkonversi interface dari satu class agar kompatibel dengan class lain.

**Ditemukan di:**

```php
// File: app/Models/Account.php (baris 9)
class Account extends Authenticatable
// Account menggunakan tabel 'accounts' tapi meng-extend Authenticatable
// agar kompatibel dengan sistem Auth Laravel yang default-nya pakai User
```

Model `Account` bertindak sebagai **adapter** — mengadaptasi tabel custom `accounts` agar bisa digunakan oleh Auth system Laravel yang mengharapkan model `Authenticatable`.

```php
// File: app/Models/Account.php
protected $table = 'accounts';   // bukan default 'users'
// tapi tetap kompatibel dengan Auth::attempt(), Auth::user(), dll.
```

---

### 2.5 Decorator Pattern ✅

**Definisi:** Menambahkan fungsionalitas ke objek secara dinamis tanpa mengubah class aslinya.

**Ditemukan di:**

#### Traits sebagai Decorator
```php
// File: app/Models/Account.php
class Account extends Authenticatable
{
    use Notifiable;      // menambah fitur notifikasi
    use HasApiTokens;    // menambah fitur API token (Sanctum)
}

// File: app/Models/Artikel.php
class Artikel extends Model
{
    use HasFactory;       // menambah fitur factory
}

// File: app/Http/Controllers/Controller.php
class Controller extends BaseController
{
    use AuthorizesRequests;   // menambah fitur authorization
    use DispatchesJobs;       // menambah fitur job dispatching
    use ValidatesRequests;    // menambah fitur validasi
}
```

---

### 2.6 Proxy Pattern ✅

**Definisi:** Menyediakan pengganti (surrogate) untuk mengontrol akses ke objek lain.

**Ditemukan di:**

#### Middleware sebagai Proxy
```php
// File: app/Http/Middleware/AdminMiddleware.php
class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        return $next($request);  // bertindak sebagai proxy/gatekeeper
    }
}

// File: routes/web.php (baris 37)
Route::middleware('auth')->prefix('test')->group(function () {
    Route::get('/profile', [ProfileController::class, 'halamanProfile']);
    Route::patch('/profile/update', [ProfileController::class, 'update']);
});
```

`auth` middleware bertindak sebagai **proxy** yang mengontrol akses ke route profile — hanya user yang terautentikasi yang boleh lewat.

---

## 🟠 3. BEHAVIORAL PATTERNS (Pola Perilaku)

Behavioral patterns berfokus pada **interaksi dan komunikasi** antar objek.

---

### 3.1 Template Method Pattern ✅

**Definisi:** Mendefinisikan kerangka algoritma di superclass, membiarkan subclass mengisi langkah-langkah spesifik.

**Ditemukan di:**

#### a) Blade Template Inheritance
```
layouts/main.blade.php     → mendefinisikan kerangka halaman
  └── pages/home.blade.php → mengisi @section('content')

layouts/admin.blade.php    → mendefinisikan kerangka admin
  └── admin/dashboard.blade.php → mengisi konten spesifik
```

#### b) Seeder Hierarchy
```php
// File: database/seeders/DatabaseSeeder.php
class DatabaseSeeder extends Seeder  // extends template
{
    public function run(): void       // mengisi method template
    {
        $this->call([
            MakananSeeder::class,
            PerhitunganSeeder::class,
        ]);
    }
}
```

#### c) Controller Inheritance
```php
// Semua controller extend Controller.php yang extend BaseController
class HomeController extends Controller { ... }
class ArtikelController extends Controller { ... }
class Admin\AdminController extends Controller { ... }
```

---

### 3.2 Strategy Pattern ✅

**Definisi:** Mendefinisikan keluarga algoritma, menempatkannya di class terpisah, dan membuatnya bisa saling ditukar.

**Ditemukan di:**

#### a) Authentication Strategy
```php
// STRATEGY 1: Login tradisional (email + password)
// File: app/Http/Controllers/AuthCustomController.php
Auth::attempt($request->only('email', 'password'));

// STRATEGY 2: Login via Google OAuth (web)
// File: app/Http/Controllers/GoogleController.php
Socialite::driver('google')->stateless()->user();

// STRATEGY 3: Login via Google ID Token (API/mobile)
// File: app/Http/Controllers/GoogleController.php
$client = new Google_Client([...]);
$payload = $client->verifyIdToken($request->id_token);

// STRATEGY 4: Login via API token (Sanctum)
// File: app/Http/Controllers/Api/AuthApiController.php
$token = $account->createToken('flutter_token')->plainTextToken;
```

Aplikasi memiliki **4 strategi autentikasi berbeda** yang bisa dipilih sesuai konteks.

#### b) Storage Strategy
```php
Storage::disk('public')->store(...);  // bisa diganti ke 's3', 'local', dll
```

#### c) Conditional Query Strategy (via `when`)
```php
// File: app/Http/Controllers/MenuController.php
$menus = Menu::query()
    ->when($search, function ($query, $search) { ... })   // strategy A
    ->when($status, function ($query, $status) { ... })   // strategy B
```

---

### 3.3 Chain of Responsibility Pattern ✅

**Definisi:** Merantai handler yang masing-masing bisa memproses atau meneruskan request.

**Ditemukan di:**

#### Middleware Pipeline
```php
// File: app/Http/kernel.php
// Request melewati rantai middleware satu per satu:
protected $middleware = [
    TrustProxies::class,              // handler 1
    HandleCors::class,                // handler 2
    PreventRequestsDuringMaintenance::class, // handler 3
    ValidatePostSize::class,          // handler 4
    TrimStrings::class,               // handler 5
    ConvertEmptyStringsToNull::class,  // handler 6
];

// Middleware group 'web' juga membentuk chain:
'web' => [
    EncryptCookies::class,            // link 1
    AddQueuedCookiesToResponse::class, // link 2
    StartSession::class,              // link 3
    ShareErrorsFromSession::class,    // link 4
    VerifyCsrfToken::class,           // link 5
    SubstituteBindings::class,        // link 6
],
```

Setiap middleware bisa memutuskan:
- ✅ Meneruskan ke handler berikutnya (`$next($request)`)
- ❌ Menghentikan chain (misalnya `abort(403)` atau `redirect()`)

```php
// File: app/Http/Middleware/AdminMiddleware.php
public function handle(Request $request, Closure $next)
{
    return $next($request); // meneruskan ke handler berikutnya
}
```

---

### 3.4 Observer Pattern ✅

**Definisi:** Objek (subject) memberi tahu objek lain (observer) saat terjadi perubahan state.

**Ditemukan di:**

#### a) View Composer
```php
// File: app/Providers/AppServiceProvider.php
View::composer('menu.nav', function ($view) {
    $currentRoute = request()->route() ? request()->route()->getName() : '';
    $view->with('slug', $currentRoute);
});
```
Setiap kali view `menu.nav` di-render, callback ini otomatis dipanggil — ini adalah implementasi Observer pattern.

#### b) Eloquent Events (implisit)
Model `Account` menggunakan trait `Notifiable` yang secara internal subscribe ke event-event model.

#### c) Model Attribute Casting/Mutators
```php
// File: app/Models/Account.php
public function getNameAttribute()
{
    return $this->nama_lengkap ?? $this->username;
}
```
Accessor ini otomatis "dipicu" saat attribute `name` diakses — mirip observer pada property access.

---

### 3.5 Command Pattern ✅

**Definisi:** Mengenkapsulasi request sebagai objek, memungkinkan parameterisasi dan antrian.

**Ditemukan di:**

#### a) Artisan Commands & Seeders
```php
// File: database/seeders/DatabaseSeeder.php
$this->call([
    MakananSeeder::class,      // command 1
    PerhitunganSeeder::class,  // command 2
]);
```
Setiap seeder adalah "command" yang dieksekusi oleh `DatabaseSeeder`.

#### b) Route Definitions sebagai Command Objects
```php
// File: routes/web.php
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/login', [AuthCustomController::class, 'login'])->name('auth.login.post');
Route::resource('menu', AdminMenuController::class);
```
Setiap route definition mengenkapsulasi "perintah" (controller + action) yang akan dieksekusi saat URL cocok.

---

## 📋 Tabel Ringkasan Semua Pattern

| # | Pattern | Kategori | Status | Lokasi Utama |
|---|---|---|---|---|
| 1 | **Factory Method** | Creational | ✅ Eksplisit | Model `create()`, `UserFactory` |
| 2 | **Builder** | Creational | ✅ Eksplisit | Query Builder di semua Controller |
| 3 | **Singleton** | Creational | ✅ Framework | `Auth`, `app()`, Service Container |
| 4 | **Prototype** | Creational | ✅ Implisit | `Artikel::query()` clone |
| 5 | **Static Factory** | Creational | ✅ Eksplisit | `createToken()`, `Socialite::driver()` |
| 6 | **MVC** | Structural | ✅ Arsitektur | Seluruh proyek |
| 7 | **Facade** | Structural | ✅ Framework | `Auth`, `Hash`, `Storage`, `Log`, dll. |
| 8 | **Composite** | Structural | ✅ Eksplisit | Blade `@extends`, `@include`, Middleware stack |
| 9 | **Adapter** | Structural | ✅ Eksplisit | `Account extends Authenticatable` |
| 10 | **Decorator** | Structural | ✅ Eksplisit | Traits: `Notifiable`, `HasApiTokens`, `HasFactory` |
| 11 | **Proxy** | Structural | ✅ Eksplisit | `AdminMiddleware`, `auth` middleware |
| 12 | **Template Method** | Behavioral | ✅ Eksplisit | Blade inheritance, Seeder, Controller inheritance |
| 13 | **Strategy** | Behavioral | ✅ Eksplisit | 4 strategi autentikasi, `when()` query |
| 14 | **Chain of Responsibility** | Behavioral | ✅ Framework | Middleware pipeline di `Kernel.php` |
| 15 | **Observer** | Behavioral | ✅ Eksplisit | `View::composer()`, Eloquent events |
| 16 | **Command** | Behavioral | ✅ Framework | Seeders, Route definitions |

---

## 📊 Distribusi Pattern

```
Creational  ████████████████░░░░░░░░░░░░░░ 5 (31.25%)
Structural  ███████████████████░░░░░░░░░░░ 6 (37.50%)
Behavioral  ████████████████░░░░░░░░░░░░░░ 5 (31.25%)
```

---

## 🔍 Analisis & Catatan Tambahan

### Pattern yang Paling Dominan
1. **MVC** — Fondasi arsitektur seluruh proyek
2. **Facade** — Digunakan di hampir setiap file (10+ Facade berbeda)
3. **Builder** — Query Builder digunakan di semua controller
4. **Factory Method** — `Model::create()` digunakan di 8+ controller

### Temuan Menarik
- Proyek memiliki **4 strategi autentikasi** yang berbeda (Strategy Pattern yang kaya)
- Model `Account` bertindak sebagai **Adapter** dari tabel custom ke Auth system
- `AdminMiddleware` saat ini **belum memfilter** (hanya pass-through) — Proxy pattern belum optimal
- `View::composer` di `AppServiceProvider` adalah contoh Observer pattern yang eksplisit

### Rekomendasi Peningkatan

> [!WARNING]
> `AdminMiddleware` saat ini hanya meneruskan request tanpa pengecekan role admin. Ini berarti siapa saja bisa mengakses halaman admin.

```php
// Saat ini (tidak aman):
public function handle(Request $request, Closure $next)
{
    return $next($request);
}

// Seharusnya:
public function handle(Request $request, Closure $next)
{
    if (!auth()->check() || auth()->user()->role !== 'admin') {
        abort(403, 'Akses ditolak');
    }
    return $next($request);
}
```

> [!TIP]
> Anda bisa menambahkan **Repository Pattern** untuk memisahkan logika query dari controller, sehingga kode lebih bersih dan testable.

---

## Kesimpulan

Proyek FitLife.id secara keseluruhan sudah mengimplementasikan **16 design pattern** dengan baik. Mayoritas pattern berasal dari arsitektur Laravel itu sendiri (MVC, Facade, Chain of Responsibility, Singleton), sementara beberapa pattern diimplementasikan secara sadar oleh developer (Strategy untuk multi-auth, Adapter untuk model Account, View Composer sebagai Observer). Proyek ini menunjukkan pemahaman yang baik tentang pola-pola desain dalam konteks web development.
