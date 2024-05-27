<?php

namespace App\Http\Controllers;

use App\Models\Spot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SpotController extends Controller
{
    public function index()
    {
        $spots = Spot::all();
        return view('admin.spot.index', ['spots' => $spots]);
    }

    public function create()
    {
        return view('admin.spot.add');
    }

    public function store(Request $request)
    {
        // validasi form
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "location" => "string",
            "description" => "required|string|max:65535",
            "address" => "required|string",
            "image" => "required|mimes:jpg,jpeg,png|max:5120",
        ]);

        // menyimpan file image ke dalam storage
        $saveImage['image'] = Storage::putFile('public/image', $request->file('image'));

        // save to db
        Spot::create([
            'name' => $validated['name'],
            'location' => $validated['location'],
            'description' => $validated['description'],
            'address' => $validated['address'],
            'image' => $saveImage['image'],
        ]);

        return redirect('/admin/spot');
    }

    public function edit($id)
    {
        $spot = Spot::findOrFail($id);
        return view('admin.spot.edit', ['spot' => $spot]);
    }

    public function update(Request $request, string $id)
    {
        $spot = Spot::findOrFail($id);

        $validated = $request->validate([
            'name' => 'string|max:255',
            'location' => 'string',
            'description' => 'string|max:65535',
            'address' => 'string',
            'image' => 'mimes:jpg,jpeg,png|max:5120',
        ]);

        // Cek apakah ada unggahan gambar baru
        if ($request->hasFile('image')) {
            // Hapus foto yang lama
            Storage::delete($spot->image);

            // Simpan foto yang baru
            $newImage = ['image' => Storage::putFile('public/image', $request->file('image'))];
        } else {
            // Jika tidak ada gambar baru, gunakan gambar yang sudah ada
            $newImage = ['image' => $spot->image];
        }
        Spot::where('id', $id)->update([
            "name" => $validated["name"],
            "location" => $validated["location"],
            "description" => $validated["description"],
            "address" => $validated["address"],
            'image' => $newImage['image']
        ]);

        return redirect('/admin/spot');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Spot::destroy($id);
        return redirect('/admin/spot');
    }
}
