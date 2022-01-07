<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <style>
    .container{
    width:50%;
    }
    </style>
  </head>
  <body>
    <div class="container">
 
      <form action="{{ route('posts.update', $post->id) }}" method="POST" name="update_post">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
 
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <strong>Featured Image</strong>
                    <input type="file" name="fImage" class="form-control">
                    <span class="text-danger">{{ $errors->first('fImage') }}</span>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <strong>Title</strong>
                    <input type="text" name="title" value="{{$post->title}}" class="form-control" placeholder="Enter Title">
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <strong>Description</strong>
                    <textarea class="form-control" col="4" name="description" placeholder="Enter Description">{{$post->description}}</textarea>
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                </div>
            </div>
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
 
      </form>
 
    </div>
  </body>
</html>