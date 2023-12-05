<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>moveon</title>
    <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">  
    <link href="https://use.fontawesome.com/releases/v6.5.0/css/all.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            {{-- <a class="navbar-brand" href="#"><i class="fa-solid fa-arrow-rotate-left"></i></a> --}}
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
              <li class="nav-item">
                <a class="nav-link" href="{{ route('tasks.create') }}">post</a>
              </li>          
                {{-- <a class="nav-link" href="#">delete</a> --}}
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
    <h2 class="edit-page-title">Edit Card</h2>
    <div class="edit-page">
        <div class="delete-box">
            <form action='' method='post'>
                @csrf
                @method('delete')
                <input type='submit' style="font-size: 25px;" value='🗑️'  class="btn" 
                {{-- jsの確認ダイヤル/ボタンをクリックすると確認表示が出る --}}
                onclick='return confirm("本当に削除しますか？");'>
            </form>
        </div>
        <div class="edit-box">
            <form action="{{ route('tasks.update',$task->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="edit-title">
                    <label for="" class="label-title">Schedule  :
                    </label>
                    <input type="text" class="change-title" value="{{ $task->title }}" name="title">

                    {{-- deadlineの編集 --}}
                    <label for="">deadline:</label>
                    <input type="date" value="{{ $task->deadline }}" name="deadline">
                    
                </div>

                <div class="edit-content">
                    <label class="label-content">Content  :  </label>
                    <textarea class="change-content" rows="5" name="body" placeholder="what's your changing plan?" >{{ $task->body }}</textarea>
                    {{-- {{ $tasks->body textareaの中に}} --}}
                </div>

                <div class="edit-image">
                    {{-- <!-- 既存の画像を表示 -->
                    <img src="{{ asset($task->file_path) }}" alt="Current Image" class="old-image">
                    <!-- 新しい画像をアップロードするためのファイル選択 -->
                    <div class="new-image">
                        <label for="newImage">📷 : </label>
                        <input type="file" id="newImage" name="newImage">
                    </div> --}}
                    <!-- 既存の画像を表示 -->
                        <img id="currentImage" src="{{ asset($task->file_path) }}" alt="Current Image" class="old-image">

                        <!-- 新しい画像をアップロードするためのファイル選択 -->
                        <div class="new-image">
                            <label for="newImage">📷 : </label>
                            <input type="file" id="newImage" name="newImage" style="display: none;">
                            <button id="openDialog">画像を選択</button>
                        </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const newImageInput = document.getElementById('newImage');
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
                                    currentImage.src = e.target.result;
                                };

                                reader.readAsDataURL(selectedFile);
                            });
                        });
                    </script>
                </div>

                <div class="btn-block">
                    <button type="submit" class="btn btn-update btn-hover">Update</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>