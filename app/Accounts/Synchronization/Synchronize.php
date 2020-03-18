<?php

class Synchronization
{
    protected $account;

    protected $user;

    public function __construct(Account $account, User $user)
    {
        $this->account = $account;

        $this->user = $user;
    }

    public function changesAfter($timestamp)
    {
    }

    public function receiveLocalChanges()
    {
    }
}
