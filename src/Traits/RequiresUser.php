<?php

namespace Codictive\Cms\Traits;

use Codictive\Cms\Models\User;

trait RequiresUser
{
    /**
     * @var User
     */
    protected $user;

    public function __construct()
    {
        $this->user = currentUser();
        if (! $this->user) {
            $store = request()->session();
            $store->put('next', request()->url());
            $store->put('info', 'ابتدا به حساب کاربری خود وارد شوید.');
            $store->save();

            $response = response()->redirectToRoute('auth.show_login_form');
            $response->setSession($store);

            return $response->send();
        }
    }
}
