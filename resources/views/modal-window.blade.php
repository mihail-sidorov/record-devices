<div class="modal-window {{ $class }}" {{ $ng_controller }} show="" id="">
    <div class="modal-window__cover"></div>
    <div class="modal-window__wrapper">
        <div class="modal-window__content">
            <div class="modal-window__close"></div>
            <div class="modal-window__head">{{ $name }}</div>
            <div class="modal-window__body">
                {{ $search }}
                {{ $form }}
            </div>
        </div>
    </div>
</div>