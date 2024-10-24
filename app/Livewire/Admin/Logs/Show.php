<?php
namespace App\Livewire\Admin\Logs;

use Livewire\Component;
use Illuminate\Support\Facades\File;

class Show extends Component
{
    public $log;
    public $fileName;
    
    public \App\Livewire\Admin\Forms\UserForm $form;
    
    public function mount($log): void
    {
    
        $filePath = storage_path('logs/exceptions/' . $log);
  
        // Check if the file exists
        if (!File::exists($filePath)) {
            abort(404);
        }

        // Read the content of the file
        $content = File::get($filePath);
            $this->fileName = $log;
            $this->log = $content;
       
    }


    public function render()
    {
  
        return view('livewire.admin.logs.show');
    }
}
