<?php
namespace App\Livewire;
use  Livewire\Component as BaseComponent;
use Masmerise\Toaster\Toaster;

class Component extends BaseComponent
{

    public function ToasterAlert(array $msg){
       
        if($msg['status'] == 'success'){
            Toaster::success($msg['message']);
        }
        else{
            Toaster::error($msg['message']);
        }
    }


}