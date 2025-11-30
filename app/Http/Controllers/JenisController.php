<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\StoreJenisRequest;
use App\Http\Requests\UpdateJenisRequest;

class JenisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Admin listing for dashboard: show all jenis and form to create new
        if (! \Illuminate\Support\Facades\Auth::check() || ! in_array(\Illuminate\Support\Facades\Auth::user()->role, ['admin','manager'])) {
            abort(403);
        }

        $items = Jenis::orderBy('id', 'desc')->get();
        return view('dashboard.jenis.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Not used - we render a create form in dashboard.jenis.index
        return redirect()->route('dashboard.jenis.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJenisRequest $request)
    {
        // Allow admin/manager to create new Jenis (product)
        if (! \Illuminate\Support\Facades\Auth::check() || ! in_array(\Illuminate\Support\Facades\Auth::user()->role, ['admin','manager'])) {
            abort(403);
        }

        $data = $request->validated();

        // Basic fallback validation if request class not used
        if (empty($data)) {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'nullable|string|max:100',
                'description' => 'nullable|string',
                'image' => 'nullable|file|image|max:2048',
            ]);
        }

        $data['slug'] = Str::slug($data['name'] ?? 'jenis-' . time());

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $dir = public_path('images');
            if (! is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            $filename = time() . '_' . preg_replace('/[^a-z0-9\.\-]/i', '_', $file->getClientOriginalName());
            $file->move($dir, $filename);
            $data['image'] = $filename;
        }

        Jenis::create($data);

        return redirect()->route('dashboard.jenis.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Admin view for a single Jenis (product)
     */
    public function adminShow(Jenis $jenis)
    {
        if (! \Illuminate\Support\Facades\Auth::check() || ! in_array(\Illuminate\Support\Facades\Auth::user()->role, ['admin','manager'])) {
            abort(403);
        }
        // adminShow now uses route-model-binding (Jenis resolved by slug)
        $item = $jenis;
        return view('dashboard.jenis.show', compact('item'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Jenis $jenis)
    {
        return view('jenis.show', compact('jenis'));
    }

    /**
     * Landing page showing all products.
     */
    public function landing()
    {
        $products = Jenis::orderBy('id')->get();
        return view('welcome', compact('products'));
    }

    /**
     * Catalog preview page for admin to see customer view.
     */
    public function catalog()
    {
        if (! \Illuminate\Support\Facades\Auth::check() || ! in_array(\Illuminate\Support\Facades\Auth::user()->role, ['admin','manager'])) {
            abort(403);
        }

        $products = Jenis::orderBy('id')->get();
        return view('catalog', compact('products'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jenis $jenis)
    {
        if (! \Illuminate\Support\Facades\Auth::check() || ! in_array(\Illuminate\Support\Facades\Auth::user()->role, ['admin','manager'])) {
            abort(403);
        }

        return view('dashboard.jenis.edit', compact('jenis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJenisRequest $request, Jenis $jenis)
    {
        if (! \Illuminate\Support\Facades\Auth::check() || ! in_array(\Illuminate\Support\Facades\Auth::user()->role, ['admin','manager'])) {
            abort(403);
        }

        $data = $request->validated();

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($jenis->image && file_exists(public_path('images/' . $jenis->image))) {
                unlink(public_path('images/' . $jenis->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . preg_replace('/[^a-z0-9\.\-]/i', '_', $file->getClientOriginalName());
            $file->move(public_path('images'), $filename);
            $data['image'] = $filename;
        }

        $jenis->update($data);

        return redirect()->route('dashboard.jenis.index')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jenis $jenis)
    {
        if (! \Illuminate\Support\Facades\Auth::check() || ! in_array(\Illuminate\Support\Facades\Auth::user()->role, ['admin','manager'])) {
            abort(403);
        }

        // Delete image if exists
        if ($jenis->image && file_exists(public_path('images/' . $jenis->image))) {
            unlink(public_path('images/' . $jenis->image));
        }

        $jenis->delete();

        return redirect()->route('dashboard.jenis.index')->with('success', 'Produk berhasil dihapus.');
    }
}
