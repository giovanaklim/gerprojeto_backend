<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Str;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $faker;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->faker = \Faker\Factory::create();
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpUsers();
    }

    protected function setUpUsers()
    {
        User::flushEventListeners();
        $this->testUsers['customer'] = $this->createCustomerUser();
    }

    /**
     * Creates a Pagabo Client user and uses it as the current user in the test run
     *
     * @param array $clientParams Specific Client data to use in the factory
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    protected function loginCustomer($customerParams = [])
    {
        $this->actingAs($this->testUsers['customer'], 'sanctum');
        return $this->testUsers['customer'];
    }

    public function createCustomerUser()
    {
        return User::factory()->create([
            'id' => Str::uuid()->toString()
        ]);
    }
}
