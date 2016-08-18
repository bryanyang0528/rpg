<?php

namespace App\Http\Controllers;

use App\Character;
use App\Http\Requests\CreateCharacterRequest;
use App\Http\Requests\MoveCharacterRequest;
use App\Location;
use App\Race;
use App\RuleSet\Combat;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CharacterController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['only' => ['create', 'store']]);
        $this->middleware('has.character', ['only' => ['getMove']]);
        $this->middleware('auth', ['only' => ['getMove']]);
        $this->middleware('no.character', ['only' => ['create', 'store']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $races = Race::all();
        $user = Auth::user();
        return view('character.create', compact('races', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateCharacterRequest $request
     * @return Response
     */
    public function store(CreateCharacterRequest $request)
    {
        $authenticatedUser = $request->user(); /** @var User $authenticatedUser */
        $race = Race::findOrFail($request->input('race_id')); /** @var Race $race */

        $character = $authenticatedUser->character()->create([
            'name' => $request->input('name'),
            'gender' => $request->input('gender'),

            'xp' => 0,
            'level' => 1,
            'money' => 0,
            'reputation' => 0,

            'strength' => $race->strength,
            'agility' => $race->agility,
            'constitution' => $race->constitution,
            'intelligence' => $race->intelligence,
            'charisma' => $race->charisma,

            'race_id' => $race->id,
            'location_id' => $race->starting_location_id,
        ]);

        return redirect()->route("home");
    }

    /**
     * Display the specified resource.
     *
     * @param Character $character
     * @return Response
     */
    public function show(Character $character)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Character $character
     * @return Response
     */
    public function edit(Character $character)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Character $character
     * @return Response
     */
    public function update(Request $request, Character $character)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Character $character
     * @return Response
     */
    public function destroy(Character $character)
    {
        //
    }

    /**
     * @param Character $character
     * @param Location $location
     * @param MoveCharacterRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getMove(Character $character, Location $location, MoveCharacterRequest $request)
    {
        // update character's location
        $character->location()->associate($location)->save();

        return redirect()->route('location.show', compact('location'));
    }

    /**
     * @param Character $defender
     * @param Combat $combat
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getAttack(Character $defender, Combat $combat)
    {
        $attacker = Auth::user()->character;
        $location = $attacker->location;

        $attackLog = $combat->attack($attacker, $defender);

        return redirect()->route('location.show', compact('location'));
    }
}
