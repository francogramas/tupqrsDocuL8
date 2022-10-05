<x-jet-form-section submit="guardar">
    <x-slot name="title">
        {{ __('Seleccione el tema de su preferencia') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Use el tema con que guste, con el que se sienta màs cómodo') }}
    </x-slot>

    <x-slot name="form">
        <label for="">Temas:</label>
        <select name="" id="" wire:model='theme_id' class="select select-bordered">
            @foreach ($themes as $theme)
                <option value="{{$theme->theme}}">{{$theme->theme}}</option>
            @endforeach
        </select>
    </x-slot>
    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Actualizado.') }}
        </x-jet-action-message>

        <button class="btn btn-primary rounded-md">
            {{ __('Actualizar') }}
        </button>
    </x-slot>
</x-jet-form-section>
