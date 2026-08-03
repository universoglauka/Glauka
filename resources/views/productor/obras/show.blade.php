@extends('layouts.app')
@section('title', 'Obra')
@section('content')


@if(
auth()->user()->rol === 'admin' ||
(auth()->user()->rol === 'producer' && auth()->user()->productor->id === $obra->productor_id)
)
@include('productor.partials.show-productor', ['obra' => $obra])


@elseif(
auth()->user()->rol === 'producer' && auth()->user()->productor->id !== $obra->productor_id
)
@include('productor.partials.show-non-owner-productor', ['obra' => $obra])


@else
@include('productor.partials.show-user', ['obra' => $obra])

@endif

@endsection