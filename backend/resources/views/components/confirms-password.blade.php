@props(['title' => __('Confirmar contraseña'), 'content' => __('Para su seguridad, por favor confirme su contraseña para continuar.'), 'button' => __('Confirmar')])

@php
    $confirmableId = md5($attributes->wire('then'));
@endphp

<span
    {{ $attributes->wire('then') }}
    x-data
    x-ref="span"
    x-on:click="$wire.startConfirmingPassword('{{ $confirmableId }}')"
    x-on:password-confirmed.window="setTimeout(() => $event.detail.id === '{{ $confirmableId }}' && $refs.span.dispatchEvent(new CustomEvent('then', { bubbles: false })), 250);"
>
    {{ $slot }}
</span>

@once
<x-dialog-modal wire:model.live="confirmingPassword">
    <x-slot name="title">
        <h5 class="modal-title">{{ $title }}</h5>
    </x-slot>

    <x-slot name="content">
        <p>{{ $content }}</p>

        <div class="mt-4" x-data="{}" x-on:confirming-password.window="setTimeout(() => $refs.confirmable_password.focus(), 250)">
            <div class="form-group">
                <x-input type="password" class="form-control" placeholder="{{ __('Contraseña') }}" autocomplete="current-password"
                         x-ref="confirmable_password"
                         wire:model="confirmablePassword"
                         wire:keydown.enter="confirmPassword" />
                <x-input-error for="confirmable_password" class="text-danger mt-2" />
            </div>
        </div>
    </x-slot>

    <x-slot name="footer">
        <button type="button" class="btn btn-secondary" wire:click="stopConfirmingPassword" wire:loading.attr="disabled">
            {{ __('Cancelar') }}
        </button>

        <button type="button" class="btn btn-primary ms-3" dusk="confirm-password-button" wire:click="confirmPassword" wire:loading.attr="disabled">
            {{ $button }}
        </button>
    </x-slot>
</x-dialog-modal>
@endonce
