<?php

namespace App\Http\Livewire\Dashboard\Post;

use App\Models\Category;
use Livewire\Component;
use App\Models\Post;
use Livewire\WithFileUploads;

class Save extends Component
{
    use WithFileUploads;

    public $title;
    public $date;
    public $image;
    public $text;
    public $description;
    public $posted;
    public $type;
    public $category_id;

    public $post;

    protected $rules = [
        'title' => 'required|min:3|max:255',
        'date' => 'required',
        'image' => 'nullable|image|max:1024',
        'text' => 'nullable',
        'description' => 'required|min:3|max:255',
        'posted' => 'required',
        'type' => 'required',
        'category_id' => 'required'
    ];

    public function mount($id = null)
    {
        if ($id != null) {
            $this->post = Post::findOrFail($id);
            $this->title = $this->post->title;
            $this->date = $this->post->date;
            $this->text = $this->post->text;
            $this->description = $this->post->description;
            $this->posted = $this->post->posted;
            $this->type = $this->post->type;
            $this->category_id = $this->post->category_id;
        }
    }

    public function render()
    {
        $categories = Category::all();
        return view('livewire.dashboard.post.save', compact('categories'));
    }

    public function submit()
    {
        // validate
        $this->validate();

        // save
        if ($this->post) {
            // Si esta definida la actualizamos
            $this->post->update([
                'title' => $this->title,
                'date' => $this->date,
                'text' => $this->text,
                'description' => $this->description,
                'posted' => $this->posted,
                'type' => $this->type,
                'category_id' => $this->category_id
            ]);
            $this->emit("updated");
        } else {
            // en caso contrario creamos la categoria
            $this->post = Post::create([
                'title' => $this->title,
                'slug' => str($this->title)->slug(),
                'date' => $this->date,
                'text' => $this->text,
                'description' => $this->description,
                'posted' => $this->posted,
                'type' => $this->type,
                'category_id' => $this->category_id
            ]);
            // Para emitir un evento usamos emit()
            $this->emit("created");
        }

        // upload
        if ($this->image) {
            $imageName = $this->post->slug . '.' . $this->image->getClientOriginalExtension();
            $this->image->storeAs('images/post', $imageName, 'public_upload');
            $this->post->update([
                'image' => $imageName
            ]);
        }

    }
}

