@slot('header')
    {{ __('CRUD Categories') }}
@endslot


<x-card class="container">
    <x-jet-action-message on="deleted">
        <div class="box-action-message-red">
            {{ __('Deleted category.') }}
        </div>
    </x-jet-action-message>

    @slot('title')
        Listado
    @endslot

    {{-- Acedemos a la propiedad computada --}}
    {{-- <p class="py-4">Categoría seleccionada: {{ $this->category}}</p> --}}

    <a class="mb-2 btn-secondary" href="{{ route('d-category-create') }}">Create category</a>

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
            @foreach ($categories as $category)
                <tr class="border-b-2">
                    <td class="p-2">{{ $category->id }}</td>
                    <td class="p-2">{{ $category->title }}</td>
                    <td class="p-2">
                        <x-jet-nav-link href="{{ route('d-category-edit', $category) }}" class="mr-2">Editar
                        </x-jet-nav-link>
                        <x-jet-danger-button {{-- onclick="confirm('¿Seguro que deseas eliminar el registro selecionado?') || event.stopImmediatePropagation()" --}}
                            wire:click="selectCategoryToDelete({{ $category }})">
                            Eliminar
                        </x-jet-danger-button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    {{ $categories->links() }}

    <x-jet-confirmation-modal wire:model="confirmingDeleteCategory">
        <x-slot name="title">
            {{ __('Delete Category') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to delete this category?.') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingDeleteCategory')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-3" wire:click="delete()" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>

</x-card>
