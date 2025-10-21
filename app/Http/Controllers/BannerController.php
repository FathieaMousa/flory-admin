<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::latest()->paginate(10);
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {

        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'required|image|max:2048',
            'link'  => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $data['image'] = $request->file('image')->store('banners', 'public');
        Banner::create($data);

        return redirect()->route('banners.index')->with('success', 'Banner added successfully ✅');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
            'link'  => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($banner->image) Storage::disk('public')->delete($banner->image);
            $data['image'] = $request->file('image')->store('banners', 'public');
        }

        $banner->update($data);
        return redirect()->route('banners.index')->with('success', 'Banner updated successfully ✏️');
    }

    public function destroy(Banner $banner)
    {
        if ($banner->image) Storage::disk('public')->delete($banner->image);
        $banner->delete();

        return redirect()->route('banners.index')->with('success', 'Banner deleted 🗑️');
    }
}
