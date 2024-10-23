<?php

namespace App\Livewire\Admin\Forms;

use App\Models\Plan;
use Exception;
use Illuminate\Validation\Rule;
use \App\Livewire\Form;

class SubscriptionForm extends Form
{

    public ?Plan $plan = null;
    public string|null $name = null;
    public string|null $amount = null;
    public string|null $status;
    public string|null $description = null;
    public string|null $popular = null;
    public string|null $validity = null;

    public function setSubscription(?Plan $plan = null): void
    {

        $this->plan     = $plan;
        $this->name     = $plan->name;
        $this->amount   = $plan->lastname;
        $this->status   = $plan->status;
        $this->description = $plan->description;
        $this->popular  = $plan->popular;
        $this->validity = $plan->validity;
    }

    public function save()
    {
        $this->validate();

        try {
            /**
             * Create plan if action is to create
             */
            if (!$this->plan) {
                $this->plan = Plan::create(
                    $this->only(['name', 'description', 'amount', 'status', 'popular', 'validity'])
                );
            } else {
                $this->plan->update(
                    $this->only(['name', 'description', 'amount', 'status', 'popular', 'validity'])
                );
            }
            
            return ([
                'status' => 'success',
                'message' => $this->plan->wasRecentlyCreated ? 'Plan created successfully.' : 'Plan updated successfully.',
                'redirect' => route('admin.subscriptions.index'),
            ]);

        } catch (Exception $e) {
            return $this->error($e);
        }
    }

    public function rules(): array
    {

        return [
            'name' => ['required'],
            'amount' => ['required'],
            'validity' => ['required'],
            'description' => ['nullable'],
            'popular' => ['nullable'],
            'status' => ['nullable']
        ];
    }

}
