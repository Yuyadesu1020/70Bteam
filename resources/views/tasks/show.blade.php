<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>show</title>
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
          <div class="handwork">
          @if(Auth::check() && $task->user_id == Auth::user()->id) <!-- ✅ログイン者のみ編集・削除が可能 -->
            <div class="pencil-box">
              <a class="pencil" href="{{ route('tasks.edit',$task->id) }}">✏️</a>
            </div>
            <div class="erase-box">
              <form action='{{ route('tasks.destroy', $task->id) }}' method='post'>
                @csrf
                @method('delete')
                <input type='submit' style="font-size: 33px;" value='🗑️'  class="trash" 
                {{-- jsの確認ダイヤル/ボタンをクリックすると確認表示が出る --}}
                onclick='return confirm("本当に削除しますか？");'>
              </form>
            </div>
          @endif
          </div>
        </div>

        <div class="whole-card">
          <div class="incard">
            <div>
              <div class="first-row">
                <h4 class="show-title"><!--タイトルルート完了-->{{ $task->title }}</h4>
                {{-- deadlineの記述 --}}
                <p class="deadline">deadline:{{ $task->deadline }}</p>
              </div>

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

      <!-- ✅コメントする -->
      <div class="comment-area">

        <div class="">
            <form class="form" action="{{ route('tasks.store') }}" method="post">
                @csrf
                <input type="hidden" name="task_id" value="{{ $task->id }}">
            </form>
        </div> 
        <!-- ✅コメント投稿 -->
        <div class="comment-box">
          <form action="{{ route('comments.store') }}" method="post">
            @csrf
            <div class="comment-input">
              <input type="hidden" name="task_id" value="{{ $task->id }}">
              <label class="word-comment">Comment</label>
              <textarea class="text-box" placeholder="content" rows="5" name="body"></textarea>
            </div>
            <div class="big-btn-box">
              <div class="button-box">
                <button type="submit" class="btn btn-primary">add comment</button>
              </div>
            </div>
          </form>
        </div>

              <!-- ✅コメント一覧表示 -->
              <div class="comment-list">
                <div class="col-md-8 mt-5">
                  Comment List
                    @foreach ($task->comments as $comment)
                    @csrf
                     <div class="card mt-3">
                        <h5 class="card-header">Author：{{ $comment->user->name }}</h5>
                      <div class="card-body">
                        <h5 class="comment-title">Post Date：{{ $comment->created_at }}</h5>
                        <p class="comment-text">Content：{{ $comment->body }}</p>
                      </div>
                   </div>
                    @endforeach
              </div>
        </div>
      </div>
  </div>
</body>
</html>