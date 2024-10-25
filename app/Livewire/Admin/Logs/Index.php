<?php
namespace App\Livewire\Admin\Logs;

use App\Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Pagination\LengthAwarePaginator;
class Index extends Component
{
    use WithPagination;
    private const FILES_PER_PAGE = 5;

    public function render()
    {
       
        $files = File::files(storage_path('logs/exceptions'));

        // Get the filenames only
        $fileNames = array_map(function ($file) {
            return $file->getFilename();
        }, $files);

        // Create a LengthAwarePaginator
        $currentPage = request()->get('page', 1);
        $perPage = self::FILES_PER_PAGE; // Reference the constant correctly
        $currentPageItems = array_slice($fileNames, ($currentPage - 1) * $perPage, $perPage);
        $filelists = new LengthAwarePaginator($currentPageItems, count($fileNames), $perPage, $currentPage, [
            'path' => request()->url(),
            'query' => request()->query(),
        ]);

        $files = File::files(storage_path('logs/exceptions'));

        // Get the filenames and their modification times
        $fileNames = [];
        foreach ($files as $file) {
            $fileNames[] = [
                'name' => $file->getFilename(),
                'modified' => $file->getMTime(), // Get the modification time
            ];
        }

        // Sort files by modification time in descending order
        usort($fileNames, function ($a, $b) {
            return $b['modified'] <=> $a['modified']; // Descending order
        });

        // Extract only the file names for pagination
        $fileNamesOnly = array_column($fileNames, 'name');

        // Create a LengthAwarePaginator
        $currentPage = request()->get('page', 1);
        $perPage = self::FILES_PER_PAGE;
        $currentPageItems = array_slice($fileNamesOnly, ($currentPage - 1) * $perPage, $perPage);
        $filelists = new LengthAwarePaginator($currentPageItems, count($fileNamesOnly), $perPage, $currentPage, [
            'path' => request()->url(),
            'query' => request()->query(),
        ]);


        return view('livewire.admin.logs.index',compact('filelists'));
    }

    #[On('destroy')]
    public function destroy(string $id){
    
        $filename = $id.'.html';
        $filePath = storage_path('logs/exceptions/' . $filename);
        // Check if the file exists
        if (File::exists($filePath)) {
            File::delete($filePath);
        }

        $this->toasterSuccess(__("Log file deleted successfully."));
    }
    #[On('destroy_all')]

    public function destroy_all(string $id){
    
        $files = File::files(storage_path('logs/exceptions'));
        
        foreach ($files as $file) {
            File::delete($file->getPathname()); // Delete each file
        }


        $this->toasterSuccess(__("All Log files are deleted successfully."));
    }
}
