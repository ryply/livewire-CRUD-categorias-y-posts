<?php

namespace App\Http\Livewire\Dashboard\Post;

use App\Http\Livewire\Dashboard\OrderTrait;
use App\Models\Category;
use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use OrderTrait;

    // QueryString, se muestra el token de los filtros que estamos aplicando en la url,
    // de esta manera se mantiene los ultimos valores de búsqueda.
    protected $queryString = ['type', 'posted', 'category_id', 'search', 'from', 'to'];

    // Modal
    public $confirmingDeletePost;
    public $postToDelete;

    // Filters
    public $posted;
    public $type;
    public $category_id;

    // Search
    public $search;

    // Filtro por fechas
    public $from;
    public $to;

    // Ordenacion, mediante traits
    public $columns = [
        'id' => 'Id',
        'title' => 'Título',
        'date' => 'Fecha',
        'description' => 'Descripción',
        'posted' => 'Posteado',
        'type' => 'Tipo',
        'category_id' => 'Categoria'
    ];

    public function render()
    {
        // formamos el query, esto siempre se cumple
        // $postsFilters = Post::where('id', '>=', 1);

        $postsFilters = Post::orderBy($this->sortColumn, $this->sortDirection);

        //search
        if ($this->search) {
            $postsFilters->where(function ($query) {
                $query->orWhere('id', 'like', '%' . $this->search . '%')
                        ->orWhere('title', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // filtro por fechas
        if ($this->from && $this->to) {
            $postsFilters->whereBetween('date', [ date($this->from), date($this->to) ]);
        }

        // filters
        if ($this->type) {
            $postsFilters->where('type', $this->type);
        }

        if ($this->posted) {
            $postsFilters->where('posted', $this->posted);
        }

        if ($this->category_id) {
            $postsFilters->where('category_id', $this->category_id);
        }

        $categories = Category::all();
        $posts = $postsFilters->paginate(5);
        return view('livewire.dashboard.post.index', compact('posts', 'categories'));
    }

    public function selectPostToDelete(Post $post)
    {
        $this->confirmingDeletePost = true;
        $this->postToDelete = $post;
    }

    public function delete()
    {
        $this->emit("deleted");
        $this->confirmingDeletePost = false;
        $this->postToDelete->delete();
    }
}
