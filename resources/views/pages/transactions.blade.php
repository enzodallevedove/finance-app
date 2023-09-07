@extends('layouts.default')

@section('content')
    <h1>Transactions</h1>
    <table class="transactions-table">
        <thead>
            <tr>
                <th><h3>Name</h3></th>
                <th><h3>Value</h3></th>
                <th><h3>Description</h3></th>
                <th><h3>Date</h3></th>
                <th style="display: none">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
                <tr>
                    <td class="wider-column"><h4>{{ $transaction->name }}</h4></td>
                    <td class="wider-column"><h4>{{ $transaction->value }}</h4></td>
                    <td class="wider-column"><h4>{{ date('H:i d-m-Y', strtotime($transaction->date)) }}</h4></td>
                    <td class="crud-icons">
                        <button>Edit</button>
                        <button>Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
@stop