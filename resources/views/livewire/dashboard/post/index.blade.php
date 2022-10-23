@slot('header')
    {{ __('CRUD Posts') }}
@endslot


<x-card class="container">
    <x-jet-action-message on="deleted">
        <div class="box-action-message-red">
            {{ __('Deleted post.') }}
        </div>
    </x-jet-action-message>

    @slot('title')
        Listado
    @endslot

    <a class="mb-2 btn-secondary" href="{{ route('d-post-create') }}">Create post</a>

    {{-- Search --}}
    <div>
        <label for="default-search"
            class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-gray-300">Search</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input type="search" id="default-search"
                class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Id, Title, Description..." wire:model.debounce.500ms="search">
            <button type="submit"
                class="text-white absolute right-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
        </div>
    </div>
    {{-- Search --}}

    {{-- Rango de fechas --}}
    <div class="grid grid-cols-2 gap-4 mt-4">
        <div>
            <input type="date"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                wire:model="from" placeholder="Desde">
        </div>
        <div>
            <input type="date"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                wire:model="to" placeholder="Hasta">
        </div>
    </div>
    {{-- Rango de fechas --}}

    {{-- Selectores para los filtros, coincidencias exactas --}}
    <div class="flex gap-2 my-4">
        <select
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            wire:model="posted">
            <option value="">{{ __('Posted') }}</option>
            <option value="not">No</option>
            <option value="yes">Si</option>
        </select>

        <select
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            wire:model="type">
            <option value="">{{ __('Type') }}</option>
            <option value="adverd">Adverd</option>
            <option value="post">Post</option>
            <option value="course">Course</option>
            <option value="movie">Movie</option>
        </select>

        <select
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            wire:model="category_id">
            <option value="">{{ __('Categories') }}</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->title }}</option>
            @endforeach
        </select>
    </div>
    {{-- Selectores para los filtros --}}

    <table class="table w-full border">
        <thead class="text-left bg-gray-100">
            <tr class="border-b-2">
                @foreach ($columns as $key => $column)
                    <th class="p-2">
                        <button wire:click="sort('{{ $key }}')">
                            {{ $column }}
                            @if ($key == $sortColumn)
                                @if ($sortDirection == 'asc')
                                    &uarr;
                                @else
                                    &darr;
                                @endif
                            @endif
                        </button>
                    </th>
                @endforeach
                <th class="p-2">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($posts as $post)
                <tr class="border-b-2">
                    <td class="p-2">{{ $post->id }}</td>
                    <td class="p-2">{!! Str::limit($post->title, 10) !!}</td>
                    <td class="p-2">{{ $post->date->format('d-m-Y') }}</td>
                    <td class="p-2">{!! Str::limit($post->description, 10) !!}</td>
                    <td class="p-2">{{ $post->posted }}</td>
                    <td class="p-2">{{ $post->type }}</td>
                    <td class="p-2">{{ $post->category->title }}</td>
                    <td class="p-2">
                        <x-jet-nav-link href="{{ route('d-post-edit', $post) }}" class="mr-2">Editar</x-jet-nav-link>
                        <x-jet-danger-button wire:click="selectPostToDelete({{ $post }})">
                            Eliminar
                        </x-jet-danger-button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    {{ $posts->links() }}

    <x-jet-confirmation-modal wire:model="confirmingDeletePost">
        <x-slot name="title">
            {{ __('Delete Post') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to delete this post?.') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingDeletePost')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-3" wire:click="delete()" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>

</x-card>

<script>
    // Se ejecuta cuando todo el javascript se ha cargado
    window.onload = function() {

        // Javascript Hooks
        Livewire.hook('element.updated', (el, component) => {
            // Llamado después de que Livewire actualiza un elemento durante su ciclo de diferenciación de DOM después de un viaje de ida y vuelta a la red
            // console.log(component);
        });

        Livewire.hook('element.updating', (fromEl, toEl, component) => {
            // Llamado antes de que Livewire actualice un elemento durante su ciclo de diferenciación de DOM después de un viaje de ida y vuelta a la red
            // console.log(fromEl);
        });

        Livewire.hook('element.removed', (el, component) => {
            // Llamado después de que Livewire elimina un elemento durante su ciclo de diferenciación de DOM
            // console.log(el);
        });

        Livewire.hook('message.sent', (message, component) => {
            // Llamado cuando una actualización de Livewire activa un mensaje enviado al servidor a través de AJAX
            // console.log(message);
            // console.log(message.updateQueue[0].payload);
            // console.log(message.updateQueue[0].method);
        });
    };


</script>
