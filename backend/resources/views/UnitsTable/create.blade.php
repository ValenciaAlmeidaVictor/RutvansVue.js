@extends('adminlte::page')

@section('title', 'Create Unit')

@section('content_header')
    <h1>Crear nueva unidad</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <livewire:create-unit-form />
        </div>
    </div>
@endsection
