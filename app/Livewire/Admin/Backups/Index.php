<?php
namespace App\Livewire\Admin\Backups;

use App\Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Index extends Component
{
    public function render()
    {
        return view('livewire.admin.backups.index')->withBackups(
            collect(Storage::disk('google')->allFiles(str_replace('_', '-', env('APP_NAME'))))
        );
    }

    #[On('download')]
    public function download(string $id)
    {
        // Define the temporary location for the downloaded file
        $zipFile = storage_path('app/backups/backupDownload.zip');

        // Download the file from Google Drive to local storage
        $fileContent = Storage::disk('google')->get($id);
        file_put_contents($zipFile, $fileContent);

        // Check if the file exists in the local storage
        if (Storage::disk('local')->exists('backups/backupDownload.zip')) {
            // Return the file as a downloadable stream response
            return response()->stream(function () use ($zipFile) {
                $stream = fopen($zipFile, 'r');
                fpassthru($stream);
                fclose($stream);

                // Delete the file after streaming
                if (file_exists($zipFile)) {
                    unlink($zipFile);
                }
            }, 200, [
                "Content-Type" => mime_content_type($zipFile),
                "Content-Length" => filesize($zipFile),
                "Content-Disposition" => "attachment; filename=\"" . basename($zipFile) . "\"",
            ]);
        } else {
            abort(404, "The backup file doesn't exist.");
        }
    }

    #[On('restore')]
    public function restore(string $id)
    {
        if(str_contains(dirname($id), 'images')){
            return $this->restoreImages(id : $id);
        }else{
            $this->toasterError(__("Could not restore database."));
            //return $this->restoreDB(id : $id);
        }
    }

    public function restoreImages(string $id)
    {
        $name = str_replace('_', '-', env('APP_NAME'));
        try {
            $zipFile = storage_path('app/backups/backupImages.zip');

            // Ensure the backup directory exists
            if (!is_dir(dirname($zipFile))) {
                mkdir(dirname($zipFile), 0777, true);
            }

            // Download the image zip file from Google disk
            $fileContent = Storage::disk('google')->get($id);
            file_put_contents($zipFile, $fileContent);

            $extractPath = storage_path('app/images');

            $zip = new ZipArchive;

            if ($zip->open($zipFile) === TRUE) {
                // Extract the zip file to the temporary directory
                $zip->extractTo($extractPath);
                $zip->close();


                // // Clean up: delete the temporary extraction directory
                if (file_exists($zipFile)) {
                    unlink($zipFile);
                }

                $this->toasterSuccess(__("Images restored successfully."));
            } else {
                $this->toasterError(__("Could not restore images."));
            }
        } catch (\Exception $e) {
            $this->error($e);
        }
    }
}
