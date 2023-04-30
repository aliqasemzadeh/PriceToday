<div class="modal-dialog">
    <form wire:submit.prevent="edit">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('bap.edit_symbol') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('bap.close') }}"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label" for="symbol">{{ __('bap.symbol') }}</label>
                    <input type="symbol" wire:model="symbol" class="form-control @error('symbol') is-invalid @enderror" name="symbol" placeholder="{{ __('bap.symbol') }}">
                    @error('symbol')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="title">{{ __('bap.title') }}</label>
                    <input type="text" wire:model="title" class="form-control @error('title') is-invalid @enderror" name="title" placeholder="{{ __('bap.title') }}">
                    @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="coingecko_id">{{ __('bap.coingecko_id') }}</label>
                    <input type="text" wire:model="coingecko_id" class="form-control @error('coingecko_id') is-invalid @enderror" name="coingecko_id" placeholder="{{ __('bap.coingecko_id') }}">
                    @error('coingecko_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="coingecko_number">{{ __('bap.coingecko_number') }}</label>
                    <input type="text" wire:model="coingecko_number" class="form-control @error('coingecko_number') is-invalid @enderror" name="coingecko_number" placeholder="{{ __('bap.coingecko_number') }}">
                    @error('coingecko_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label class="form-label" for="sort_order">{{ __('bap.sort_order') }}</label>
                    <input type="text" wire:model="sort_order" class="form-control @error('sort_order') is-invalid @enderror" name="sort_order" placeholder="{{ __('bap.sort_order') }}">
                    @error('sort_order')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('bap.close') }}</button>
                <button type="submit" class="btn btn-primary">{{ __('bap.edit') }}</button>
            </div>
        </div>
    </form>
</div>

