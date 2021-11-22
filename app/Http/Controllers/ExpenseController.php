<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use App\Mail\ExpenseReport;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = Expense::with('categories')->get();
        $expenses = Auth::user()->expenses()->get();
        return view('expenses/expenses_index', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('expenses/expenses_form', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:100',
            'description' => 'max:255',
            'amount' => 'required|max:30',
        ]);

        if(!empty($request->receipt)){
            $path = $request->receipt->store('files');
            $mime = $request->receipt->getClientMimeType();
            $original_name = $request->receipt->getClientOriginalName();    
        }else{
            $path = '';
            $mime = '';
            $original_name = '';
        }

        $request->merge([
            'user_id' => Auth::id(),
            'description' => $request->description ?? '',
            'file' => $original_name,
            'file_path' => $path,
            'mime' => $mime
        ]);
        $expense = Expense::create($request->all());
        $expense->categories()->attach($request->category_id);
        Mail::to($request->user())->send(new ExpenseReport($expense));
        return redirect()->route('expenses.index')->with('message','Expense created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        return view('expenses/expenses_show', compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        $categories = Category::all();
        return view('expenses/expenses_form', compact('expense', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
        if (! Gate::allows('update-expense', $expense)) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|max:100',
            'description' => 'max:255',
            'amount' => 'required|max:30',
        ]);

        if(!empty($request->receipt)){
            $path = $request->receipt->store('files');
            $mime = $request->receipt->getClientMimeType();
            $original_name = $request->receipt->getClientOriginalName();    
        }else{
            $path = '';
            $mime = '';
            $original_name = '';
        }

        $request->merge([
            'description' => $request->description ?? '',
            'file' => $original_name,
            'file_path' => $path,
            'mime' => $mime
        ]);
        
        $this->fileDestroy($expense);
        
        Expense::where('id', $expense->id)->update($request->except('_token', '_method', 'category_id', 'receipt'));
        $expense->categories()->sync($request->category_id);
        return redirect()->route('expenses.show', $expense)->with('message','Expense edited successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        if (! Gate::allows('delete-expense', $expense)) {
            abort(403);
        }
        $expense->delete();
        return redirect()->route('expenses.index')->with('message','Expense deleted successfully!');
    }

    public function fileDownloader(Expense $expense){
        $headers = ['Content-Type'=> $expense->mime];
        return Storage::download($expense->file_path, $expense->file, $headers);
    }

    public function fileDestroy(Expense $expense){
        return Storage::delete($expense->file_path);
    }

}
