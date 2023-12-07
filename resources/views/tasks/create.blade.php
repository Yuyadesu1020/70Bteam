<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>post</title>
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">  
    <link href="https://use.fontawesome.com/releases/v6.5.0/css/all.css" rel="stylesheet">
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
                <a class="nav-link active" aria-current="page" href="{{ route('user_posts', ['user'=> Auth::user()->id]) }}">profile</a>
              </li>
              {{-- <li class="nav-item">
                <a class="nav-link" href="{{ route('tasks.create') }}">post</a>
              </li> --}}
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

    <h2 class="create-title">What's your plan?</h2>
    <div class="create-page">
        <div class="create-form">
            <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="title">
                    <div>
                        <label for="" class="label-title">Schedule : </label>
                        <input type="text" class="title-form" placeholder="Put your title" name="title">
                        {{-- ✅エラー文表示 --}}
                        @error('body')
                        <p class="text-red-500" style="color: red;">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- deadlineの記述 --}}
                    <div class="deadline-box">
                        <label for="deadline" class="dead-letter">Deadline : </label>
                        <input type="date" name="deadline" class="option-date" id="deadline">
                    </div>
                </div>

                

                <div class="form-content">
                    <label class="label-content">Content : </label>
                    <textarea class="form-area" placeholder="Fill your blank" rows="5" name="body"></textarea>
                    {{-- ✅エラー文表示 --}}
                    @error('title')
                    <p class="text-red-500" style="color: red;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="create-image">
                    <!-- 投稿する画像を表示 -->
                    <div class="show">  
                        
                        <div>
                            <img id="currentImage" src="{{ asset($task->file_path) }}" alt="Choose your image" class="old-image">
                        </div>
                         <!-- 新しい画像をアップロードするためのファイル選択 -->
                         <div class="new-image">
                            <label for="postimage" class="imagine">{{ __('プロフィール画像（サイズは1024Kbteまで）') }}</label>
                            <div class="select">
                                <label for="postimage" class="camera-image">📷 : </label>
                                <input type="file" id="postimage" name="postimage" style="display: none;">
                                <button class="select-image" id="openDialog">Image</button>
                            </div>
                        </div>
                        {{-- ✅エラー文表示 --}}
                        @error('postimage')
                        <p class="text-red-500" style="color: red;">{{ $message }}</p>
                        @enderror
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const newImageInput = document.getElementById('postimage');
                            const currentImage = document.getElementById('currentImage');
                            const openDialogButton = document.getElementById('openDialog');
                    
                            openDialogButton.addEventListener('click', function(event) {
                                event.preventDefault(); // デフォルトの挙動を停止
                                newImageInput.click(); // ファイル選択ダイアログを開く
                            });
                    
                            newImageInput.addEventListener('change', function(event) {
                                const selectedFile = event.target.files[0];
                                const reader = new FileReader();
                    
                                reader.onload = function(e) {
                                    currentImage.src = e.target.result; // 新しい画像を投稿する画像に反映
                                };
                    
                                reader.readAsDataURL(selectedFile);
                            });
                        });
                    </script>
                </div>
                <div class="submit-box">
                    <button type="submit" class="post-btn">post</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>