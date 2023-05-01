<div class="modal-dialog modal-lg">
    <form wire:submit.prevent="create_alert">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('bap.create_alert') }}:{{ $symbol->title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('bap.close') }}"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">

                        <div class="mb-3">
                            <label class="form-label" for="price_less_than">{{ __('bap.price_less_than') }}</label>
                            <input type="text" wire:model="price_less_than" class="form-control @error('price_less_than') is-invalid @enderror" name="price_less_than" placeholder="{{ __('bap.price_less_than') }}">
                            @error('price_less_than')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="price_more_than">{{ __('bap.price_more_than') }}</label>
                            <input type="text" wire:model="price_more_than" class="form-control @error('price_more_than') is-invalid @enderror" name="price_more_than" placeholder="{{ __('bap.price_more_than') }}">
                            @error('price_more_than')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="change_percent">{{ __('bap.change_percent') }}</label>
                            <input type="text" wire:model="change_percent" class="form-control @error('change_percent') is-invalid @enderror" name="change_percent" placeholder="{{ __('bap.change_percent') }}">
                            @error('change_percent')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('bap.close') }}</button>
                <button type="submit" class="btn btn-primary">{{ __('bap.create_alert') }}</button>
            </div>
        </div>
    </form>
</div>

