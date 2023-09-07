@extends('layouts.default')

@section('content')

    <h1>Payment Options</h1>
    <table class="payment-options-table">
        <thead>
            <tr>
                <th><h3>Name</h3></th>
                <th style="display: none">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($paymentOptions as $paymentOption)
                <tr>
                    <td class="wider-column"><h4>{{ $paymentOption->name }}</h4></td>
                    <td class="crud-icons">
                        <button>Edit</button>
                        <button>Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
@stop