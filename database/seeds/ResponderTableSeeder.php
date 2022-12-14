<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResponderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('responders')->truncate();
        $list = [
            [
                'title'      => 'Sendlane',
                'base_url'   => 'https://lightspeeddev.sendlane.com/api/v1/',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'MailChimp',
                'base_url'   => 'https://us7.api.mailchimp.com/3.0/',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'ActiveCampaign',
                'base_url'   => 'https://account.api-us1.com/',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'Campaign Monitor',
                'base_url'   => 'https://api.createsend.com/api/v3.2/',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'GetResponse',
                'base_url'   => 'https://api.getresponse.com/v3/',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'MailerLite',
                'base_url'   => 'https://api.mailerlite.com/api/v2/',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'Send In Blue',
                'base_url'   => 'https://api.sendinblue.com/v3/',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'Aweber',
                'base_url'   => 'https://api.aweber.com/1.0/',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'Constant Contact',
                'base_url'   => 'https://api.cc.email/v3/',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'Sendy',
                'base_url'   => 'http://emails.emailinghost.com/',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'HTML Integration',
                'base_url'   => ' ',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];
        
        DB::table('responders')->insert($list);
    }
}
