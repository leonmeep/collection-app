<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function getAll()
    {
        $quotes = Quote::all();
        return $quotes;
    }

    public function getSingle(int $id)
    {
        $quote = Quote::find($id);
        return $quote;
    }
}
