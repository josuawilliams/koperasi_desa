<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Products;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->search;
        /** @var User $user */
        $user = Auth::user();

        $products = Products::query()
            ->leftJoin('users', 'products.user_id', '=', 'users.id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->select([
                'products.id',
                'products.user_id',
                'products.category_id',
                'products.name',
                'products.slug',
                'products.description',
                'products.price',
                'products.stock',
                'products.image',
                'products.is_visible',
                'users.name as user',
                'categories.name as category',
            ])
            ->when(!$user->hasRole(['super_admin', 'super admin']), function ($query) use ($user) {
                $query->where('products.user_id', $user->id);
            })
            ->when($search, function ($query) use ($search) {
                if ($search) {
                    $query->where('products.name', 'LIKE', "%{$search}%");
                    // ->orWhere('content', 'like', "%{$search}%");
                }
            })
            ->latest('products.created_at')->paginate(3)->withQueryString();

        return view('dashboard', compact('products'));
    }


    public function create()
    {
        $category = Categories::all();
        return view('product.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required',
            'slug' => 'required',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'required|mimes:jpeg,jpg,png,gif|max:12000'
        ], [
            'category_id.required' => 'Kategori wajib dipilih',
            'category_id.exists' => 'Kategori tidak ditemukan',

            'name.required' => 'Nama produk tidak boleh kosong',

            'slug.required' => 'Slug tidak boleh kosong',

            'description.required' => 'Deskripsi tidak boleh kosong',

            'price.required' => 'Harga tidak boleh kosong',
            'price.numeric' => 'Harga harus berupa angka',
            'price.min' => 'Harga tidak boleh kurang dari 0',

            'stock.required' => 'Stok tidak boleh kosong',
            'stock.integer' => 'Stok harus berupa angka bulat',
            'stock.min' => 'Stok tidak boleh kurang dari 0',

            'image.required' => 'Gambar Wajib Diisi',
            'image.mimes' => 'Gambar Tidak Sesuai Bentuk File',
            'image.max' => 'File Terlalu Besar'

        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time() . "-" . $image->getClientOriginalName();

            $destination_path = public_path(getenv("CUSTOM_IMAGES_LOCATION"));
            $image->move($destination_path, $image_name);
        }


        $data = [
            'category_id' => $request->category_id,
            'name' => $request->name,
            'user_id' => $user->id,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'image' => isset($image_name) ? $image_name : null,
            'price' => $request->price,
            'stock' => $request->stock,
            'is_visible' => $request->boolean('is_visible'),
        ];

        Products::create($data);
        return redirect()->route('product.index')->with('success', 'Data berhasil ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $productForPolicy = Products::findOrFail($id);
        Gate::authorize('edit', $productForPolicy);

        $product = Products::query()
            ->leftJoin('users', 'products.user_id', '=', 'users.id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->select([
                'products.id',
                'products.user_id',
                'products.category_id',
                'products.name',
                'products.slug',
                'products.description',
                'products.price',
                'products.stock',
                'products.image',
                'products.is_visible',
                'products.created_at',
                'products.updated_at',
                'users.name as user',
                'categories.name as category',
            ])
            ->where('products.id', $id)
            ->firstOrFail();

        return view('product.detail', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Products::find($id);
        Gate::authorize('edit', $product);
        $category = Categories::all();
        return view('product.edit', compact('product', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $product = Products::findOrFail($id);
        $image_name = $product->image;
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required',
            'slug' => 'required',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ], [
            'category_id.required' => 'Kategori wajib dipilih',
            'category_id.exists' => 'Kategori tidak ditemukan',

            'name.required' => 'Nama produk tidak boleh kosong',

            'slug.required' => 'Slug tidak boleh kosong',

            'description.required' => 'Deskripsi tidak boleh kosong',

            'price.required' => 'Harga tidak boleh kosong',
            'price.numeric' => 'Harga harus berupa angka',
            'price.min' => 'Harga tidak boleh kurang dari 0',

            'stock.required' => 'Stok tidak boleh kosong',
            'stock.integer' => 'Stok harus berupa angka bulat',
            'stock.min' => 'Stok tidak boleh kurang dari 0',

        ]);

        if ($request->hasFile('image')) {
            $oldFile = public_path(
                getenv("CUSTOM_IMAGES_LOCATION") . "/" . $product->image
            );
            if ($product->image && file_exists($oldFile)) {
                unlink($oldFile);
            }
            $image = $request->file('image');
            $image_name = time() . "-" . $image->getClientOriginalName();

            $destination_path = public_path(getenv("CUSTOM_IMAGES_LOCATION"));
            $image->move($destination_path, $image_name);
        }


        $data = [
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'image' => isset($image_name) ? $image_name : $request->image,
            'price' => $request->price,
            'stock' => $request->stock,
            'is_visible' => $request->boolean('is_visible'),
        ];

        Products::where('id', $id)->update($data);
        return redirect()->route('product.index')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Products::where('id', $id)->delete();
        return redirect()->route('product.index')->with('success', 'Data berhasil dihapus');
    }
}
