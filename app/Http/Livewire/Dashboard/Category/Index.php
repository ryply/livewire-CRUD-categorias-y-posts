<?php

namespace App\Http\Livewire\Dashboard\Category;

use App\Http\Livewire\Dashboard\OrderTrait;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use OrderTrait;

    // Modal
    public $confirmingDeleteCategory;
    public $categoryToDelete; //para hacer referencia a la categoria que queremos eliminar


    // Computed Property
    public function getCategoryProperty()
    {
        if ($this->categoryToDelete) {
            return Category::find($this->categoryToDelete->id);
        } else {
            return "Sin categoría seleccionada";
        }
    }

    // Ordenacion, mediante traits
    public $columns = [
        'id' => 'Id',
        'title' => 'Título'
    ];

    public function render()
    {
        $categories = Category::orderBy($this->sortColumn, $this->sortDirection)->paginate(10);
        return view('livewire.dashboard.category.index', compact('categories'));
    }

    public function selectCategoryToDelete(Category $category)
    {
        $this->confirmingDeleteCategory = true;
        $this->categoryToDelete = $category;
    }

    public function delete()
    {
        $this->emit("deleted");
        $this->confirmingDeleteCategory = false;
        $this->categoryToDelete->delete();
    }

}
