   <!-- Modal -->
   <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
       aria-labelledby="staticBackdropLabel" aria-hidden="true">
       <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="staticBackdropLabel">Vote</h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                   <form method="POST" action="/submit-vote">
                       <div class="form-check">
                           <input class="form-control" type="hidden" name="election" value="{{$election_id}}">
                       </div>
                       <div class="mb-3">
                           <label class="form-label">Name</label>
                           <input type="text" class="form-control" name="name">
                       </div>
                       <div class="mb-3">
                           <label class="form-label">Email</label>
                           <input type="text" class="form-control" name="email">
                       </div>
                       {{csrf_field()}}
                       @foreach($data->contestants as $contestant)
                       <div class="form-check">
                           <input required class="form-check-input" type="radio" name="contestant"
                               value="{{$contestant->id}}" id="contestant">
                           <label class="form-check-label" for="flexRadioDefault1">
                               {{$contestant->name}}
                           </label>
                       </div>
                       @endforeach
                   </form>
               </div>
               <div class="modal-footer">
                   <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                   <button type="submit" class="btn btn-primary">Submit Vote</button>
               </div>
           </div>
       </div>
   </div>