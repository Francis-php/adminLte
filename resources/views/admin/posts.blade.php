@extends('adminlte::page')
@section('usermenu_body')
    <a class="btn btn-default btn-flat float-right btn-block" href="{{ route('profile') }}">
        <i class="fas fa-fw fa-user"></i>
        Profile
    </a>
@endsection

@section('content')

    <div class="col-12 text-center">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-md-9">
            <h3>Posts</h3>
            <div class="row">
                @foreach($posts as $post)
                    @if($post->start_date > now())
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Title: {{ $post->title }}</h5>
                                    <p class="card-text">Description: {{ $post->description }}</p>
                                    <h5 class="card-text">Agency:
                                        <a href="{{ route('show-agency', $post->user->id) }}">{{ $post->user->name }}</a>
                                    </h5>
                                    <p class="card-text">Price: {{ $post->price }} $</p>
                                    <p class="card-text">Total tickets: {{ $post->tickets }}</p>
                                    <p class="card-text">Tickets available: {{ $post->tickets - $post->users()->sum('tickets') }}</p>
                                    <div class="row">
                                        @foreach($post->images as $image)
                                            <div class="col-md-4">
                                                <img src="{{ $image->path }}" class="img-fluid" alt="Image">
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class="card-text">Start date: {{ $post->start_date }}</p>
                                        <p class="card-text">End date: {{ $post->end_date }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between"><h5 class="card-title">Title: {{ $post->title }}</h5><h5>Completed</h5></div>
                                    <p class="card-text">Description: {{ $post->description }}</p>
                                    <h5 class="card-text">Agency:
                                        <a href="{{ route('show-agency', $post->user->id) }}">{{ $post->user->name }}</a>
                                    </h5>
                                    <p class="card-text">Price: {{ $post->price }} $</p>
                                    <p class="card-text">Tickets sold: {{ $post->users()->sum('tickets') }}</p>
                                    <p class="card-text">Earnings: {{ $post->users()->sum('cost') }} $</p>
                                    <div class="row">
                                        @foreach($post->images as $image)
                                            <div class="col-md-4">
                                                <img src="{{ $image->path }}" class="img-fluid" alt="Image">
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class="card-text">Start date: {{ $post->start_date }}</p>
                                        <p class="card-text">End date: {{ $post->end_date }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>


        <div class="col-md-3">
            <br>
            <form action="{{ route('admin-show-posts') }}" method="GET">
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter title"
                               value="{{ $request->input('title') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="start_date">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date"
                               value="{{ $request->input('start_date') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="end_date">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date"
                               value="{{ $request->input('end_date') }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <label for="agency">Agency</label>
                        <select class="form-control" id="agency" name="agency">
                            <option value="">All</option>
                            @foreach($agencies as $agency)
                                <option value="{{ $agency->id }}" {{ $request->input('agency') === (string)$agency->id ? 'selected' : '' }}>
                                    {{ $agency->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="">All</option>
                            <option value="active" {{ $request->input('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="completed" {{ $request->input('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="sort_by">Sort By</label>
                        <select class="form-control" id="sort_by" name="sort_by">
                            <option value="">None</option>
                            <option value="name_asc" {{ $request->input('sort_by') === 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                            <option value="name_desc" {{ $request->input('sort_by') === 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
                            <option value="start_date_asc" {{ $request->input('sort_by') === 'start_date_asc' ? 'selected' : '' }}>Start Date (Ascending)</option>
                            <option value="start_date_desc" {{ $request->input('sort_by') === 'start_date_desc' ? 'selected' : '' }}>Start Date (Descending)</option>
                        </select>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Filter</button>
                <a href="{{route('admin-show-posts')}}" class="ml-2">x Clear Filters</a>
            </form>

            <div class="d-flex justify-content-center my-4">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        {{ $posts->links() }}
                    </ul>
                </nav>
            </div>
            <div class="text-center"><p >Showing {{ $posts->firstItem() }} to {{ $posts->lastItem() }} of {{ $posts->total() }} entries</p></div>


        </div>
    </div>





@endsection
