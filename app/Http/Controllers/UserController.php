<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use function Laravel\Prompts\error;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        User::create($request->validated());

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function hireBook($id, Book $book)
    {
        $user = User::findOrFail($id);

        if ($user->no_of_books > 5) {
            return error('You have too many books out');
        }

        if ($book->no_of_copies < 1) {
            return error('Apologies, that book is out of stock');
        }

        $user->books()->attach($book, ['checked_out_on' => now()]);

        $book->no_of_copies = $book->no_of_copies - 1;
        $book->save();

        return redirect()->back()->withSuccess('Book Successfully checked out.');
    }
}
