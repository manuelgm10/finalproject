    <h1>¡Hello! It looks like you had a new expense</h1><br>
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
        </div>
    </div>