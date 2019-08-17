<?php

namespace App\Policies;

use App\User;
use App\Appointment;
use Illuminate\Auth\Access\HandlesAuthorization;

class AppointmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any products.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(?User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the product.
     *
     * @param  \App\User  $user
     * @param  \App\Appointment  $product
     * @return mixed
     */
    public function view(?User $user, Appointment $product)
    {
        //
    }

    /**
     * Determine whether the user can create products.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the product.
     *
     * @param  \App\User  $user
     * @param  \App\Appointment  $product
     * @return mixed
     */
    public function update(User $user, Appointment $product)
    {
        return ( $user->id === $product->user->id );
    }

    /**
     * Determine whether the user can delete the product.
     *
     * @param  \App\User  $user
     * @param  \App\Appointment  $product
     * @return mixed
     */
    public function delete(User $user, Appointment $product)
    {
        //
    }

    /**
     * Determine whether the user can restore the product.
     *
     * @param  \App\User  $user
     * @param  \App\Appointment  $product
     * @return mixed
     */
    public function restore(User $user, Appointment $product)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the product.
     *
     * @param  \App\User  $user
     * @param  \App\Appointment  $product
     * @return mixed
     */
    public function forceDelete(User $user, Appointment $product)
    {
        //
    }
}
