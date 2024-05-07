<?php

namespace App\Repositories;

use App\Exceptions\CannotDeleteMyself;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserRepository implements IUserRepository
{
    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
        $user = new User;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = $data['password'];
        $user->department_id = $data['department_id'];
        $user->save();

        $user->assignRole($data['role']);


        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function update($userId, array $data)
    {
        $user = User::find($userId);
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->department_id = $data['department_id'];
        $user->syncRoles([$data['role']]);
        $user->update();

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($userId)
    {
        $myUserId = Auth::user()->id;
        if ($myUserId != $userId) {
            $user = User::find($userId);
            $user->delete();
        } else {
            throw new CannotDeleteMyself();
        }
    }
}
