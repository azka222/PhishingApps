@extends('layouts.master')

@section('title', 'Fischsim - Dashboard')

@section('content')
<div class="container">
    <h1>Dashboard</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Card 1
                </div>
                <div class="card-body">
                    Content for card 1.
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Card 2
                </div>
                <div class="card-body">
                    Content for card 2.
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Card 3
                </div>
                <div class="card-body">
                    Content for card 3.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection