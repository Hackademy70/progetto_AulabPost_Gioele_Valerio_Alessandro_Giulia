<x-layout>

    <div class="container-fluid p-5 text-center text-dark">
        <div class= "row justify-content-center">
            <h1 class="fs-3">
                {{$article->title}}
            </h1>
        </div>
    </div>


    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <img src="{{ Storage::url($article->image) }}" class="img-fluid my-3 showImg" alt="">
            </div>
            <div class="col-12">
                <h4 class=" my-3 fs-4">{{ $article->subtitle }}</h4>
            </div>
            <div class="col-12">
                <p class="fs-5">{{$article->body}}</p>
            </div>
            <div class="col-12 d-flex justify-content-between">

                <p class="fs-6 ">Redatto da <span class="text-muted fst-italic">{{$article->user->name}}</span>  il <span class="text-muted fst-italic">{{$article->created_at->format('d/m/Y')}}</span></p>
                <p class="fs-6 fst-italic text-capitalize mx-2">
                    @foreach ($article->tags as $tag)
                        #{{ $tag->name }}
                    @endforeach
                </p>

            </div>
        </div>
    </div>
    <div class="text-center">
        <a href="{{route('article.index')}}" class="btn btn-dark text-white my-3">Torna Alla Home</a>
        @if (Auth::user() && Auth::user()->is_revisor)
        <a href="{{ route('revisor.acceptArticle', compact('article'))}}" class="btn btn-success text-white my-3 mx-2">Accetta articolo</a>
        <a href="{{ route('revisor.rejectArticle', compact('article'))}}" class="btn btn-danger text-white my-3">Rifiuta articolo</a>
    @endif
    </div>

    </x-layout>
