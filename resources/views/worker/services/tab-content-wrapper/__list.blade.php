<div class="tab-content-wrapper__list">
    @foreach ($services as $service)
        <div class="tab-content-wrapper__list-item" id="{{ $service->id }}">
            <input type="hidden" class="tab-content-wrapper__list-item-filter-field" value="{{ $service->name }}">

            <div class="tab-content-wrapper__list-item-head">
                <div class="tab-content-wrapper__list-item-name">{{ $service->name }}</div>
                @if ((Auth::user()->role === 'admin') || (Auth::user()->role === 'worker' && Auth::user()->id === $service->user_id))
                    @include('btns.edit-btn')
                    @include('btns.del-btn')
                @endif
            </div>
            <div class="tab-content-wrapper__list-item-body">
                <table class="tab-content-wrapper__list-item-body-table">
                    <thead>
                        <tr>
                            <td>Логин</td>
                            @if ((Auth::user()->role === 'admin') || (Auth::user()->role === 'worker' && Auth::user()->id === $service->user_id))
                                <td>Пароль</td>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $service->login }}</td>
                            @if ((Auth::user()->role === 'admin') || (Auth::user()->role === 'worker' && Auth::user()->id === $service->user_id))
                                <td>{{ $service->password }}</td>
                            @endif
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
</div>