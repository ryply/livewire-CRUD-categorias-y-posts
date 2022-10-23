<?php

namespace App\Http\Livewire\Dashboard\Category;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;

class Save extends Component
{
    use WithFileUploads;

    public $title;
    public $text;
    public $image;

    public $category;

    protected $rules = [
        'title' => 'required|min:3|max:255',
        'text' => 'nullable',
        'image' => 'nullable|image|max:1024',
    ];

    public function mount($id = null)
    {
        /* Cuando carga la pagina lo primero que se ejecuta es el mount(),
            si esta definido el id, se rellenan los campos del formulario
            con los valores de la categoria correspondiente a este id,
            de lo contrario si no esta definido se muestra el error 404,
            al usar el metodo findOrFail().*/
        if ($id != null) {
            $this->category = Category::findOrFail($id);
            $this->title = $this->category->title;
            $this->text = $this->category->text;
        }
    }

    public function render()
    {
        return view('livewire.dashboard.category.save');
    }

    public function submit()
    {
        // validate
        $this->validate();

        // save
        if ($this->category) {
            // Si esta definida la actualizamos
            $this->category->update([
                'title' => $this->title,
                'text' => $this->text
            ]);
            $this->emit("updated");
        } else {
            // en caso contrario creamos la categoria
            $this->category = Category::create([
                'title' => $this->title,
                'slug' => str($this->title)->slug(),
                'text' => $this->text
            ]);
            // Para emitir un evento usamos emit()
            $this->emit("created");
        }

        // upload
        if ($this->image) {
            $imageName = $this->category->slug . '.' . $this->image->getClientOriginalExtension();
            $this->image->storeAs('images/category', $imageName, 'public_upload');
            $this->category->update([
                'image' => $imageName
            ]);
        }

    }
}
