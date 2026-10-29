<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('products.index', compact('products'));
    }
    public function create()
    {
        return view('products.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', 
            'is_active' => 'nullable|boolean',
        ]);
        $file = $request->file('image');
        if ($file) {
            $original = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $ext = strtolower($file->getClientOriginalExtension());
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-_]/', '', $original) . '.' . $ext;
            $folder = 'products';
            $path = $folder . '/' . $filename;

            $manager = new ImageManager(Driver::class);
            $image = $manager->decodePath($file->getRealPath())->cover(800, 800);

            // Encode sesuai ekstensi (png atau jpg)[cite: 4]
            if ($ext == 'png') {
                $encoded = $image->encodeUsingFileExtension('png', quality: 90);
            } else {
                $encoded = $image->encodeUsingFileExtension('jpg', quality: 85);
            }

            // Simpan ke disk public[cite: 4]
            Storage::disk('public')->put($path, $encoded->toString());

            $validated['image'] = $path;
        }

        $validated['is_active'] = $request->has('is_active');

        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail product.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Menampilkan form edit product.
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Memperbarui product.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $file = $request->file('image');

        if ($file) {
            // Hapus gambar lama jika ada di storage
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $original = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $ext = strtolower($file->getClientOriginalExtension());
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-_]/', '', $original) . '.' . $ext;
            $folder = 'products';
            $path = $folder . '/' . $filename;

            $manager = new ImageManager(Driver::class);
            $image = $manager->decodePath($file->getRealPath())->cover(800, 800);

            if ($ext == 'png') {
                $encoded = $image->encodeUsingFileExtension('png', quality: 90);
            } else {
                $encoded = $image->encodeUsingFileExtension('jpg', quality: 85);
            }

            Storage::disk('public')->put($path, $encoded->toString());

            $validated['image'] = $path;
        } else {
            // Jika tidak upload gambar baru, abaikan field image agar data lama tidak tertimpa null
            unset($validated['image']);
        }

        $validated['is_active'] = $request->has('is_active');

        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product berhasil diperbarui.');
    }

    /**
     * Menonaktifkan product.
     *
     * Product tidak dihapus dari database karena
     * mungkin sudah digunakan pada transaction_details.
     */
    public function destroy(Product $product)
    {
        $product->update([
            'is_active' => false,
        ]);

        return redirect()
            ->route('products.index')
            ->with(
                'success',
                'Product berhasil dinonaktifkan.'
            );
    }
}