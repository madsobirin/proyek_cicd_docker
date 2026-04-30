<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;


class MenuController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status'); // Mengambil parameter ?status=Normal

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

        return view('pages.menu', [
            'title' => $status ? "Rekomendasi Menu: $status" : "Menu Sehat Premium",
            'menus' => $menus,
            'status_aktif' => $status
        ]);
    }


    public function showDetail($id)
    {
        $title = "Detail Menu";
        $menu = Menu::findOrFail($id);

        $menu->increment('dibaca');
        return view('pages.menu-detail', compact('menu', 'title'));
    }
}
