@props([
    'trigger',
    'content',
    'position' => 'top', // default position
    'offset' => 8, // default offset in pixels
    'width' => 'w-48',
])

@php
    // Define position-specific classes
    $basePositionClasses = [
        'top' => 'bottom-full left-1/2 -translate-x-1/2',
        'bottom' => 'top-full left-1/2 -translate-x-1/2',
        'left' => 'right-full top-1/2 -translate-y-1/2',
        'right' => 'left-full top-1/2 -translate-y-1/2',
        'bottom-right' => 'top-full left-0',
        'bottom-left' => 'top-full right-0',
    ];

    // Define which CSS variable to use based on position
    $offsetVar = match ($position) {
        'top' => '--popup-margin-bottom',
        'bottom' => '--popup-margin-top',
        'left' => '--popup-margin-right',
        'right' => '--popup-margin-left',
        default => '--popup-margin-bottom',
    };
@endphp

<div class="popup-container relative" x-data="{ isOpen: false }">
    {{-- Trigger element --}}
    <div class="popup-trigger">
        {{ $trigger }}
    </div>

    {{-- Popup content --}}
    <div class="popup-content invisible opacity-0 {{ $width }} bg-white shadow-lg rounded-lg 
                absolute z-50 {{ $basePositionClasses[$position] ?? $basePositionClasses['top'] }} transition-all duration-300"
        style="{{ $offsetVar }}: {{ $offset }}px">
        <div class="p-2">
            {{ $content }}
        </div>
    </div>
</div>

<style>
    .popup-content {
        margin-top: var(--popup-margin-top, 0);
        margin-bottom: var(--popup-margin-bottom, 0);
        margin-left: var(--popup-margin-left, 0);
        margin-right: var(--popup-margin-right, 0);
    }
</style>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.togglePopup = function(element) {
                const content = element.closest('.popup-container').querySelector('.popup-content');
                content.classList.toggle('invisible');
                content.classList.toggle('opacity-0');
            }

            // Close popup when clicking outside
            document.addEventListener('click', function(event) {
                if (!event.target.closest('.popup-container')) {
                    document.querySelectorAll('.popup-content').forEach(popup => {
                        popup.classList.add('invisible', 'opacity-0');
                    });
                }
            });
        });
    </script>
@endpush
