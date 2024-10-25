<?php
namespace App\Livewire;
use  Livewire\Component as BaseComponent;
use Masmerise\Toaster\Toaster;

class Component extends BaseComponent
{
    public function toasterAlert(array $response){
    
        if($response['status'] == 'success'){
            $this->toasterSuccess($response['message']);
        }
        else{
            $this->toasterError($response['message']);
        }

        if(isset($response['redirect']) && $response['redirect']){
            return $this->redirect($response['redirect'], navigate: true);
        }
    }

    public function toasterSuccess(string $message){
        Toaster::success($message);
    }

    public function toasterError(string $message){
        Toaster::error($message);
    }
}