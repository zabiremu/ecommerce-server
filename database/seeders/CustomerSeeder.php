<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('order_items')->delete();
        DB::table('orders')->delete();
        Customer::query()->delete();

        $customers = [
            ['Md. Rakib Hasan',     '01711000001', 'rakib.hasan@gmail.com',     'House 12, Road 7, Dhanmondi',           'Dhaka',      'Dhanmondi'],
            ['Sumaiya Akter',       '01711000002', 'sumaiya.akter@gmail.com',   'Apt 4B, Banani Road 11',                 'Dhaka',      'Banani'],
            ['Tanvir Ahmed',        '01711000003', 'tanvir.ahmed@yahoo.com',    'House 25, Sector 7, Uttara',             'Dhaka',      'Uttara'],
            ['Nasrin Sultana',      '01711000004', 'nasrin.s@hotmail.com',      'House 8, Mirpur-10',                     'Dhaka',      'Mirpur'],
            ['Imran Khan',          '01711000005', 'imran.k@gmail.com',         'Halishahar, Block-A',                    'Chittagong', 'Halishahar'],
            ['Farhana Yasmin',      '01711000006', 'farhana.y@gmail.com',       'Agrabad Commercial Area',                'Chittagong', 'Agrabad'],
            ['Mahmudul Hasan',      '01711000007', null,                         'Zindabazar Main Road',                  'Sylhet',     'Zindabazar'],
            ['Rumana Begum',        '01711000008', 'rumana.b@gmail.com',        'KDA Avenue, House 15',                   'Khulna',     'KDA'],
            ['Shahidul Islam',      '01711000009', null,                         'Saheb Bazar Road',                      'Rajshahi',   'Saheb Bazar'],
            ['Mim Akhtar',          '01711000010', 'mim.akhtar@gmail.com',      'House 9, Gulshan-1',                     'Dhaka',      'Gulshan'],
            ['Habibur Rahman',      '01711000011', 'habib.rahman@yahoo.com',    'Shantinagar, Building 3',                'Dhaka',      'Shantinagar'],
            ['Rafia Sultana',       '01711000012', 'rafia.s@gmail.com',         'Bashundhara R/A, Block-D',               'Dhaka',      'Bashundhara'],
            ['Jamil Hossain',       '01711000013', null,                         'Mohammadpur Beribadh',                  'Dhaka',      'Mohammadpur'],
            ['Sabbir Ahmed',        '01711000014', 'sabbir.a@gmail.com',        'Khulshi Hills, Lane 5',                  'Chittagong', 'Khulshi'],
            ['Tahmina Khanam',      '01711000015', 'tahmina.k@gmail.com',       'Subid Bazar',                            'Sylhet',     'Subid Bazar'],
            ['Anwar Hossain',       '01711000016', null,                         'Old Town, Main Road',                   'Dhaka',      'Old Dhaka'],
            ['Mahmuda Khatun',      '01711000017', 'mahmuda.k@gmail.com',       'New Eskaton Road',                       'Dhaka',      'Eskaton'],
            ['Rahim Uddin',         '01711000018', 'rahim.u@yahoo.com',         'Tongi Bazar',                            'Gazipur',    'Tongi'],
            ['Sharmin Akter',       '01711000019', 'sharmin.akter@gmail.com',   'New Market Area',                        'Dhaka',      'New Market'],
            ['Selim Reza',          '01711000020', null,                         'Bandar Bazar',                           'Sylhet',     'Bandar Bazar'],
            ['Nazmul Hasan',        '01711000021', 'nazmul.h@gmail.com',        'Mohakhali DOHS',                         'Dhaka',      'Mohakhali'],
            ['Sania Tabassum',      '01711000022', 'sania.t@gmail.com',         'Lalmatia, Block-C',                      'Dhaka',      'Lalmatia'],
            ['Mohammad Ali',        '01711000023', null,                         'Wari, Hatkhola Road',                   'Dhaka',      'Wari'],
            ['Rezaul Karim',        '01711000024', 'rezaul.k@gmail.com',        'Mohammadpur Town Hall',                  'Dhaka',      'Mohammadpur'],
            ['Tasnim Sultana',      '01711000025', 'tasnim.s@gmail.com',        'Kandirpar Main Road',                    'Cumilla',    'Kandirpar'],
            ['Mahbubur Rahman',     '01711000026', 'mahbub.r@gmail.com',        'BSCIC Industrial Area',                  'Narayanganj','BSCIC'],
            ['Lutfun Nahar',        '01711000027', null,                         'Tikatuli',                              'Dhaka',      'Tikatuli'],
            ['Iqbal Hossain',       '01711000028', 'iqbal.h@yahoo.com',         'Bangshal, Old Dhaka',                    'Dhaka',      'Bangshal'],
            ['Shahana Akhter',      '01711000029', 'shahana.a@gmail.com',       'Nilkhet',                                'Dhaka',      'Nilkhet'],
            ['Tariqul Islam',       '01711000030', 'tariq.i@gmail.com',         'Mohammadpur, Iqbal Road',                'Dhaka',      'Mohammadpur'],
        ];

        foreach ($customers as $c) {
            [$name, $phone, $email, $address, $city, $area] = $c;
            Customer::create([
                'name'    => $name,
                'phone'   => $phone,
                'email'   => $email,
                'address' => $address,
                'city'    => $city,
                'area'    => $area,
                'status'  => true,
            ]);
        }

        $this->command->info('Customers seeded successfully. Total: ' . Customer::count());
    }
}
