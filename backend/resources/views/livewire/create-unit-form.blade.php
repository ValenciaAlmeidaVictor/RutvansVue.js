<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="{{ $updateMode ? 'update' : 'store' }}">
        <div class="form-group">
            <label for="plate">Plate</label>
            <input type="text" id="plate" wire:model="plate" class="form-control" placeholder="Plate">
            @error('plate') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="capacitance">Capacitance</label>
            <input type="text" id="capacitance" wire:model="capacitance" class="form-control" placeholder="Capacitance">
            @error('capacitance') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="brand">Brand</label>
            <input type="text" id="brand" wire:model="brand" class="form-control" placeholder="Brand">
            @error('brand') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="model">Model</label>
            <input type="text" id="model" wire:model="model" class="form-control" placeholder="Model">
            @error('model') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="year">Year</label>
            <input type="number" id="year" wire:model="year" class="form-control" placeholder="Year">
            @error('year') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Campo de imagen -->
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" id="image" wire:model="image" class="form-control">
            @error('image') <span class="text-danger">{{ $message }}</span> @enderror

            <!-- Previsualización de la imagen cargada -->
            @if($image)
                <div class="mt-2">
                    <img src="{{ $image->temporaryUrl() }}" alt="Image Preview" class="img-thumbnail" width="100">
                </div>
            @elseif($image && $updateMode && $unit->image)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $unit->image) }}" alt="Unit Image" class="img-thumbnail" width="100">
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
            {{ $updateMode ? 'Update' : 'Save' }}
        </button>
        @if($updateMode)
            <button type="button" wire:click="cancelEdit" class="btn btn-secondary">Cancel</button>
        @endif
    </form>

    <div wire:loading wire:target="image">
        <p>Uploading image...</p>
    </div>
</div>
