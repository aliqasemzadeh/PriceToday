<div>
    <x-slot name="title">
        {{ __('bap.home') }}
    </x-slot>


    <div class="page-body">
        <div class="container-xl">
            @if(config('bap.home.display-carousels'))
                <div class="row row-deck row-cards mb-2">
                    <div class="col-md-12">
                        <div class="card mb-2">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">{{ __('bap.carousels') }}</h3>
                                </div>
                                <div class="card-body">
                                    <div id="home-carousel" class="carousel slide pointer-event"
                                         data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            @foreach($carousels as $carousel)
                                                <div class="carousel-item @if($loop->first) active @endif">
                                                    <img class="d-block w-100" alt="{{ $carousel->title }}"
                                                         src="{{ $carousel->getMedia()[0]->getFullUrl() }}">
                                                    <div class="carousel-caption-background d-none d-md-block"></div>
                                                    <div class="carousel-caption d-none d-md-block">
                                                        <h3>{{ $carousel->title }}</h3>
                                                        <p>{{ $carousel->description }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <a class="carousel-control-prev" href="#home-carousel" role="button"
                                           data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#home-carousel" role="button"
                                           data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if(config('bap.home.display-prices'))
                <div class="row row-deck row-cards mb-2">
                    @foreach($symbols as $symbol)
                    <div class="col-sm-6 col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="subheader">{{ __('coins.'.$symbol->title) }}</div>
                                    <div class="ms-auto lh-1">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle text-muted" href="#" data-bs-toggle="dropdown"
                                               aria-haspopup="true" aria-expanded="false">Last 7 days</a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item active" href="#">Last 7 days</a>
                                                <a class="dropdown-item" href="#">Last 30 days</a>
                                                <a class="dropdown-item" href="#">Last 3 months</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="h1 mb-3">
                                    <img width="64px" height="64px" src="{{ asset('cryptocurrency-icons\svg\color'. '\\'.strtolower($symbol->symbol).'.svg') }}" />
                                </div>
                                <div class="d-flex mb-2">
                                    <div>{{ $symbol->price }}</div>
                                    <div class="ms-auto">
                        <span class="text-green d-inline-flex align-items-center lh-1">
                          7% <!-- Download SVG icon from http://tabler-icons.io/i/trending-up -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon ms-1" width="24" height="24"
                               viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                               stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"
                                                                                    fill="none"></path><path
                                  d="M3 17l6 -6l4 4l8 -8"></path><path d="M14 7l7 0l0 7"></path></svg>
                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif

            @if(config('bap.home.display-carousels'))
                <div class="row row-deck row-cards mb-2">
                    <div class="col-12">
                        <div class="card card-md">
                            <div class="card-stamp card-stamp-lg">
                                <div class="card-stamp-icon bg-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="icon icon-tabler icon-tabler-bell-ringing-2" width="24" height="24"
                                         viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                         stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path
                                            d="M19.364 4.636a2 2 0 0 1 0 2.828a7 7 0 0 1 -1.414 7.072l-2.122 2.12a4 4 0 0 0 -.707 3.536l-11.313 -11.312a4 4 0 0 0 3.535 -.707l2.121 -2.123a7 7 0 0 1 7.072 -1.414a2 2 0 0 1 2.828 0z"></path>
                                        <path d="M7.343 12.414l-.707 .707a3 3 0 0 0 4.243 4.243l.707 -.707"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-10">
                                        <h3 class="h1">Tabler Icons</h3>
                                        <div class="markdown text-muted">
                                            All icons come from the Tabler Icons set and are MIT-licensed. Visit
                                            <a href="https://tabler-icons.io" target="_blank"
                                               rel="noopener">tabler-icons.io</a>,
                                            download any of the 3222 icons in SVG, PNG or&nbsp;React and use them in
                                            your
                                            favourite design tools.
                                        </div>
                                        <div class="mt-3">
                                            <a href="https://tabler-icons.io" class="btn btn-primary" target="_blank"
                                               rel="noopener">Download icons</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif


            @if(config('bap.home.display-articles'))
                <div class="row row-cards row-cards mb-2">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('bap.articles') }}</h3>
                            </div>
                            <div class="list-group list-group-flush list-group-hoverable">
                                @foreach($articles as $article)
                                    <div class="list-group-item">
                                        <div href="{{ route('article.view', [$article->id]) }}"
                                             class="row align-items-center">
                                            <div class="col-auto">
                                                <a href="{{ route('article.view', [$article->id]) }}">
                                                    <span class="avatar"
                                                          style="background-image: url({{ $article->getMedia()[0]->getFullUrl() }})"></span>
                                                </a>
                                            </div>
                                            <div class="col text-truncate">
                                                <a href="{{ route('article.view', [$article->id]) }}"
                                                   class="d-block">{{ $article->title }}</a>
                                                <small
                                                    class="d-block text-muted text-truncate mt-n1">{{ $article->description }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>


</div>
