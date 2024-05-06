<?php

namespace App\Repositories;

interface IUserRepository
{
    /**
     * Create a User
     *
     * @param array $data
     * @return App\Models\User
     */
    public function create(array  $data);

    /**
     * Update a User
     *
     * @param int $userId
     * @param array $data
     * @return App\Models\User
     */
    public function update($userId, array  $data);

    /**
     * Delete a User
     *
     * @param int $userId
     * @return void
     */
    public function delete($userId);
}
