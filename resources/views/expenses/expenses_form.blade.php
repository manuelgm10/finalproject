@extends('layouts.create_edit_layout')
@section('create_edit')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(isset($expense))
        <form class="m-5" action="{{ route('expenses.update', $expense) }}" method="POST" enctype="multipart/form-data">
        @method('PATCH')
    @else
        <form class="m-5" action="{{ route('expenses.store') }}" method="POST" enctype="multipart/form-data">
    @endif
        @csrf
        <!-- Title input -->
        <div class="form-outline mb-3">
            <label class="form-label" for="title">Title</label>
            <input type="text" id="title" name="title" class="form-control" placeholder="Enter title of your expense." value="{{ $expense->title ?? '' }}" required/>
        </div>

        <!-- Description input -->
        <div class="form-outline mb-3">
            <label class="form-label" for="description">Description</label>
            <input type="text" id="description" name="description" class="form-control" placeholder="Enter description of your expense." value="{{ $expense->description ?? '' }}">
        </div>

        <!-- Amount input -->
        <div class="form-outline mb-3">
            <label class="form-label" for="amount">Amount</label>
            <input type="text" id="amount" class="form-control" name="amount" placeholder="Enter amount of your expense." value="{{ $expense->amount ?? '' }}" required/>
        </div>

        <!-- Category selection -->
        <div class="form-outline mb-3">
            <label class="form-label" for="category_id">Categories (press ctrl to multiple selection)</label>
            <select id="category_id" class="form-control" name="category_id[]" multiple>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ isset($expense) && array_search($category->id, $expense->categories->pluck('id')->toArray()) !== false ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Receipt input -->
        <div class="form-outline mb-3">
            <label class="form-label" for="receipt">Receipt</label>
            <input type="file" id="receipt" class="form-control" name="receipt" value="{{ $expense->file ?? '' }}"/>
        </div>

        <!-- Submit button -->
        <button type="submit" class="btn btn-success btn-block mb-3 mt-3">{{isset($expense) ? 'EDIT' : 'CREATE'}}</button>
        </form>
@endsection