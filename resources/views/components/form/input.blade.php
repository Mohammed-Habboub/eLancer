@props([
    'id' => '', 'label','name', 'value' =>'', 'type' => 'text'
])
@if(isset($label))
<label for="{{$id}}">{{ $label }}</label>
@endif
<input  type="{{ $type }}"
        id="{{ $id }}"
        name="{{ $name }}" 
        value="{{ old($name, $value) }}" 
        {{ $attributes->class(['form-control',  'is-invalid' => $errors->has($name)]) }}
>
@error($name)
<p class="invalid-feedback">{{$message}}</p>
@enderror