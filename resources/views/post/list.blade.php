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
            <div class="col-12">
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
                     <th>Operations</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($posts as $post)
                  <tr>
                     <td>{{ $post->id }}</td>
                     <td>{{ $post->title }}</td>
                     <td>{{ $post->slug }}</td>
                     <td>{{ $post->description }}</td>
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
               </tbody>
              </table>
              {!! $posts->links() !!}
           </div> 
      </div>
    </div>
  </body>
</html>