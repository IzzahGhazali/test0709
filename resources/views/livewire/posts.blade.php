<div>

  
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    
  
        @include('livewire.create')
   <div class="row" >
    <div class="col-md-6"></div>
       <div class="col-md-6">
           <input class="form-control search-input mt-3" wire:model.debounce.100ms="searchTerm" type="text" placeholder="carian"/>  
       </div>
   </div>

<div>
    <table class="table table-striped">
        <thead>
            @foreach ($headers as $key => $value)
                <th width="5%" style="cursor: pointer" wire:click="sort('{{ $key }}')">
                    @if($sortColumn == $key) 
                        <span>{!! $sortDirection == 'asc' ? '&#8659;':'&#8657;' !!}</span>
                    @endif
                    {{ is_array($value) ? $value['label'] : $value }}
                </th>
            @endforeach
        </thead>
        <tbody>
            @if(count($posts))
                @foreach ($posts as $item)
                    <tr>
                        @foreach ($headers as $key => $value)
                        @if($key=='action')
                        <td> 
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" wire:click="edit({{ $item->id }})">Edit</button>
               
                    <button wire:click="alertConfirm({{ $item->id }})" class="btn btn-danger btn-sm">Delete</button>
                </td>
                        @else
                            <td>
                                {!! is_array($value) ? $value['func']($item->$key) : $item->$key !!}
                            </td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            @else
                <tr><td colspan="{{ count($headers) }}"><h2>No Results Found!</h2></td></tr>
            @endif
        </tbody>
    </table>
</div>

    {{ $posts->links() }}
    @push('js')


<script>

window.addEventListener('closeModal', event => {
            document.querySelector('#exampleModal').style.display = "none";
            document.querySelector('.modal-backdrop').remove();
        })
    
  
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