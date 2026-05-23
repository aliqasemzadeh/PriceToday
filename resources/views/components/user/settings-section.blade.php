@props([
    'heading',
    'subheading',
])

<div {{ $attributes->class(['flex flex-col gap-4 lg:flex-row lg:gap-6']) }}>
    <div class="w-full shrink-0 lg:w-80">
        <flux:heading size="lg">{{ $heading }}</flux:heading>
        <flux:subheading>{{ $subheading }}</flux:subheading>
    </div>

    <div class="flex-1 space-y-6">
        {{ $slot }}
    </div>
</div>
