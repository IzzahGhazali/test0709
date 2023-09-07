<div>
  
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
  
    @if($updateMode)
        @include('livewire.update')
    @else
        @include('livewire.create')
    @endif
  
    <table class="table table-bordered mt-5">
        <thead>
            <tr>
                <th>No.</th>
                <th>Title</th>
                <th>Body</th>
                <th>created at</th>
                <th>updated at</th>
                <th width="150px">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $key => $post)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $post->title }}</td>
                <td>{{ $post->body }}</td>
                <td>{{ $post->created_at }}</td>
                <td>{{ $post->updated_at }}</td>
                <td>
                <button wire:click="edit({{ $post->id }})" class="btn btn-primary btn-sm">Edit</button>
                    <button wire:click="alertConfirm({{ $post->id }})" class="btn btn-danger btn-sm">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @push('js')


<script>
  
window.addEventListener('swal:modal', event => { 
    Swal.fire({
      title: event.detail.message,
      text: event.detail.text,
      icon: event.detail.type,
    });
});
  
window.addEventListener('swal:confirm', event => { 
    Swal.fire({
      title: event.detail.message,
      text: event.detail.text,
      icon: event.detail.type,
      showCancelButton: true,
      // buttons: true,
      // dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete.value) {
        @this.call('delete',event.detail.itemId)
      }else {
        @this.call('cancel')
      }
    });
});
 </script>


    @endpush

</div>