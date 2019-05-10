@extends('layouts.app')

@section('content')


    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-4">Pricing</h1>
        <p class="lead">Quickly build an effective pricing table for your potential customers with this Bootstrap example. It’s built with default Bootstrap components and utilities with little customization.</p>
    </div>

    <div class="container">
        <div class="card-deck mb-3 text-center">
            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">Free</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">$0 <small class="text-muted">/ mo</small></h1>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>Question update Emails</li>
                        <li>Interesting articles</li>
                        <li>Help center access</li>
                    </ul>
                    <a href="{{ route('Charge.charge') }}" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Primary link</a>
                </div>
            </div>

        </div>
@endsection
