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

    public function create(Request $request)
    {
        $request->validate([
            'character' => 'required|max:50|string',
            'words' => 'required|max:1000|string',
            'episode_name' => 'max:50|string',
            'episode_number' => '',
            'series_number' => '',
        ]);

        $quote = new Quote();
        $quote->character = $request->character;
        $quote->words = $request->words;
        $quote->episode_name = $request->episode_name;
        $quote->episode_number = $request->episode_number;
        $quote->series_number = $request->series_number;

        if (! $quote->save()) {
            return response('DOH! Could not create quote');
        }

        return response('WOO HOO! New quote created.');
    }

    public function update(int $id, Request $request)
    {
        $quote = Quote::find($id);

        $quote->character = $request->character;
        $quote->words = $request->words;
        $quote->episode_name = $request->episode_name;
        $quote->episode_number = $request->episode_number;
        $quote->series_number = $request->series_number;

    }

    public function delete(int $id)
    {
        $quote = Quote::find($id);

        if (! $quote) {
            return response('DOH! could not delete quote, invalid id. Nice try Brian Mcgee.');
        }

        $quote->delete();
        return response('WOO HOO! Quote successfully deleted');
    }
}
