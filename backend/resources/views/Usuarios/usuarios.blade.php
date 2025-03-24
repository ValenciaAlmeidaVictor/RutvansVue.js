@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
    <h1>Gestión de Usuarios</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Administrar Usuarios</h3>
        </div>
        <div class="card-body">
            @livewire('usuarios')
        </div>
    </div>
@endsection
