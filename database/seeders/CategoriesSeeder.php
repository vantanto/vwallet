<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mainCategories = [
            [ 'id' => '100', 'name' => 'Food & Drinks', 'icon' => 'ti ti-tools-kitchen', ],
            [ 'id' => '200', 'name' => 'Shooping', 'icon' => 'ti ti-shopping-cart', ],
            [ 'id' => '300', 'name' => 'Housing', 'icon' => 'ti ti-home', ],
            [ 'id' => '400', 'name' => 'Transportation', 'icon' => 'ti ti-bus', ],
            [ 'id' => '500', 'name' => 'Vehicle', 'icon' => 'ti ti-car', ],
            [ 'id' => '600', 'name' => 'Life & Entertainment', 'icon' => 'ti ti-user', ],
            [ 'id' => '700', 'name' => 'Communication, PC', 'icon' => 'ti ti-device-laptop', ],
            [ 'id' => '800', 'name' => 'Financial Expenses', 'icon' => 'ti ti-cash', ],
            [ 'id' => '900', 'name' => 'Invesments', 'icon' => 'ti ti-affiliate', ],
            [ 'id' => '1000', 'name' => 'Income', 'icon' => 'ti ti-businessplan', ],
            [ 'id' => '2000', 'name' => 'Other', 'icon' => 'ti ti-menu-2', ],
        ];


        $subCategories = [
            // 100
            ['category_id' => '100', 'name' => 'Bar, Cafe'],
            ['category_id' => '100', 'name' => 'Groceries'],
            ['category_id' => '100', 'name' => 'Restaurant, fast-food'],
            // 200
            ['category_id' => '200', 'name' => 'Clothes & shoes'],
            ['category_id' => '200', 'name' => 'Drug-store, chemist'],
            ['category_id' => '200', 'name' => 'Electronics, accessories'],
            ['category_id' => '200', 'name' => 'Free time'],
            ['category_id' => '200', 'name' => 'Gifts, joy'],
            ['category_id' => '200', 'name' => 'Health and beauty'],
            ['category_id' => '200', 'name' => 'Home, garden'],
            ['category_id' => '200', 'name' => 'Jewels, accessories'],
            ['category_id' => '200', 'name' => 'Kids'],
            ['category_id' => '200', 'name' => 'Pets, animals'],
            ['category_id' => '200', 'name' => 'Stationery, tools'],
            // 300
            ['category_id' => '300', 'name' => 'Energy, utilities'],
            ['category_id' => '300', 'name' => 'Maintenance, repairs'],
            ['category_id' => '300', 'name' => 'Mortgage'],
            ['category_id' => '300', 'name' => 'Property insurance'],
            ['category_id' => '300', 'name' => 'Rent'],
            ['category_id' => '300', 'name' => 'Services'],
            // 400
            ['category_id' => '400', 'name' => 'Business trips'],
            ['category_id' => '400', 'name' => 'Long distance'],
            ['category_id' => '400', 'name' => 'Public transport'],
            ['category_id' => '400', 'name' => 'Taxi'],
            // 500
            ['category_id' => '500', 'name' => 'Fuel'],
            ['category_id' => '500', 'name' => 'Leasing'],
            ['category_id' => '500', 'name' => 'Parking'],
            ['category_id' => '500', 'name' => 'Rentals'],
            ['category_id' => '500', 'name' => 'Vehicle insurance'],
            ['category_id' => '500', 'name' => 'Vehicle maintenance'],
            // 600
            ['category_id' => '600', 'name' => 'Active sport, fitness'],
            ['category_id' => '600', 'name' => 'Alcohol, tobacco'],
            ['category_id' => '600', 'name' => 'Books, audio, subscriptions'],
            ['category_id' => '600', 'name' => 'Charity, gifts'],
            ['category_id' => '600', 'name' => 'Culture, sport events'],
            ['category_id' => '600', 'name' => 'Education, development'],
            ['category_id' => '600', 'name' => 'Health care, doctor'],
            ['category_id' => '600', 'name' => 'Hobbies'],
            ['category_id' => '600', 'name' => 'Holiday, trips, hotels'],
            ['category_id' => '600', 'name' => 'Life events'],
            ['category_id' => '600', 'name' => 'Lottery, gambling'],
            ['category_id' => '600', 'name' => 'TV, streaming'],
            ['category_id' => '600', 'name' => 'Wellness, beauty'],
            // 700
            ['category_id' => '700', 'name' => 'Internet'],
            ['category_id' => '700', 'name' => 'Phone, cell phone'],
            ['category_id' => '700', 'name' => 'Postal services'],
            ['category_id' => '700', 'name' => 'Software, apps, games'],
            // 800
            ['category_id' => '800', 'name' => 'Advisory'],
            ['category_id' => '800', 'name' => 'Charges, fees'],
            ['category_id' => '800', 'name' => 'Child support'],
            ['category_id' => '800', 'name' => 'Fines'],
            ['category_id' => '800', 'name' => 'Insurances'],
            ['category_id' => '800', 'name' => 'Loan, interests'],
            ['category_id' => '800', 'name' => 'Taxes'],
            // 900
            ['category_id' => '900', 'name' => 'Collections'],
            ['category_id' => '900', 'name' => 'Financial investments'],
            ['category_id' => '900', 'name' => 'Realty'],
            ['category_id' => '900', 'name' => 'Savings'],
            ['category_id' => '900', 'name' => 'Venchies, chattels'],
            // 1000
            ['category_id' => '1000', 'name' => 'Checks, coupons'],
            ['category_id' => '1000', 'name' => 'Child support'],
            ['category_id' => '1000', 'name' => 'Dues % grants'],
            ['category_id' => '1000', 'name' => 'Gifts'],
            ['category_id' => '1000', 'name' => 'Interests, dividens'],
            ['category_id' => '1000', 'name' => 'Lending, renting'],
            ['category_id' => '1000', 'name' => 'Lottery, gambling'],
            ['category_id' => '1000', 'name' => 'Refunds (tax, purchase)'],
            ['category_id' => '1000', 'name' => 'Rental income'],
            ['category_id' => '1000', 'name' => 'Sale'],
            ['category_id' => '1000', 'name' => 'Wage, invoices'],
            // 2000
            ['category_id' => '2000', 'name' => 'Missing'],
        ];

        $i = 0;
        $last_category_id = null;
        foreach ($subCategories as $key => $subCategory) {
            if ($subCategory['category_id'] == $last_category_id) {
                $i++;
            } else {
                $i = 1;
                $last_category_id = $subCategory['category_id'];
            }
            $subCategories[$key]['id'] = $subCategory['category_id'] + $i;
        }

        Category::insert($mainCategories);
        Category::insert($subCategories);
    }
}
