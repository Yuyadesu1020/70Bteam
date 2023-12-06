<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>moveon</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">  
    <link href="https://use.fontawesome.com/releases/v6.5.0/css/all.css" rel="stylesheet">
    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
          <a class="navbar-brand" href="{{ route('tasks.index') }}">Move_on</a>
          <!-- Right Side Of Navbar -->
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                @auth
                  <a class="nav-link active" aria-current="page" href="{{ route('user_posts', ['user'=> Auth::user()->id]) }}">profile</a>
                 {{-- user_postsにルートを繋げて、userの定義をする --}}
                @endauth
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
  
    <div class="pageface">
      <div class="card-head" style="opacity: 0.9">? What to do ?</div>

          @foreach($tasks as $task)

        <div class="form-index">
          <div class="username list">
            {{-- <a href="{{ route('show',[$task->user->id]) }}">{{ Auth::user()->name }}</a> --}}
            @if($task->user) <!-- $taskに関連付けられたユーザー情報が存在するかを確認 -->
              <a class="eachname" href="{{ route('tasks.profile',[$task->user->id]) }}">{{ $task->user->name }}</a>
            @else
              <span>ユーザー情報なし</span> <!-- ユーザー情報がない場合の代替表示 -->
            @endif
          </div>
        </div>

        <div class="word-form">  
          <div class="imageandpost" onclick="redirectToDetailPage('{{ $task->id }}')">
                  <div class="move-box">
                    @if($task->file_path) 
                        <img src="{{ asset($task->file_path) }}" alt="" class="samplepic">
                        @else
                        <div class="no-image"></div>
                        @endif 
                  </div>
            
                <div class="card-boxes">  
                    <div class="posttitle-box">   
                      <p class="post-title" href="">{{ $task->title }}</p>
                      {{-- deadlineの記述   --}}
                      <p class="dead-box">Until:{{ $task->deadline }}</p>
                    </div>  

                    <div class="postcontents">
                      <div class="postcontent list">{{ $task->body }}</div>
                        <div class="click-btn">
                          <div class="like">
                            @if($task->likedBy(Auth::user())->count()>0)
                              <a href="{{ route('likes.destroy', ['like_id' => $task->likedBy(Auth::user())->firstOrFail()->id, 'from_index' => true]) }}">
                                  <i class="fa-solid fa-thumbs-up"></i>
                              </a>
                            @else
                              <a href="{{ route('likes.store', ['task_id' => $task->id, 'from_index' => true]) }}">
                                  <i class="far fa-thumbs-up"></i>
                              </a>
                            @endif
                            <div class="count">{{ $task->likes->count() }}</div>
                          </div>

                          <div class="trash-card">
                            <div class="destroy-btn">
                              @if($task->user_id == Auth::user()->id)  <!-- ✅ログイン者のみ消去ボタン表示させる -->
                              <form action="{{ route('tasks.destroy',$task->id) }}" method="post">
                                @csrf
                                @method('delete')
                                  <input type="submit" class="trash" value="🗑️" onclick='return confirm("本当に削除しますか？");'>
                                </form>
                              @endif
                            </div>
                          </div>
                      </div>
                    </div>
                </div>
          </div>
        </div>
            @endforeach
    </div>
    <div class="navigation">
      {{ $tasks->links() }}
    </div>
  <script>
    function redirectToDetailPage(taskId){
        window.location.href = '/tasks/' + taskId;
    }


  </script>
</body>
</html>