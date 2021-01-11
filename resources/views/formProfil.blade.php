@extends('layouts.master')
@section('content')

<div class="col-md-9 well well-md">
    <center><h1>Profil</h1></center>
    {!! Form::open(['url' => 'profil'])!!}   
    {{ csrf_field() }}
    <div class="form-horizontal">    
        <div class="form-group">
            <label class="col-md-3 control-label">Nom : </label>
            <div class="col-md-3 ">
                {{Form::text("nom", old("nom") ? old("nom") : (!empty($lecteur) ? $lecteur->nom : null ),
                    ["class" => "form-control", "placeholder" => "Nom", "required", "autofocus"])
                }}                  
            </div>
            @error('nom')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror           
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">Prénom : </label>
            <div class="col-md-3 ">
                {{Form::text("prenom", old("prenom") ? old("prenom") : (!empty($lecteur) ? $lecteur->prenom : null ),
                    ["class" => "form-control", "placeholder" => "Prénom", "required", "autofocus"])
                }}                  
            </div>
            @error('prenom')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror          
        </div> 
        <div class="form-group">
            <label class="col-md-3 control-label">Rue : </label>
            <div class="col-md-5 ">
                {{Form::text("rue", old("rue") ? old("rue") : (!empty($lecteur) ? $lecteur->rue : null ),
                    ["class" => "form-control", "placeholder" => "Rue", "autofocus"])
                }}  
            @error('rue')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror             
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Code postal : </label>
            <div class="col-md-2">
                {{Form::text("cp", old("cp") ? old("cp") : (!empty($lecteur) ? $lecteur->cp : null ),
                    ["class" => "form-control", "placeholder" => "Code Postal", "required | numeric", "autofocus"])
                }}  
            </div>
            @error('cp')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>       
        <div class="form-group">
            <label class="col-md-3 control-label">Ville : </label>
            <div class="col-md-3 ">
                {{Form::text("ville", old("ville") ? old("ville") : (!empty($lecteur) ? $lecteur->ville : null ),
                    ["class" => "form-control", "placeholder" => "Ville", "autofocus"])
                }} 
            @error('ville')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
            </div>
        </div>   
        <div class="form-group">
            <label class="col-md-3 control-label">Rôle : </label>
            <div class="col-md-3 ">
                {{Form::text("role", $user->role,
                    ["class" => "form-control", "readonly"])
                }} 
            </div>
        </div>          
        <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
                <button type="submit" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-log-in"></span> Valider</button>     
                &nbsp;
                <button type="button" class="btn btn-default btn-primary" 
                    onclick="javascript: window.location = '{{ url('/') }}';">
                    <span class="glyphicon glyphicon-remove"></span> Annuler
                </button>                
            </div>
        </div>
    </div>
    <div class="col-md-6 col-md-offset-3">
        @include('error')
    </div>  
    {!! @Form::close() !!} 
</div>
@stop

