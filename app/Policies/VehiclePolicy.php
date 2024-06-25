<?php
    
    namespace App\Policies;
    
    use App\Models\User;
    use App\Models\Vehicle;
    use Illuminate\Auth\Access\HandlesAuthorization;
    
    class VehiclePolicy {
        use HandlesAuthorization;
        
        public function viewAny(User $user)
        {
        
        }
        
        public function view(User $user, Vehicle $vehicle){}
        
        public function create(User $user){}
        
        public function update(User $user, Vehicle $vehicle){}
        
        public function delete(User $user, Vehicle $vehicle){}
        
        public function restore(User $user, Vehicle $vehicle){}
        
        public function forceDelete(User $user, Vehicle $vehicle){}
    }
