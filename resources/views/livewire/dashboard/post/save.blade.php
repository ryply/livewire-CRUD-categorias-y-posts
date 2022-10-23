@slot('header')
    {{ __('Create Post') }}
@endslot

<div class="container">
    <x-jet-action-message on="created">
        <div class="box-action-message-green">
            {{ __('Created post.') }}
        </div>
    </x-jet-action-message>

    <x-jet-action-message on="updated">
        <div class="box-action-message-green">
            {{ __('Updated post.') }}
        </div>
    </x-jet-action-message>

    <x-jet-form-section submit="submit">

        <x-slot name="title">
            {{ __('Posts') }}
        </x-slot>

        <x-slot name="description">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Cupiditate autem fugiat sint sit libero possimus
            porro labore. Amet iusto, expedita libero corporis aperiam debitis mollitia ut blanditiis quo. Natus,
            voluptates.
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label value="{{ __('Title') }}" />{{ $title }}
                <x-jet-input-error for="title" class="mt-2" />
                <x-jet-input type="text" class="block w-full mt-1" wire:model.defer="title" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-jet-label value="{{ __('Date') }}" />
                <x-jet-input-error for="date" class="mt-2" />
                <x-jet-input type="date" class="block w-full mt-1" wire:model.defer="date" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-jet-label value="{{ __('Text') }}" />
                <x-jet-input-error for="text" class="mt-2" />
                <div wire:ignore>
                    <div id="cktext">{!! $text !!}</div>
                </div>
            </div>

            {{-- <div class="col-span-6 sm:col-span-4">
                <x-jet-label value="{{ __('Text') }}" />
                <x-jet-input-error for="text" class="mt-2" />
                <textarea class="block w-full" wire:model="text"></textarea>
            </div> --}}

            <div class="col-span-6 sm:col-span-4">
                <x-jet-label value="{{ __('Description') }}" />
                <x-jet-input-error for="description" class="mt-2" />
                <div wire:ignore>
                    <div id="ckdescription">{!! $description !!}</div>
                </div>
            </div>

            {{-- <div class="col-span-6 sm:col-span-4">
                <x-jet-label value="{{ __('Description') }}" />
                <x-jet-input-error for="description" class="mt-2" />
                <textarea class="block w-full" wire:model="description"></textarea>
            </div> --}}

            <div class="col-span-6 sm:col-span-4">
                <x-jet-label value="{{ __('Posted') }}" />
                <x-jet-input-error for="posted" class="mt-2" />
                <select class="block w-full" wire:model.defer="posted">
                    <option value=""></option>
                    <option value="not">No</option>
                    <option value="yes">Si</option>
                </select>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-jet-label value="{{ __('Type') }}" />
                <x-jet-input-error for="type" class="mt-2" />
                <select class="block w-full" wire:model.defer="type">
                    <option value=""></option>
                    <option value="adverd">Adverd</option>
                    <option value="post">Post</option>
                    <option value="course">Course</option>
                    <option value="movie">Movie</option>
                </select>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-jet-label value="{{ __('Categories') }}" />
                <x-jet-input-error for="category_id" class="mt-2" />
                <select class="block w-full" wire:model.defer="category_id">
                    <option value=""></option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-jet-label value="{{ __('Image') }}" />
                <x-jet-input type="file" wire:model="image" />
                <x-jet-input-error for="image" class="mt-2" />

                @if ($post && $post->image)
                    <img class="w-40 mt-4" src="{{ $post->getImageUrl() }}" alt="Imagen del post">
                @endif
            </div>

            <x-slot name="actions">
                <x-jet-button class="mt-4" type="submit">Enviar</x-jet-button>
            </x-slot>
        </x-slot>

    </x-jet-form-section>
</div>

<script src="{{ asset('js/ckEditor/ckeditor.js') }}"></script>

<script>
    // comunicacion ckEditor a propiedad
    document.addEventListener('livewire:load', function() {
        let editorText = ClassicEditor.create(document.querySelector('#cktext')).then(
            editorText => {
                editorText.model.document.on('change:data', () => {
                    @this.text = editorText.getData();
                });
            }
        );

        let editorDescription = ClassicEditor.create(document.querySelector('#ckdescription')).then(
            editorDescription => {
                editorDescription.model.document.on('change:data', () => {
                    @this.description = editorDescription.getData();
                });
            }
        );

        // comunicacion de la propiedad a ckEditor
        Livewire.hook('message.processed', (message, component) => {
            if (message.updateQueue[0].name == "text")
                ckeditor.setData(@this.text)

            if (message.updateQueue[0].name == "description")
                ckeditor.setData(@this.description)
        })
    });

</script>
