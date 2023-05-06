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
                            <label class="form-label" for="less_than">{{ __('bap.less_than') }}</label>
                            <div class="input-group mb-2">
                                <input type="text" wire:model="less_than" class="form-control @error('less_than') is-invalid @enderror" name="less_than" placeholder="{{ __('bap.less_than') }}">
                                <button class="btn" type="button">-10%</button>
                                <button class="btn" type="button">+10%</button>
                            </div>

                            @error('less_than')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="more_than">{{ __('bap.more_than') }}</label>

                            <div class="input-group mb-2">
                                <input type="text" wire:model="more_than" class="form-control @error('more_than') is-invalid @enderror" name="more_than" placeholder="{{ __('bap.more_than') }}">
                                <button class="btn" type="button">-10%</button>
                                <button class="btn" type="button">+10%</button>
                            </div>

                            @error('more_than')
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

                        <div class="mb-3">
                            <label class="form-label" for="display_unit">{{ __('bap.display_unit') }}</label>
                            <select wire:model="display_unit" class="form-control @error('display_unit') is-invalid @enderror" name="display_unit" placeholder="{{ __('bap.display_unit') }}">
                                <option></option>
                                <option value="USDT">{{ __('bap.units.USDT') }}</option>
                                <option value="IRR">{{ __('bap.units.IRR') }}</option>
                            </select>
                            @error('display_unit')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label" for="hour">{{ __('bap.hour') }}</label>
                            <input type="number" min="0" max="23" wire:model="hour" class="form-control @error('hour') is-invalid @enderror" name="hour" placeholder="{{ __('bap.hour') }}">
                            @error('hour')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label" for="minute">{{ __('bap.minute') }}</label>
                            <input type="number" min="0" max="59" wire:model="minute" class="form-control @error('minute') is-invalid @enderror" name="minute" placeholder="{{ __('bap.minute') }}">
                            @error('minute')
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

