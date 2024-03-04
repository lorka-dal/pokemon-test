<div id="idealResults">
    <h2>Твой идеальный вариант</h2>
    <div class="row">
        @foreach ($data['ideal'] as $pokemon)
            <div class="col-6 col-sm-3">
                <img  class="img-fluid" src="{{ $pokemon['pokemon']['sprites']['front_default'] }}"/>
                <p><b>Имя: </b>{{ $pokemon['pokemon']['name'] }}</p>
                <p><b>Пол: </b>
                    @switch($pokemon['pokemonSpecies']['gender_rate'])
                        @case(4)
                            женский
                            @break
                        @case(-1)
                            бесполый
                            @break
                        @default
                            мужской
                    @endswitch
                </p>
                <p><b>Темп роста: </b>{{ $pokemon['pokemonSpecies']['growth_rate']['name'] }}</p>
                <p><b>Характер: </b>{{ $pokemon['nature'] }}</p>
                <p><b>Цвет: </b>{{ $pokemon['pokemonSpecies']['color']['name'] }}</p>
                <p><b>Базовый опыт: </b>{{ $pokemon['pokemon']['base_experience'] }}</p>
            </div>
        @endforeach
    </div>
</div>
<div id="othersResults">
    <h2>Возможно,тебе подойдут</h2>
    <div class="row">
        @foreach ($data['others'] as $pokemon)
            <div class="col-6 col-sm-3">
                <img class="img-fluid" src="{{ $pokemon['pokemon']['sprites']['front_default'] }}"/>
                <p><b>Имя: </b>{{ $pokemon['pokemon']['name'] }}</p>
                <p><b>Пол: </b>
                    @switch($pokemon['pokemonSpecies']['gender_rate'])
                        @case(4)
                        женский
                        @break
                        @case(-1)
                        бесполый
                        @break
                        @default
                        мужской
                    @endswitch
                </p>
                <p><b>Темп роста: </b>{{ $pokemon['pokemonSpecies']['growth_rate']['name'] }}</p>
                <p><b>Характер: </b>{{ $pokemon['nature'] }}</p>
                <p><b>Цвет: </b>{{ $pokemon['pokemonSpecies']['color']['name'] }}</p>
                <p><b>Базовый опыт: </b>{{ $pokemon['pokemon']['base_experience'] }}</p>
            </div>
        @endforeach
    </div>
</div>
