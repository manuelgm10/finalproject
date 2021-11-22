@extends('layouts.show_layout')
@section('show')
    @if(session('message'))
        <div class="alert alert-success">{{session('message')}}</div>
    @endif
    <div class="card m-5">
        <div class="card-header">
            {{ $expense->title }}
        </div>
        <div class="card-body">
            <h5 class="card-title">Description: {{ $expense->description }}</h5>
            <p class="card-text">Amount: {{ $expense->amount }}</p>
            <p class="card-text">
                Categories:
                <ul>
                    @foreach($expense->categories as $category)
                        <li>{{ $category->name }}</li>
                    @endforeach
                </ul>
            </p>
            <p class="card-text">
                Receipt:
                <ul>
                    <li>
                        <a href="{{ route('download', $expense) }}" class="text-decoration-none link-dark">{{ $expense->file }}</a>
                    </li>
                </ul>
            </p>
            <a href="{{ route('expenses.edit', $expense) }}" class="btn btn-success mb-2">EDIT</a>
            <form action="{{ route('expenses.destroy', $expense) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger mt-2">DELETE</button>
            </form>
        </div>
    </div>
@endsection