@extends('layouts.index_layout')
@section('index')
    @if(session('message'))
        <div class="alert alert-success">{{session('message')}}</div>
    @endif
    <div class="table-responsive">
        <table class="table table-responsive">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">Amount</th>
                <th scope="col">Categories</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($expenses as $expense)
                    <tr>
                        <th scope="row">
                            <a class="text-decoration-none link-dark" href="{{ route('expenses.show', $expense->id) }}">
                                {{ $expense->id }}
                            </a>
                        </th>
                        <td>{{ $expense->title }}</td>
                        <td>{{ $expense->description }}</td>
                        <td>{{ $expense->amount }}</td>
                        <td>
                            <ul>
                            @foreach($expense->categories as $category)
                                <li>{{ $category->name }}</li>
                            @endforeach
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection