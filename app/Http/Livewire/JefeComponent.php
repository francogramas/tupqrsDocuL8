<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Crypt;
use App\Models\Solicitud;
class JefeComponent extends Component
{
    public $sol, $solicitud;
    protected $queryString = ['sol'];

    public function mount()
    {
        if (!is_null($this->sol)) {
            $id = Crypt::decryptString($this->sol);
            $this->solicitud = Solicitud::find($id);
        }
        else {

        }

    }

    public function render()
    {

        return view('livewire.jefe-component');
    }
}
