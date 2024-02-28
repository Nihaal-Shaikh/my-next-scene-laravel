<?php

namespace App\Http\Controllers;

use App\Models\Movies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ExampleController extends Controller
{
    public function example(Request $request)
    {
        // return $request->query();
        // Access query parameters from the request
        $type = $request->query('type');
        $genres = $request->query('genres');
        $from = $request->query('from');
        $to = $request->query('to');

        // Ensure genres parameter is an array
        $genres = is_array($genres) ? $genres : [$genres];

        // Query the database using Eloquent
        $movies = Movies::where('start_year', '>=', $from)
            ->where('start_year', '<=', $to)
            ->where(function ($query) use ($genres) {
                foreach ($genres as $genre) {
                    $query->orWhere('genres', 'like', "%{$genre}%");
                }
            })
            ->take(10)
            ->get(['imdb_id', 'primary_title', 'start_year']);

            $apiDataArray = [];

            foreach ($movies as $movie) {
                $response = Http::withHeaders([
                    'X-RapidAPI-Key' =>  config('services.rapidapi.key'),
                    'X-RapidAPI-Host' =>  config('services.rapidapi.host'),
                ])->get('https://movie-database-alternative.p.rapidapi.com/', [
                    'r' => 'json',
                    'i' => $movie->imdb_id,
                ]);

                // Extract only the required fields
                $apiDataArray[] = [
                    'Title' => $response['Title'],
                    'Year' => $response['Year'],
                    'Genre' => $response['Genre'],
                    'Language' => $response['Language'],
                    'Poster' => $response['Poster'],
                    'Ratings' => $response['Ratings'],
                    'imdbVotes' => $response['imdbVotes'],
                    // Add more fields as needed
                ];
            }

            // dd($apiDataArray);

        return response()->json(['movies' => $apiDataArray]);
    }
}
