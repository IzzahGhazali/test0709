<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;

class Posts extends Component
{

    public $posts, $title, $body, $post_id;
    public $updateMode = false;


    protected $listeners = ['remove'];
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function render()
    {
        $this->posts = Post::all();
       

        // dd($this->posts);
        return view('livewire.posts');
    }
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function resetInputFields(){
        $this->title = '';
        $this->body = '';
    }
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function store()
    {
        $validatedData = $this->validate([
            'title' => 'required',
            'body' => 'required',

            // insert text format email
//            'body' => 'required|email',

        ]);
  
        Post::create($validatedData);
  
       // session()->flash('message', 'Post Created Successfully.');
  
        $this->dispatchBrowserEvent('closeModal');
        $this->resetInputFields();
        $this->alertSuccess();
      }
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $this->post_id = $id;
        $this->title = $post->title;
        $this->body = $post->body;
  
        $this->updateMode = true;
    }
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function update()
    {
        $validatedDate = $this->validate([
            'title' => 'required',
            'body' => 'required',
        ]);
  
        $post = Post::find($this->post_id);
        $post->update([
            'title' => $this->title,
            'body' => $this->body,
        ]);
  
        $this->updateMode = false;
  
       // session()->flash('message', 'Post Updated Successfully.');
        $this->dispatchBrowserEvent('closeModal');
        $this->resetInputFields();
        $this->alertSuccess();
    }
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete($id)
    {
        //dd($id);
        Post::find($id)->delete();

        //session()->flash('message', 'Post Deleted Successfully.');
    }

     /**
     * Write code on Method
     *
     * @return response()
     */
    public function alertSuccess()
    {
        
        $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',  
                'message' => 'Welldone! Created Successfully!', 
                'text' => 'It will list on table soon.'
            ]);
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function alertConfirm($id)
    {
        $this->dispatchBrowserEvent('swal:confirm', [
                'type' => 'warning',  
                'message' => 'Are you sure?', 
                'text' => 'If deleted, you will not be able to recover this imaginary file!',
                'itemId' => $id
            ]);
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function remove()
    {
        /* Write Delete Logic */
        $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',  
                'message' => 'User Delete Successfully!', 
                'text' => 'It will not list on users table soon.'
            ]);
    }
}
