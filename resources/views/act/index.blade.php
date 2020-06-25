<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Учет устройств') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <?php
        $d = new DateTime();
        $worker = $act->get_worker();
        $devices = $act->devices;
        $work_places = $act->work_places;

        $type = ($act->type === 'give' ? 'передачи' : 'сдачи');
        $create_date = strtotime($act->created_at);
        $d->setTimestamp($create_date);
        $create_date = $d->format('d-m-Y');
        $employer = ($worker->employer_id === 1 ? 'Корсун А.В.' : 'Корсун В.П.');
        $d->setTimestamp($worker->placement_date);
        $placement_date = $d->format('d-m-Y');
    ?>
    <div class="act">
        <div class="act__title">Акт</div>
        <div class="act__desc">приема-{{ $type }} материальных ценностей сотруднику</div>
        <div class="act__city">г. Майкоп</div>
        <div class="act__date">{{ $create_date }}г.</div>

        <div class="act__core">
            Индивидуальный предприниматель {{ $employer }}, именуемый в дальнейшем "Работодатель", действующий на основании Свидетельства, с одной стороны, и {{ $worker->name }}, именуемый в дальнейшем "Работник", с другой стороны, составили настоящий акт о следующем:
        </div>

        <ul class="act__content-items">
            <li class="act__content-item">
                В соответствии с Трудовым договором от {{ $placement_date }}г. № б/н "Работодатель" передал, а "Работник" принял следующие материальные ценности для выполнения своих должностных обязанностей:
                <table>
                    <thead>
                        <tr>
                            <td>№ п/п</td>
                            <td>Наименование материальных ценностей</td>
                            <td>Инв. №</td>
                            <td>Ед. изм.</td>
                            <td>Кол-во</td>
                            <td>Стоимость, руб.</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; ?>
                        @foreach ($work_places as $work_place)
                            <?php $i++; ?>
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $work_place->name }}</td>
                                <td>{{ $work_place->inventar_number }}</td>
                                <td>шт.</td>
                                <td>1</td>
                                <td>{{ $work_place->get_purchase_price() }}</td>
                            </tr>
                        @endforeach
                        @foreach ($devices as $device)
                            <?php $i++; ?>
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $device->name }}</td>
                                <td>-</td>
                                <td>шт.</td>
                                <td>1</td>
                                <td>{{ $device->purchase_price }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </li>
            <li class="act__content-item">
                Материальные ценности проверены и просчитаны в присутствии сторон;
                <div class="act__content-item-remarks">
                    <span class="act__content-item-remarks-title">замечания (при наличии)</span>
                    <span class="act__content-item-remarks-line"></span>
                </div>
            </li>
            <li class="act__content-item">
                Настоящий акт составлен в 2-х экземплярах, по одному для каждой стороны.
            </li>
            <li class="act__content-item">
                Подписи сторон:
                <div class="act__content-item-faces">
                    <div class="act__content-item-face act__content-item-face_employer">
                        <div class="act__content-item-face-title">Работодатель</div>
                        <div class="act__content-item-face-name">{{ $employer }}</div>
                        <div class="act__content-item-face-signature">
                            <span class="act__content-item-face-signature-title">Подпись</span>
                            <span class="act__content-item-face-signature-line"></span>
                        </div>
                    </div>
                    <div class="act__content-item-face act__content-item-face_worker">
                        <div class="act__content-item-face-title">Работник</div>
                        <div class="act__content-item-face-name">{{ $worker->name }}</div>
                        <div class="act__content-item-face-signature">
                            <span class="act__content-item-face-signature-title">Подпись</span>
                            <span class="act__content-item-face-signature-line"></span>
                        </div>
                    </div>
                </div>
            </li>
        </ul>

        <div class="act__content-mp">М.П.</div>
    </div>
</body>
</html>