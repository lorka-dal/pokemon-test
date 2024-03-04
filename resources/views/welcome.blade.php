<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body class="p-5">
        <h1>Выбери своего покемона</h1>
        <form class="row" id="getPokemonForm">
            @csrf
            <div class="col-6 col-md-3 mt-2">
                <h3 class="mb-4">Пол</h3>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="radioGender" value="male" id="radioGenderMale">
                    <label class="form-check-label" for="radioGenderMale">
                        Мужской
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="radioGender" value="female" id="radioGenderFemale">
                    <label class="form-check-label" for="radioGenderFemale">
                        Женский
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="radioGender" value="genderless" id="radioGenderGenderless" checked>
                    <label class="form-check-label" for="radioGenderGenderless">
                        Бесполый
                    </label>
                </div>
            </div>
            <div class="col-6 col-md-3 mt-2">
                <h3 class="mb-4">Темп роста</h3>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="radioGrowth" value="slow" id="radioGrowthSlow">
                    <label class="form-check-label" for="radioGrowthSlow">
                        Медленный
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="radioGrowth" value="medium" id="radioGrowthMedium" checked>
                    <label class="form-check-label" for="radioGrowthMedium">
                        Средний
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="radioGrowth" value="fast" id="radioGrowthFast">
                    <label class="form-check-label" for="radioGrowthFast">
                        Быстрый
                    </label>
                </div>
            </div>
            <div class="col-6 col-md-3 mt-2">
                <h3 class="mb-4">Характер</h3>
                <select class="form-select" aria-label="Характер" name="selectNature" required>
                    <option value="" selected disabled>Характер</option>
                    <option value="hardy">Выносливый</option>
                    <option value="calm">Спокойный</option>
                    <option value="docile">Послушный</option>
                    <option value="rash">Стремительный</option>
                    <option value="quirky">Ловкий</option>
                </select>
            </div>
            <div class="col-6 col-md-3 mt-2">
                <h3 class="mb-4">Цвет</h3>
                <select class="form-select" aria-label="Цвет" name="selectColor" required>
                    <option value="" selected disabled>Цвет</option>
                    <option value="black">Черный</option>
                    <option value="blue">Синий</option>
                    <option value="brown">Коричневый</option>
                    <option value="gray">Серый</option>
                    <option value="green">Зеленый</option>
                    <option value="pink">Розовый</option>
                    <option value="purple">Фиолетовый</option>
                    <option value="red">Красный</option>
                    <option value="white">Белый</option>
                    <option value="yellow">Желтый</option>
                </select>
            </div>
        </form>
        <div class="row">
            <div class="col-6 col-md-3 mt-5">
                <button type="submit" form="getPokemonForm" id="getPokemonSubmit" class="btn btn-warning">Найти покемона</button>
            </div>
        </div>
        <div id="results" class="mt-5"></div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
                crossorigin="anonymous"></script>
        <script
            src="https://code.jquery.com/jquery-3.7.1.js"
            integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
            crossorigin="anonymous"></script>
        <script>
            $('#getPokemonForm').on('submit', function(){
                let formData = $('#getPokemonForm').serializeArray();
                $('#results').html('<h4>Поиск....</h4>');
                $.ajax({
                    url: 'show',
                    method: 'post',
                    dataType: 'html',
                    data: formData,
                    success: function(data){
                        $('#results').html(data);
                    },
                    error: function (jqXHR, exception) {
                        console.log(exception);
                        $('#results').html('Не удалось найти покемонов. Попробуйте позже)');
                    }
                });
                return false;
            })
        </script>
    </body>
</html>
