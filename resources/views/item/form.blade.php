<div>
    <label for="title">Title</label>
    <input type="text" name="title" autocomplete="off" value="{{ old('title') ?? $item->title }}">
    @error('title') <p>{{ $message }}</p> @enderror
</div>

<div>
    <label for="type">Type</label>
    <input type="text" name="type" autocomplete="off" value="{{ old('type') ?? $item->type }}">
    @error('type') <p>{{ $message }}</p> @enderror
</div>

<div>
    <label for="owner[badge_number]">Owner</label>
    <input type="text" name="owner[badge_number]" id="badge_number" autocomplete="off" value="{{ old('owner[badge_number]') }}">
    @error('owner[badge_number]') <p>{{ $message }}</p> @enderror
</div>

<div>
    <label for="Source">Source</label>
    <input type="text" name="source" autocomplete="off" value="{{ old('source') ?? $item->source }}">
    @error('source') <p>{{ $message }}</p> @enderror
</div>

<div>
    <label for="Source Date">Source Date</label>
    <input type="date" name="source_date" autocomplete="off" value="{{ old('source_date') ?? $item->source_date }}">
    @error('source_date') <p>{{ $message }}</p> @enderror
</div>

<div>
    <label for="Location">Location</label>
    <input type="text" name="location" autocomplete="off" value="{{ old('location') ?? $item->location }}">
    @error('location') <p>{{ $message }}</p> @enderror
</div>

<div>
    <label for="description">Description</label>
    <textarea name="description" cols="30" rows="10">{{ old('description') ?? $item->description }}</textarea>
    @error('description') <p>{{ $message }}</p> @enderror
</div>

<div>
    <label for="keywords">Keywords</label>
    <input type="text" name="keywords" autocomplete="off" value="{{ old('keywords') ?? $item->keywords }}">
    @error('keywords') <p>{{ $message }}</p> @enderror
</div>

<div>
    <label for="barcode">Barcode</label>
    <input type="text" name="barcode" id="barcode-input" autocomplete="off" value="{{ old('barcode') ?? $item->barcode }}">
    @error('barcode') <p>{{ $message }}</p> @enderror
</div>

@csrf