<?php

namespace App\Repositories;

use App\User;
use App\Traits\Queryable;
use App\Contracts\UserInterface;

class UserRepository implements UserInterface
{
    use Queryable;

    /**
     * @var \App\User
     */
    protected $user;

    /**
     * Create a new repository instance.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param  string  $q
     * @return \App\User
     */
    public function searchUsers(string $q)
    {
        return $this->user->search($q)->paginate($this->paginate);
    }

    /**
     * @param  array  $queries
     * @return \App\User
     */
    public function getUsers(array $queries = [])
    {
        $this->castQueries($queries);

        return $this->user->where($this->where)->paginate($this->paginate);
    }

    /**
     * @param  int  $id
     * @param  array  $queries
     * @return \App\User
     */
    public function getUser(int $id, array $queries = [])
    {
        $this->castQueries($queries);

        return $this->user->where($this->where)->with($this->with)->findOrFail($id);
    }

    /**
     * @param  array  $request
     * @return \App\User
     */
    public function storeUser(array $request)
    {
        $user = $this->user->firstOrCreate($request);

        $user->shouldBeSearchable();

        return $user;
    }

    /**
     * @param  int  $id
     * @param  array  $request
     * @return \App\User
     */
    public function updateUser(int $id, array $request)
    {
        $user = $this->user->find($id);

        $user->update($request);

        return $user;
    }

    /**
     * @param  int  $id
     * @return \App\User
     */
    public function destroyUser(int $id)
    {
        $user = $this->user->find($id);

        $user->delete();

        return $user;
    }
}
