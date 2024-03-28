@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="card mt-5">
                <div class="card-header">Empleados zz</div><br>
                           
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are lasogged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
