<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function getAll(Request $request)
    {
        $search = $request->search;
        $hidden = ['created_at', 'updated_at', 'episode_name', 'episode_number', 'series_number'];

        if ($search) {
            return response()->json([
                'message' => 'Quote returned.',
                'data' => Quote::where('character', 'LIKE', "%$search%")->get()->makehidden($hidden),
            ], 201);
        }

        return response()->json([
            'message' => 'Quote returned.',
            'data' => Quote::all()->makeHidden($hidden),
        ], 201);

    }

    public function getSingle(int $id)
    {
        return response()->json([
            'message' => 'Quote returned.',
            'data' => Quote::find($id),
        ], 201);
    }

    public function create(Request $request)
    {
        $request->validate([
            'character' => 'required|max:50|string',
            'words' => 'required|max:1000|string',
            'episode_name' => 'max:50|string',
            'episode_number' => 'integer',
            'series_number' => 'integer',
        ]);

        $quote = new Quote();

        $quote->character = $request->character;
        $quote->words = $request->words;
        $quote->episode_name = $request->episode_name;
        $quote->episode_number = $request->episode_number;
        $quote->series_number = $request->series_number;

        if (! $quote->save()) {
            return response()->json([
                'message' => 'DOH! Could not create quote.',
            ], 500);
        }

        return response()->json([
            'message' => 'WOO HOO! New quote created.',
        ], 201);
    }

    public function update(int $id, Request $request)
    {
        $request->validate([
            'character' => 'required|max:50|string',
            'words' => 'required|max:1000|string',
            'episode_name' => 'max:50|string',
            'episode_number' => '',
            'series_number' => '',
        ]);

        $quote = Quote::find($id);
        if (! $quote) {
            return response()->json([
                'message' => 'DOH! Quote id is invalid.',
            ], 404);
        }

        $quote->character = $request->character;
        $quote->words = $request->words;
        $quote->episode_name = $request->episode_name;
        $quote->episode_number = $request->episode_number;
        $quote->series_number = $request->series_number;

        if (! $quote->save()) {
            return response()->json([
                'message' => 'DOH! Quote update could not be saved.',
            ], 500);
        }

        return response()->json([
            'message' => 'WOO HOO! The quote had been updated.',
        ], 201);

    }

    public function delete(int $id)
    {
        $quote = Quote::find($id);

        if (! $quote) {
            return response()->json([
                'message' => 'DOH! could not delete quote, invalid id. Nice try Brian Mcgee.',
            ], 400);
        }

        $quote->delete();

        return response()->json([
            'message' => 'WOO HOO! Quote successfully deleted.',
        ], 201);
    }
}
