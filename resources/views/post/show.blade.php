<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Post - List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <style>
    /* body{
    background-color: #25274d;
    }
    .container{
    background: #ff9b00;
    padding: 4%;
    border-top-left-radius: 0.5rem;
    border-bottom-left-radius: 0.5rem;
    width:50%;
    } */
    </style>
  </head>
  <body>
    <div class="container">
      <div class="row">
            <div class="col-12">
             <div class="list-group">
              <a href="#" class="list-group-item list-group-item-action flex-column align-items-start active">
                  <h5 class="mb-1">{{$post->title}}</h5>
                  <small>Posted By: {{$post->user->name}}</small>
                  <small>{{$post->created_at}}</small>
                <p class="mb-1">{{$post->description}}</small>
              </a>
            </div>
             
           </div> 
      </div>
    </div>
  </body>
</html>