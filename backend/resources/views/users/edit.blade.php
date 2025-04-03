@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<script src="https:/kit.fontawesome.com/646ac4fad6.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha384-xrR6LJoJdBJ5D4qz7f8K94JPPIU5xN9xnecb76WywRJ2OLqFz1EGgM5V1WQ1gXQQ" crossorigin="anonymous">

    <h1>Editar Usuarios</h1>
@stop

@section('content')
   
<div class="card card-plain">
    <div class="card-header">
        <h4 class="font-weight-bolder"> Editar Registro de Usuarios</h4>
        <p class="mb-0">Edite el Registro</p>
    </div>
    <div class="card-body">
      <form action="{{ route('users.update', $user->id) }}" method="POST">
          @csrf
          @method('PUT')

          <div class="mb-3">
              <label for="name" class="form-label">Nombre:</label>
              <input type="text" class="form-control" id="name" name="name"
                  value="{{ $user->name }}">
          </div>

          <div class="mb-3">
              <label for="email" class="form-label">Correo Electrónico:</label>
              <input type="email" class="form-control" id="email" name="email"
                  value="{{ $user->email }}">
          </div>
          <div class="mb-3">
            <label for="secondName" class="form-label">Segundo Nombre:</label>
            <input type="text" class="form-control" id="secondName" name="secondName" value="{{ $user->secondName }}">
        </div>
    
        <div class="mb-3">
            <label for="paternalSurname" class="form-label">Apellido Paterno:</label>
            <input type="text" class="form-control" id="paternalSurname" name="paternalSurname" value="{{ $user->paternalSurname }}">
        </div>
    
        <div class="mb-3">
            <label for="maternalSurname" class="form-label">Apellido Materno:</label>
            <input type="text" class="form-control" id="maternalSurname" name="maternalSurname" value="{{ $user->maternalSurname }}">
        </div>
    
        <div class="mb-3">
            <label for="age" class="form-label">Edad:</label>
            <input type="number" class="form-control" id="age" name="age" value="{{ $user->age }}">
        </div>

        <div class="mb-3">
            <label for="calle_avenida" class="form-label">Calle o Avenida:</label>
            <input type="text" class="form-control" id="calle_avenida" name="calle_avenida" value="{{ $user->calle_avenida }}">
        </div>
    
        <div class="mb-3">
            <label for="numext" class="form-label">Número Exterior:</label>
            <input type="text" class="form-control" id="numext" name="numext" value="{{ $user->numext }}">
        </div>
    
        <div class="mb-3">
            <label for="genero" class="form-label">Género:</label>
            <select class="form-control" id="genero" name="genero">
                <option value="masculino" {{ $user->genero == 'masculino' ? 'selected' : '' }}>Masculino</option>
                <option value="femenino" {{ $user->genero == 'femenino' ? 'selected' : '' }}>Femenino</option>
                <option value="otro" {{ $user->genero == 'otro' ? 'selected' : '' }}>Otro</option>
            </select>
        </div>
    
        <div class="mb-3">
            <label for="curp" class="form-label">CURP:</label>
            <input type="text" class="form-control" id="curp" name="curp" value="{{ $user->curp }}">
        </div>
    
        <div class="mb-3">
            <label for="nacionalidad" class="form-label">Nacionalidad:</label>
            <input type="text" class="form-control" id="nacionalidad" name="nacionalidad" value="{{ $user->nacionalidad }}">
        </div>
    
        <div class="mb-3">
            <label for="nacimiento" class="form-label">Fecha de Nacimiento:</label>
            <input type="date" class="form-control" id="nacimiento" name="nacimiento" value="{{ $user->nacimiento }}">
        </div>
    
        <div class="mb-3">
            <label for="phone" class="form-label">Teléfono:</label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone }}">
        </div>
    
          
          <div class="mb-3">
              <label class="form-label">Roles:</label>
              <div>
                  @foreach ($roles as $role)
                      <div class="form-check form-check-inline">
                          <input class="form-check-input" type="checkbox"
                              id="role_{{ $role->id }}" name="roles[]"
                              value="{{ $role->id }}"
                              {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                          <label class="form-check-label"
                              for="role_{{ $role->id }}">{{ $role->name }}</label>
                      </div>
                  @endforeach
              </div>
          </div>
          
                  <div class="box-footer mt20">
                      <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
                  </div>
                  <br>
                  <div class="box-footer mt20">
                      <button type="submit" class="btn btn-info">{{ __('Cerrar') }}</button>
                  </div>
          </div>
      </form>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <style>
        /* Estilo personalizado para colocar la etiqueta encima del input */
        .form-group label {
            display: block;
            margin-bottom: 5px; /* Espacio entre la etiqueta y el input */
        }
    </style>
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
