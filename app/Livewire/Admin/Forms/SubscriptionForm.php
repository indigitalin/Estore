<?php

namespace App\Livewire\Admin\Forms;

use App\Models\Plan;
use Exception;
use Illuminate\Validation\Rule;
use \App\Livewire\Form;
use App\Models\ModulePlan;

class SubscriptionForm extends Form
{

    public ?Plan $plan = null;
    public string|null $name = null;
    public string|null $amount = null;
    public string|null $status;
    public string|null $description = null;
    public string|null $popular = null;
    public string|null $validity = null;
    public array|null $modules;


    public function setSubscription(?Plan $plan = null): void
    {
        $this->plan     = $plan;
        $this->name     = $plan->name;
        $this->amount   = $plan->amount;
        $this->status   = $plan->status;
        $this->description = $plan->description;
        $this->popular  = $plan->popular;
        $this->validity = $plan->validity;
        $this->modules  = $plan->plan_modules->pluck('id')->toArray();
    }

    public function save()
    {
        $this->validate();

        try {
            /**
             * Create plan if action is to create
             */
            if (!$this->plan) {
                // Create a new plan if it doesn't exist
                $plan = $this->plan = Plan::create(
                    $this->only(['name', 'description', 'amount', 'status', 'popular', 'validity'])
                );
            } else {
                // Update the existing plan and retain the plan object
                $this->plan->update(
                    $this->only(['name', 'description', 'amount', 'status', 'popular', 'validity'])
                );
                $plan = $this->plan;  // Keep the reference to the updated Plan object
            }
            
            // Delete existing ModulePlan entries for the current Plan
            ModulePlan::where('plan_id', $plan->id)->delete();
            
            // Create new ModulePlan entries based on $this->modules
            foreach ($this->modules ?? [] as $moduleId) {
                ModulePlan::create([
                    'plan_id' => $plan->id,
                    'module_id' => $moduleId,
                ]);
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
