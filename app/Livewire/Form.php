<?php
namespace App\Livewire;
use Livewire\Form as BaseForm;

class Form extends BaseForm
{
    public function error(\Exception $e){
        return ([
            'status' => 'error',
            'message' => "Something went wrong. {$e->getMessage()}",
        ]);
    }
}