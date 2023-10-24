<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Task</title>
  </head>
  <body>
   <div class="container">
    <div class="row mb-3">
      <div class="mb-3 mt-4">
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#taskModal">
            Create Task
          </button>
      </div>
          
    </div>
    <div class="row">
        <table class="table">
            <thead>
                
              <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    
               
              <tr>
                <th scope="row">{{$task->id}}</th>
                <td>{{$task->title}}</td>
                <td>{{$task->description}}</td>
                <td>
                    <button type="button"  class="btn btn-success btn-sm ml-1 edit-btn" value="{{$task->id}}" id="editBtn" data-task-id="{{ $task->id }}">
                        Edit
                      </button>
                      <button type="button"  class="btn btn-danger btn-sm ml-1 delete-btn" value="{{$task->id}}" id="deleteBtn" data-task-id="{{ $task->id }}">
                        Delete
                      </button>
                    
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          {{$tasks->links()}}
    </div>



    <div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="taskModalLabel">Create Task</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="{{ route('task.store') }}" method="POST">
                @csrf
               
                <div class="mb-3">
                  <label for="title" class="form-label">Title</label>
                  <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="mb-3">
                  <label for="description" class="form-label">Description</label>
                  <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-sm">Create</button>
              </form>
            </div>
          </div>
        </div>
      </div>

      {{-- edit modal --}}
      <div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="taskModalLabel">Edit Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="{{url('task/update')}}" method="POST">
                      @csrf
                      <input type="hidden" id="task_id" name="task_id" value="">
                      <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="task_title" name="task_title" value="">

                      </div>
                      <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="task_description" name="task_description" rows="3"></textarea>
                      </div>
                      <button type="submit" class="btn btn-primary btn-sm">Update</button>
                    </form>
                  </div>
            </div>
        </div>
    </div>
    
      
   </div>

   <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
   
    <script>
        // Event listener for the "Edit" buttons
document.querySelectorAll('.edit-btn').forEach(function(button) {
    button.addEventListener('click', function() {
        const taskId = button.getAttribute('data-task-id');
        let editingTask = null;
        var task_id= $(this).val();

           
        var url = "task/"+ taskId;
       
        $.get(url , function (data) {
            //success data
            $('#task_id').val(data.id);
            $('#task_title').val(data.title);
            $('#task_description').val(data.description);
            $(editTaskModal).modal('show');
        }) 
 
    });
});
$(".delete-btn").click(function(){
        // alert('ff');
// function myConfirm(){    
    var result = confirm("Are you really want to delete this item?");
    if(result){
      var task_id= $(this).val();
    	// alert("hi");
      // document.querySelectorAll('.delete-btn').forEach(function(button) {
    // ('body').addEventListener('click','.delete-btn', function() {
      // document('body').on('click','.delete-btn', function() {
     

        // alert(task_id);
   
        var url = "delete-task/"+ task_id;
       
        $.ajax({
            type: 'DELETE',
            url: url,
              headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
            success: function(response) {
                // Handle the success response here
                confirm('Data Deleted Succcessfully');
                location.reload();
                
            },
            error: function(response) {
                // Handle the error response here
                console.log(response);
            }
        });
 
// });

        
    }
  // }
  });


    </script>
  </body>
</html>