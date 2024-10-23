<?php
namespace App\Livewire;
use  Livewire\Component as BaseComponent;
use Masmerise\Toaster\Toaster;

class Component extends BaseComponent
{
    public function toasterAlert(array $response){
    
        if($response['status'] == 'success'){
            Toaster::success($response['message']);
        }
        else{
            Toaster::error($response['message']);
        }

        if(isset($response['redirect']) && $response['redirect']){
            return $this->redirect($response['redirect'], navigate: true);
        }
    }

}