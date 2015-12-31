<?php

use App\Apartment;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApartmentTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Setup test.
     */
    public function setUp()
    {
        parent::setUp();

        Artisan::call('migrate');
    }

    /**
     * Tests creating an apartment.
     */
    public function testItCreatesAnApartment()
    {
        $fields = $this->createApartmentFields();
        $this->createAndAuthUser()
             ->visit('/apartments/create')
             ->see('Add a New Apartment')
             ->fillOutForm($fields)
             ->seeInDatabase('apartments', $fields)
             ->see('Your Apartments');
    }

    /**
     * Tests editing an apartment.
     */
    public function testItEditsAnApartment()
    {
        $this->createAndAuthUser();

        $fields = $this->createApartmentFields();
        $apartment = Auth::user()
                     ->apartments()
                     ->create($fields)
                     ->toArray();

        $fields['name'] = 'Test Edit Apartment';

        $this->visit("/apartments/{$apartment['id']}/edit")
             ->see('Edit An Apartment')
             ->fillOutForm($fields)
             ->seeInDatabase('apartments', $fields)
             ->see('Your Apartments');
    }

    /**
     * Tests user is authenticated when creating an apartment.
     */
    public function testItForcesUsersToAuthenticateToCreateAnApartment()
    {
        $this->visit('/apartments/create')
             ->seePageIs('/auth/login');
    }

    /**
     * Tests user is authenticated when editing an apartment.
     */
    public function testItForcesUsersToAuthenticateToEditAnApartment()
    {
        $fields = $this->createApartmentFields();
        $apartment = Apartment::create($fields);

        $this->visit("/apartments/{$apartment['id']}/edit")
             ->seePageIs('/auth/login');
    }

    /**
     * Creates the apartment fields.
     *
     * @param   array   $fields  Override field values to use.
     *
     * @return  array           The apartment fields.
     */
    protected function createApartmentFields(array $fields = [])
    {
        $fields = array_merge([
             'name' => 'Test Apartment',
             'state' => 'MO',
             'user_id' => 1,
         ], $fields);

        return factory(Apartment::class)
               ->make($fields)
               ->toArray();
    }

    /**
     * Fills out the apartment form.
     *
     * @param   array   $fields  The field values to fill.
     *
     * @return  object           The current class reference.
     */
    protected function fillOutForm(array $fields)
    {
        $fields = array_merge([
            'name' => '',
            'addressLine1' => '',
            'addressLine2' => '',
            'city' => '',
            'state' => '',
            'zip' => '',
            'notes' => '',
            'price' => '',
            'parkingPrice' => '',
            'deposit' => '',
        ], $fields);

        $this->type($fields['name'], 'name')
             ->type($fields['addressLine1'], 'addressLine1')
             ->type($fields['addressLine2'], 'addressLine2')
             ->type($fields['city'], 'city')
             ->select($fields['state'], 'state')
             ->type($fields['zip'], 'zip')
             ->type($fields['notes'], 'notes')
             ->type($fields['price'], 'price')
             ->type($fields['parkingPrice'], 'parkingPrice')
             ->type($fields['deposit'], 'deposit')
             ->press('Submit');

        return $this;
    }
}
