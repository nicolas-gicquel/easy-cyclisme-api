<?php

namespace App\Http\Controllers\Api;

use App\Models\Competition;

use Illuminate\Http\Request;

use App\Http\Requests\competitionRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\CompetitionRessource;
use Validator;


class CompetitionController extends Controller
{

    /*************************************************************************/
    /**** Méthode GET - Afficher la liste des competitions *****/
    /*************************************************************************/
    public function index()
    {
        $competitions = DB::table('competitions')
            // ->select('competitions.name', 'competitions.id')
            ->get()
            ->toArray();

        /* Si Jointure avec table catégorie
          $competitions = DB::table('competitions')
                    ->join('categories', 'competitions.category_id', '=', 'categories.id')
                    ->select('competitions.*', 'categories.name')
                    ->get()
                    ->toArray();
          
          */

        return response()->json([
            'status' => 'Success',
            'data' => $competitions,
        ]);
    }

    /*************************************************************************/
    /**** Méthode POST *****/
    /*************************************************************************/

    // Méthode - POST Ajouter un competition
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name_competition' => 'required',
            'date_competition' => 'required',
            'address_competition' => 'required',
            'postal_code_competition' => 'required',
            'city_competition' => 'required',
            'lat_competition' => 'required',
            'lon_competition' => 'required',
            'organizational_details',

        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $competition = Competition::create([
            'name_competition' => $request->name_competition,
            'date_competition' => $request->date_competition,
            'address_competition' => $request->address_competition,
            'postal_code_competition' => $request->postal_code_competition,
            'city_competition' => $request->city_competition,
            'lat_competition' => $request->lat_competition,
            'lon_competition' => $request->lon_competition,
            'organizational_details' => $request->organizational_details,
            
        ]);

        return response()->json([
            'status' => 'Success',
            'data' => $competition,
        ]);
    }

    /*************************************************************************/
    /**** Méthode GET - Afficher la fiche d'competition*****/
    /*************************************************************************/

      public function show(Competition $competition)
      {
        try {
          $competition =  Competition::whereId($competition->id)->firstOrFail();
          return response(['status' => 'ok', 'data' => $competition], 200);
        } catch (e) {
          return response(['status' => 'error', 'message' => 'Pas de données'], 500);
        }
      }

    /*************************************************************************/
    /**** Méthode PUT - Mettre à jour une fiche competition *****/
    /*************************************************************************/

    public function update(Request $request,Competition $competition)
    {
      $input = $request->all();

      $validator = Validator::make($input, [
        'name_competition' => 'required',
        'date_competition' => 'required',
        'address_competition' => 'required',
        'postal_code_competition' => 'required',
        'city_competition' => 'required',
        'lat_competition' => 'required',
        'lon_competition' => 'required',
        'organizational_details',
      ]);

      if($validator->fails()){
          return $this->sendError('Validation Error.', $validator->errors());       
      }

      $competition->name_competition = $input['name_competition'];
      $competition->date_competition = $input['date_competition'];
      $competition->address_competition = $input['address_competition'];
      $competition->postal_code_competition = $input['postal_code_competition'];
      $competition->city_competition = $input['city_competition'];
      $competition->lat_competition = $input['lat_competition'];
      $competition->lon_competition = $input['lon_competition'];
      $competition->organizational_details = $input['organizational_details'];
      $competition->save();

      return response()->json([
        'status' => 'Mise à jour effectuée']);
    }

    /*************************************************************************/
    /**** Méthode DELETE - Supprimer une fiche competition *****/
    /*************************************************************************/
    // Méthode 1
    public function destroy(Competition $competition)
    {
        $competition->delete();
        return response()->json([
          'status' => 'La compétition a bien été supprimé']);
    }
}
