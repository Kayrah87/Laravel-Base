<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Activitylog\Models\Activity;

class DashboardComponent extends Component
{
    public function render()
    {
        $stats = [
            'users' => User::count(),
            'roles' => Role::count(),
            'permissions' => Permission::count(),
            'activities' => Activity::count(),
        ];

        $recentUsers = User::latest()->limit(5)->get();
        $recentActivities = Activity::latest()->limit(5)->get();

        return view('livewire.dashboard-component', compact('stats', 'recentUsers', 'recentActivities'));
    }
}
