<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
@foreach($posts as $post)
<div class="card">
    <img
      src="/storage/media/{{$post->photo->file_name}}"
      class="card-img-top"
      alt="..." width="100" height="50"
    />
     <div class="card-body">
        <h3 class="card-title">{{$post->title}}</h3>
        <p class="card-text">
                {{$post->description}}
        </p>
    </div>
</div>
@endforeach
</body>
</html>
