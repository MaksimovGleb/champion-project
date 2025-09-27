<div class="col-md-12">
    <div class="card">
        <div class="card-header d-flex p-0">
            <ul class="nav nav-pills ">
                @foreach($tabs['items'] as $key => $tab)
                    <li class="nav-item"><a class="nav-link {{ $key == 0 ? 'active': '' }}" href="#tab-item-{{ $key }}" data-toggle="tab">{{ $tab['name'] }}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="card-body">
            <div id="tab-content">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
