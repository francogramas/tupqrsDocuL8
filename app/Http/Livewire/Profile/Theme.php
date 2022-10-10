<?php

namespace App\Http\Livewire\Profile;

use Livewire\Component;
use App\Models\Themes;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Theme extends Component
{
    public $themes, $theme_id, $saved;
    public function mount()
    {
        $this->themes = Themes::all();
        $this->theme_id = Auth::user()->theme;
    }
    public function render()
    {
        return view('livewire.profile.theme');
    }

    public function guardar()
    {
        $U = User::find(Auth::user()->id);
        $U->theme=$this->theme_id;
        $U->save();
        return redirect(request()->header('Referer'));
    }

}
