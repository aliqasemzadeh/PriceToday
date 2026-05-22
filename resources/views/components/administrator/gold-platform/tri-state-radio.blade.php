@props([
    'model',
    'label',
    'icon' => 'question-mark-circle',
])

<flux:radio.group variant="buttons" class="w-full *:flex-1" wire:model="{{ $model }}" :label="$label">
    <flux:radio value="1" icon="check">{{ __('price-today.gold_platforms.yes') }}</flux:radio>
    <flux:radio value="0" icon="x-mark">{{ __('price-today.gold_platforms.no') }}</flux:radio>
    <flux:radio value="" :icon="$icon">{{ __('price-today.gold_platforms.unknown') }}</flux:radio>
</flux:radio.group>
