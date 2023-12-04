<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>moveon</title>
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">  
    <link href="https://use.fontawesome.com/releases/v6.5.0/css/all.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary navigation">
        <div class="container-fluid">
          <a class="navbar-brand" href="{{ route('tasks.index') }}">Move_on</i></a>
          <!-- Right Side Of Navbar -->
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{ route('user_posts', ['user'=> Auth::user()->id]) }}">profile</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('tasks.create') }}">post</a>
              </li>
            </ul>
            <ul class="navbar-nav ms-auto">
              <!-- Authentication Links -->
              @guest
                  @if (Route::has('login'))
                      <li class="nav-item">
                          <a class="nav-link" href="">{{ __('Login') }}</a>
                      </li>
                  @endif

                  @if (Route::has('register'))
                      <li class="nav-item">
                          <a class="nav-link" href="">{{ __('Register') }}</a>
                      </li>
                  @endif
              @else
                  <li class="nav-item dropdown">
                      <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                          {{ Auth::user()->name }}
                      </a>

                      <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                          <a class="dropdown-item" href="{{ route('logout') }}"
                             onclick="event.preventDefault();
                                           document.getElementById('logout-form').submit();">
                              {{ __('Logout') }}
                          </a>

                          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                              @csrf
                          </form>
                      </div>
                  </li>
              @endguest
          </ul>
          </div>
        </div>
    </nav>
    <h2 class="show-page-title">Task Card</h2>
    <div class="own-card">
      <div class="card-flex">

        <div class="username"><a class="name" href="{{ route('tasks.profile',[$task->user->id]) }}">{{ $task->user->name }}</a>
          {{-- {{ route('show',[$task->user->id]) }} --}}</div>

        <div class="card-out">
          <img class="show-img" src="{{ asset($task->file_path) }}" alt="投稿の画像">
          {{-- <div class="handwork"> --}}
            <div class="pencil-box">
              <a class="pencil" href="{{ route('tasks.edit',$task->id) }}">✏️</a>
            </div>
            <div class="erase-box">
              <form action='' method='post'>
                @csrf
                @method('delete')
                <input type='submit' style="font-size: 33px;" value='🗑️'  class="btn" 
                {{-- jsの確認ダイヤル/ボタンをクリックすると確認表示が出る --}}
                onclick='return confirm("本当に削除しますか？");'>
              </form>
            </div>
          {{-- </div> --}}
        </div>

        <div>
          <div class="incard">
            <div>
              <h4 class="show-title"><!--タイトルルート完了-->{{ $task->title }}</h4>

              <hr>

              <p class="card-middle">{{ $task->body }}</p>
            </div> 
          </div>

          <div class="like">
            @if($task->likedBy(Auth::user())->count()>0)
              <a href="{{ route('likes.destroy', ['like_id' => $task->likedBy(Auth::user())->firstOrFail()->id, 'from_show' => true]) }}">
                {{-- <i class="fa-regular fa-thumbs-up fa-rotate-180"></i> --}}
                <i class="fa-solid fa-thumbs-up"></i>
              </a>
            @else 
              <a href="{{ route('likes.store', ['task_id' => $task->id, 'from_show' => true]) }}">
                <i class="far fa-thumbs-up"></i>
              </a>
            @endif
            <div class="count">{{ $task->likes->count() }}</div>
          </div>

        </div>
      </div>

      

      <div class="comment-box">
        <p class="dratft">ここにコメント打ち込む</p>
        <div class="row justify-content-center comment-btn-margin">
          <div class="col-md-8 comment-div">
            <button type="button" class="comment-btn" onclick="location.href=''">comment</button>
                    {{-- {{ route('comments.create', $tasks->id) }} --}}
                    {{-- btn btn-primary --}}
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-md-8 mt-5">
              <p>comment list</p>
              {{-- @foreach($tasks->comments as $comment) --}}
                <div class="card mt-3">
                    <h5 class="card-header">poster：</h5>
                    {{-- {{ $comment->user->name }} --}}
                    <div class="card-body">
                        <p class="card-text"></p>
                        {{-- {{ $comment->body }} --}}
                        <p class="card-title">created at：</p>
                        {{-- {{ $comment->created_at }} --}}
                    </div>
                </div>
              {{-- @endforeach --}}  
          </div> 
        </div>
      </div>
    </div>
</body>
</html>