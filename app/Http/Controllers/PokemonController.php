<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PokePHP\PokeApi;
use Illuminate\Support\Arr;

class PokemonController extends Controller
{
    private $state = 100;
    public function show(Request $request){
        $inputs = $request->all();
        $result = $this->getPokemons($inputs);
        return view('results', ['data' => $result]);
    }

    private function getPokemons($inputs){
        $api = new PokeApi;
        $responseGenderDirty = json_decode($api->gender($inputs['radioGender']), true);
        $responseGender = Arr::pluck($responseGenderDirty['pokemon_species_details'],'pokemon_species.name');
        if($inputs['radioGrowth'] == 'medium'){
            $responseGrowthDirtyMedium = json_decode($api->growthRate('medium'), true);
            $responseGrowthDirtyMediumSlow = json_decode($api->growthRate('medium-slow'), true);
            $responseGrowthDirtySlowFast = json_decode($api->growthRate('slow-then-very-fast'), true);
            $responseGrowthDirtyFastSlow = json_decode($api->growthRate('fast-then-very-slow'), true);
            $responseGrowthDirty = array_merge($responseGrowthDirtyMedium, $responseGrowthDirtyMediumSlow, $responseGrowthDirtySlowFast, $responseGrowthDirtyFastSlow);
            $responseGrowth = Arr::pluck($responseGrowthDirty['pokemon_species'],'name');
        }else {
            $responseGrowthDirty = json_decode($api->growthRate($inputs['radioGrowth']));
            $responseGrowth = Arr::pluck($responseGrowthDirty->pokemon_species, 'name');
        }
        $responseNature = $inputs['selectNature'];
        $responseColorDirty = json_decode($api->pokemonColor($inputs['selectColor']));
        $responseColor = Arr::pluck($responseColorDirty->pokemon_species,'name');

        return $this->getSortResult($responseGender, $responseGrowth, $responseNature, $responseColor);
    }
    private function getSortResult($responseGender, $responseGrowth, $responseNature, $responseColor)
    {
        $idealResults = array_intersect($responseGender, $responseGrowth);
        $idealResults = array_intersect($idealResults, $responseColor);

        $results = $this->getPokemonsInformation(array_values($idealResults), $responseNature);
        if(count($results['others']) < 8){
            $otherResults = array_merge(
                array_intersect($responseGender, $responseGrowth),
                array_intersect($responseGrowth, $responseColor),
                array_intersect($responseGender, $responseColor)
            );
            $otherResults = array_diff($otherResults, $idealResults);

            shuffle($otherResults);

            $results = $this->getPokemonsInformation($otherResults, $responseNature, $results['ideal'], $results['others']);
        }

        return $results;
    }
    private function getPokemonsInformation($names, $nature, $arrayIdeal = [], $arrayOthers = []){
        $api = new PokeApi;
        $i=0;
        $names = array_values($names);
        while((count($arrayIdeal) <= 4 or count($arrayOthers) <= 8) and $i < count($names)){
            $pokemon = json_decode($api->pokemon($names[$i]),true);
            if (count($arrayIdeal) < 4 and $this->checkPokemonNature($pokemon, $nature)) {
                $arrayIdeal[$i]['pokemon'] = $pokemon;
                $arrayIdeal[$i]['pokemonSpecies'] = json_decode($api->pokemonSpecies($names[$i]), true);
                $arrayIdeal[$i]['nature'] = $this->getPokemonNature($pokemon);
            } elseif (count($arrayOthers) < 8) {
                $arrayOthers[$i]['pokemon'] =  $pokemon;
                $arrayOthers[$i]['pokemonSpecies'] = json_decode($api->pokemonSpecies($names[$i]), true);
                $arrayOthers[$i]['nature'] = $this->getPokemonNature($pokemon);
            }
            $i++;
        }

        return ['ideal' => $arrayIdeal, 'others' => $arrayOthers];
    }
    // в api ничего не сказано про nature у покимонов => импровизация
    private function checkPokemonNature($pokemon, $nature){
        $arrStats = Arr::pluck($pokemon['stats'], 'base_stat', 'stat.name');
        switch ($nature){
            case('hardy'):
                if($arrStats['hp'] > $this->state)
                    return true;
                else
                    return false;
            case('calm'):
                if($arrStats['speed'] > $this->state)
                    return true;
                else
                    return false;
            case('docile'):
                if($arrStats['defense'] > $this->state)
                    return true;
                else
                    return false;
            case('rash'):
                if($arrStats['attack'] > $this->state)
                    return true;
                else
                    return false;
            case('quirky'):
                if($arrStats['special-attack'] > $this->state or $arrStats['special-defense'] > $this->state)
                    return true;
                else
                    return false;
            default:
                return false;
        }
    }
    private function getPokemonNature($pokemon){
        $arrStats = Arr::pluck($pokemon['stats'], 'base_stat', 'stat.name');
        $nature = '';
        if ($arrStats['hp'] > $this->state)
            $nature .= 'Выносливый ';
        if ($arrStats['speed'] > $this->state)
            $nature .= 'Ловкий ';
        if ($arrStats['attack'] > $this->state)
            $nature .= 'Стремительный ';
        if ($arrStats['defense'] > $this->state)
            $nature .= 'Послушный ';
        if ($arrStats['special-attack'] > $this->state or $arrStats['special-defense'] > $this->state)
            $nature .= 'Спокойный ';
        return $nature;
    }
}
