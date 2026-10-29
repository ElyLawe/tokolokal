<div class="mb-3">
    <label class="form-label">Nama Product</label>
    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name ?? '') }}">
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Kategori</label>
    <input type="text" name="category" class="form-control" value="{{ old('category', $product->category ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Deskripsi</label>
    <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description ?? '') }}</textarea>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price ?? '') }}">
            @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label">Stock</label>
            <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', $product->stock ?? 0) }}">
            @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Image Product (File)</label>
    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg,image/webp">
    <small class="text-muted">Format: JPG, JPEG, PNG, WEBP (Maksimal 2MB).</small>
    @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

{{-- Preview Gambar jika data product dan file gambarnya sudah ada --}}
@isset($product)
    @if($product->image)
        <div class="mb-3">
            <label class="form-label d-block">Gambar Saat Ini:</label>
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-thumbnail" style="width: 120px; height: 120px; object-fit: cover;">
        </div>
    @endif
@endisset

<div class="form-check mb-3">
    <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_active">Product Aktif</label>
</div>