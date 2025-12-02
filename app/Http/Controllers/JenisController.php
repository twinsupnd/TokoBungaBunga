<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
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
        if (! \Illuminate\Support\Facades\Auth::check() || ! in_array(\Illuminate\Support\Facades\Auth::user()->role, ['admin', 'manager'])) {
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
        if (! \Illuminate\Support\Facades\Auth::check() || ! in_array(\Illuminate\Support\Facades\Auth::user()->role, ['admin', 'manager'])) {
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

        // Normalize price for storage (remove thousand separators/currency)
        if (array_key_exists('price', $data) && $data['price'] !== null) {
            $clean = preg_replace('/[^0-9]/', '', $data['price']);
            $data['price'] = $clean === '' ? null : $clean;
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . preg_replace('/[^a-z0-9\.\-]/i', '', $file->getClientOriginalName());
            $path = Storage::disk('public')->putFileAs('products', $file, $filename);
            $data['image'] = $path;
        }

        $jenis = Jenis::create($data);

        // Refresh model to get values and timestamps
        $jenis->refresh();

        if ($request->wantsJson() || $request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => true,
                'item' => [
                    'slug' => $jenis->slug,
                    'name' => $jenis->name,
                    'price' => $jenis->price,
                    'stock' => $jenis->stock,
                    'description' => $jenis->description,
                    'image_url' => $jenis->image ? Storage::disk('public')->url($jenis->image) : null,
                    'updated_at' => $jenis->updated_at ? strtotime($jenis->updated_at) : time(),
                ],
            ]);
        }

        return redirect()->route('dashboard.jenis.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Admin view for a single Jenis (product)
     */
    public function adminShow(Jenis $jenis)
    {
        if (! \Illuminate\Support\Facades\Auth::check() || ! in_array(\Illuminate\Support\Facades\Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }
        return view('dashboard.jenis.show', compact('jenis'));
    }

    /**
     * Display the specified resource (public view).
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
     * Public catalog page for customers to view all products.
     */
    public function publicCatalog(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $query = Jenis::query();

        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        $products = $query->orderBy('id')->get();

        return view('public-catalog', compact('products'))->with('q', $q);
    }

    /**
     * Return last updated timestamp for products (used by client polling).
     */
    public function publicCatalogLastUpdated()
    {
        $last = Jenis::max('updated_at');
        $ts = $last ? strtotime($last) : 0;
        return response()->json(['last' => $ts]);
    }

    /**
     * Catalog preview page for admin to see customer view.
     */
    public function catalog()
    {
        if (! \Illuminate\Support\Facades\Auth::check() || ! in_array(\Illuminate\Support\Facades\Auth::user()->role, ['admin', 'manager'])) {
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
        if (! \Illuminate\Support\Facades\Auth::check() || ! in_array(\Illuminate\Support\Facades\Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }

        return view('dashboard.jenis.edit', compact('jenis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJenisRequest $request, Jenis $jenis)
    {
        if (! \Illuminate\Support\Facades\Auth::check() || ! in_array(\Illuminate\Support\Facades\Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }

        $data = $request->validated();

        // Normalize price: remove any non-digit characters (commas, dots, currency symbols)
        if (array_key_exists('price', $data) && $data['price'] !== null) {
            $clean = preg_replace('/[^0-9]/', '', $data['price']);
            $data['price'] = $clean === '' ? null : $clean;
        }

        // Keep slug in sync with the name so edit results match expectations
        if (array_key_exists('name', $data) && $data['name']) {
            $data['slug'] = Str::slug($data['name']);
        }

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($jenis->image && Storage::disk('public')->exists($jenis->image)) {
                Storage::disk('public')->delete($jenis->image);
            }

            $file = $request->file('image');
            $filename = time() . '_' . preg_replace('/[^a-z0-9\.\-]/i', '', $file->getClientOriginalName());
            $path = Storage::disk('public')->putFileAs('products', $file, $filename);
            $data['image'] = $path;
        }

        $jenis->update($data);

        // Refresh model to get latest values (including updated_at)
        $jenis->refresh();

        // If AJAX request, return JSON with updated fields for client-side update
        if ($request->wantsJson() || $request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => true,
                'item' => [
                    'slug' => $jenis->slug,
                    'name' => $jenis->name,
                    'price' => $jenis->price,
                    'stock' => $jenis->stock,
                    'description' => $jenis->description,
                    'image_url' => $jenis->image ? Storage::disk('public')->url($jenis->image) : null,
                    'updated_at' => $jenis->updated_at ? strtotime($jenis->updated_at) : time(),
                ],
            ]);
        }

        return redirect()->route('dashboard.jenis.index')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jenis $jenis)
    {
        if (! \Illuminate\Support\Facades\Auth::check() || ! in_array(\Illuminate\Support\Facades\Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }

        // Delete image if exists
        if ($jenis->image && Storage::disk('public')->exists($jenis->image)) {
            Storage::disk('public')->delete($jenis->image);
        }

        $jenis->delete();

        return redirect()->route('dashboard.jenis.index')->with('success', 'Produk berhasil dihapus.');
    }
}
