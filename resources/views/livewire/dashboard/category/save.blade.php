@slot('header')
{{ __('Create Category') }}
@endslot

<div class="container">
    {{-- on="", recibe los eventos que se emiten desde el componente, mediante emit() --}}
    <x-jet-action-message on="created">
        <div class="box-action-message-green">
            {{ __('Created category.') }}
        </div>
    </x-jet-action-message>

    <x-jet-action-message on="updated">
        <div class="box-action-message-green">
            {{ __('Updated category.') }}
        </div>
    </x-jet-action-message>

    <x-jet-form-section submit="submit">

        <x-slot name="title">
            {{ __('Categories') }}
        </x-slot>

        <x-slot name="description">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Cupiditate autem fugiat sint sit libero possimus porro labore. Amet iusto, expedita libero corporis aperiam debitis mollitia ut blanditiis quo. Natus, voluptates.
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label value="{{ __('Title') }}" />
                <x-jet-input type="text" class="mt-1 block w-full" wire:model="title" />
                <x-jet-input-error for="title" class="mt-2" />

            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-jet-label value="{{ __('Text') }}" />
                <x-jet-input type="text" class="mt-1 block w-full" wire:model="text" />
                <x-jet-input-error for="text" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-jet-label value="{{ __('Image') }}" />
                <x-jet-input type="file" wire:model="image" />
                <x-jet-input-error for="image" class="mt-2" />

                @if ($category && $category->image)
                    <img class="w-40 mt-4" src="{{ $category->getImageUrl() }}" alt="Imagen de la categoría">
                @endif
            </div>

            <x-slot name="actions">
                <x-jet-button class="mt-4" type="submit">Enviar</x-jet-button>
            </x-slot>
        </x-slot>

    </x-jet-form-section>
</div>
