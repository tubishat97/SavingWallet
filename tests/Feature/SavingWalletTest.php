<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SavingWalletTest extends TestCase
{
    use  RefreshDatabase;

    /** @test */
    function guests_may_not_create_a_wallet()
    {
        $this->get('/')
            ->assertRedirect('admin/login');
    }

    /** @test */
    protected function signIn($user = null)
    {
        $user = $user ?: factory(User::class)->create();

        $this->actingAs($user);

        return $this;
    }
}
