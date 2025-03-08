@extends('adminlte::page')

@section('title', 'Boletos')

@section('content_header')
    <h1>Gestión De Boletos</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Administrar Boletos</h3>
        </div>
        <div class="card-body">
            @livewire('boletos') <!-- Cambié el componente a 'boletos' en lugar de 'usuarios' -->
        </div>
    </div>
@endsection
