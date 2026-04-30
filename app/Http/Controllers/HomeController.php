<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Menu;
use App\Models\Perhitungan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $title = "Home";
        $slug = "home";
        $konten = "Selamat Datang di FitLife!";

        $featuredMenus = Menu::latest()->take(6)->get();
        $latestArticles = Artikel::latest()->take(4)->get();
        $heroHighlight = $latestArticles->first();

        return view('pages.home', compact(
            'title',
            'slug',
            'konten',
            'featuredMenus',
            'latestArticles',
            'heroHighlight'
        ));
    }

    public function kalkulator(Request $request)
    {
        $title = "Kalkulator";
        $slug  = "kalkulator";

        if ($request->isMethod('post')) {
            $request->validate([
                'gender' => 'required|string',
                'tinggi' => 'required|numeric|min:1',
                'berat'  => 'required|numeric|min:1',
            ]);

            $tinggi = (float) $request->tinggi;
            $berat  = (float) $request->berat;

            // Rumus BMI: $BMI = \frac{berat}{(tinggi/100)^2}$
            $bmi = $berat / pow(($tinggi / 100), 2);
            $bmiFormatted = number_format($bmi, 1);

            // Penentuan Label
            if ($bmi < 18.5) {
                $label = "Kurus";
                $color = "#00B5D8";
                $bg = "#00B5D815";
            } elseif ($bmi <= 24.9) {
                $label = "Normal";
                $color = "#26C281";
                $bg = "#26C28115";
            } elseif ($bmi <= 29.9) {
                $label = "Berlebih";
                $color = "#F4C542";
                $bg = "#F4C54215";
            } else {
                $label = "Obesitas";
                $color = "#E74C3C";
                $bg = "#E74C3C15";
            }

            // SIMPAN KE DATABASE
            if (auth()->check()) {
                Perhitungan::create([
                    'user_id' => auth()->id(),
                    'tinggi_badan' => $tinggi,
                    'berat_badan' => $berat,
                    'bmi' => $bmi,
                    'status' => $label,
                ]);
            }

            // AMBIL DATA REKOMENDASI UNTUK HALAMAN YANG SAMA
            $rekomendasiArtikel = Artikel::where('kategori', 'like', "%$label%")
                ->orWhere('judul', 'like', "%$label%")
                ->take(3)->get();

            $rekomendasiMenu = Menu::where('target_status', $label)
                ->latest()->take(3)->get();

            // Tampilan Hasil Card
            $hasil = '
        <div class="p-5 rounded-2xl text-center" style="background:' . $bg . ';">
            <div style="font-size:24px; font-weight:800; color:' . $color . ';">BMI: ' . $bmiFormatted . '</div>
            <div class="mt-2 mb-4">
                <span style="padding:6px 20px; border-radius:50px; background:' . $color . '; color:white; font-weight:700;">' . $label . '</span>
            </div>
            <p class="text-text-muted text-sm">Berdasarkan profil Anda, silakan cek rekomendasi menu dan artikel di bawah ini.</p>
        </div>';

            return redirect()->back()->with([
                'hasil' => $hasil,
                'artikel_terkait' => $rekomendasiArtikel,
                'rekomendasi_menu' => $rekomendasiMenu,
                'status_bmi' => $label
            ]);
        }

        return view('pages.kalkulator', compact('title', 'slug'));
    }

    public function HalamanProfile()
    {
        return view('profile');
    }
}
