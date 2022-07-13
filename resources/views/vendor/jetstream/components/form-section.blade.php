@props(['submit'])


<form wire:submit.prevent="{{ $submit }}">

    {{ $form }}


    @if (isset($actions))
    {{ $actions }}
    @endif
</form>