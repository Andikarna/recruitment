@extends('layouts.dashboardLayouts')

@section('ADIDATA', 'Onboarding')

@section('username', Auth::user()->name )
@section('userid', Auth::user()->id )


@section('content')

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

@endsection