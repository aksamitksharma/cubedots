<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Post - List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <style>
    </style>
  </head>
  <body>
    <div class="container">
      <a href="{{ route('posts.create') }}" class="btn btn-success mb-2">Add Post</a> <br>
      <div class="row">
        <div class="col-9">
            @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
            @endif
              <table class="table table-bordered">
               <thead>
                  <tr>
                     <th>Id</th>
                     <th>Title</th>
                     <th>Slug</th>
                     <th>Description</th>
                     <th>Tags</th>
                     <th>Operations</th>
                  </tr>
               </thead>
               <tbody>
                 @if(!$posts->isEmpty())
                  @foreach($posts as $post)
                  <tr>
                     <td>{{ $post->id }}</td>
                     <td> <img class="sealImage" src="{{  public_path('\thumbnail\\'.$post->featured_image) }}" alt="{{$post->featured_image}}" /></td>
                     
                     <td>{{ $post->title }}</td>
                     <td>{{ $post->slug }}</td>
                     <td>{{ $post->description }}</td>
                     <td>{{ $post->tags }}</td>
                     <td>

                      <button type="submit" class="btn btn-warning btn-sm mt-1 mr-1">
                       <a href="{{ url('posts',$post->slug) }}">View</a>
                      </button>

                      <button type="submit" class="btn btn-warning btn-sm mt-1 mr-1">
                       <a href="{{ url('posts/'.$post->id.'/edit') }}">Edit</a>
                      </button>

                      <form method="post" action="{{ route('posts.destroy', $post->id) }}">
                          {{ csrf_field() }}
                          {{ method_field('PUT') }}
                          <button type="submit" class="btn btn-danger btn-sm mt-1 mr-1">Delete</button>
                      </form>
                    
                    </td>
                  </tr>
                  @endforeach
                @else
                  <tr>
                    <td colspan="7">No records found!</td>
                  </tr>
                @endif
               </tbody>
              </table>
              {!! $posts->links() !!}
        </div>
        <div class="col-3">
          <h3>Tags</h3>
          @foreach($tags as $tag)
          <span class="badge bg-secondary"><a class="badge bg-secondary" href="?tag={{urldecode(trim($tag->tags))}}">{{$tag->tags}}</a> </span>
          @endforeach
        </div>
      </div>
    </div>
  </body>
</html>