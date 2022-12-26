<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {

        // Run the Seeder Class
        $this->call([
            RoleSeeder::class,
            LocationSeeder::class,
            ConfigurationSeeder::class,
        ]);

        // Create user with role "owner"
         User::factory()->create([
             'name' => 'Mustafa',
             'email' => 'mustafa@kodegakure.com',
             'role_id' => 1,
             'nip' => 'dpm-001',
             'address' => 'Sako',
             'phone_number' => '6282246876109',
             'birthdate' => '1966-11-01',
             'birthplace' => 'Rawang Binjai'
         ]);

        // Create user with role employee
        User::factory()->create([
            'name' => 'Dodit',
            'email' => 'dodit@kodegakure.com',
            'nip' => 'dpm-002',
            'address' => 'Pauh Angit',
            'phone_number' => '6281318912345',
            'birthplace' => 'Pauh Angit',
            'birthdate' => '1986-04-19',
        ]);

        User::factory()->create([
            'name' => 'Ijum',
            'email' => 'ijum@kodegakure.com',
            'nip' => 'dpm-003',
            'address' => 'Pauh Angit',
            'phone_number' => '6285506064270',
            'birthplace' => 'Pauh Angit',
            'birthdate' => '1996-06-26',
        ]);

        User::factory()->create([
            'name' => 'Aldi',
            'email' => 'aldi@kodegakure.com',
            'nip' => 'dpm-004',
            'address' => 'Sako',
            'phone_number' => '6285329503198',
            'birthplace' => 'Sako',
            'birthdate' => '1986-09-26',
        ]);

        User::factory()->create([
            'name' => 'Arif',
            'email' => 'arif@kodegakure.com',
            'nip' => 'dpm-005',
            'address' => 'Sako',
            'phone_number' => '6282312818722',
            'birthplace' => 'Sako',
            'birthdate' => '1986-09-26',
        ]);

        User::factory()->create([
            'name' => 'Anto',
            'email' => 'anto@kodegakure.com',
            'nip' => 'dpm-006',
            'address' => 'Pasar Baru',
            'phone_number' => '6285879296215',
            'birthplace' => 'Teluk Pauh',
            'birthdate' => '1993-05-09',
        ]);

        User::factory()->create([
            'name' => 'Maulana',
            'email' => 'maulana@kodegakure.com',
            'nip' => 'dpm-007',
            'address' => 'Sungai Langsat',
            'phone_number' => '6285325745658',
            'birthplace' => 'Pulau Rengas',
            'birthdate' => '1985-09-27',
        ]);

        User::factory()->create([
            'name' => 'Halim',
            'email' => 'halim@kodegakure.com',
            'nip' => 'dpm-008',
            'address' => 'Tugu',
            'phone_number' => '6289877940103',
            'birthplace' => 'Sukaping',
            'birthdate' => '1986-07-04',
        ]);

        User::factory()->create([
            'name' => 'Dodo',
            'email' => 'dodo@kodegakure.com',
            'nip' => 'dpm-009',
            'address' => 'Sako',
            'phone_number' => '6282217949513',
            'birthplace' => 'Pauh Angit',
            'birthdate' => '1985-06-26',
        ]);

        User::factory()->create([
            'name' => 'Novi',
            'email' => 'novi@kodegakure.com',
            'nip' => 'dpm-010',
            'address' => 'Pasar Baru',
            'phone_number' => '6281378443339',
            'birthplace' => 'Pasar Baru',
            'birthdate' => '1998-08-18',
        ]);

        User::factory()->create([
            'name' => 'Ego',
            'email' => 'ego@kodegakure.com',
            'nip' => 'dpm-011',
            'address' => 'Sungai Langsat',
            'phone_number' => '6281245855253',
            'birthplace' => 'Sungai Langsat',
            'birthdate' => '1989-03-22',
        ]);

        User::factory()->create([
            'name' => 'Wildan',
            'email' => 'wildan@kodegakure.com',
            'nip' => 'dpm-012',
            'address' => 'Padang Kunik',
            'phone_number' => '6282251002406',
            'birthplace' => 'Teluk Pauh',
            'birthdate' => '1985-02-17',
        ]);

        User::factory()->create([
            'name' => 'Omar',
            'email' => 'omar@kodegakure.com',
            'nip' => 'dpm-013',
            'address' => 'Tanah Bekali',
            'phone_number' => '6285882815866',
            'birthplace' => 'Pasar Baru',
            'birthdate' => '1988-11-20',
        ]);

        User::factory()->create([
            'name' => 'Sakti',
            'email' => 'sakti@kodegakure.com',
            'nip' => 'dpm-014',
            'address' => 'Pulau Kumpai',
            'phone_number' => '6282346762029',
            'birthplace' => 'Rawang Binjai',
            'birthdate' => '1997-01-23',
        ]);

        User::factory()->create([
            'name' => 'Bagus',
            'email' => 'bagus@kodegakure.com',
            'nip' => 'dpm-015',
            'address' => 'Pulau Kumpai',
            'phone_number' => '6285527367995',
            'birthplace' => 'Tanah Bekali',
            'birthdate' => '1991-02-16',
        ]);

        User::factory()->create([
            'name' => 'Putra',
            'email' => 'putra@kodegakure.com',
            'nip' => 'dpm-016',
            'address' => 'Pulau Rengas',
            'phone_number' => '6285239426097',
            'birthplace' => 'Teluk Pauh',
            'birthdate' => '1998-03-19',
        ]);

        User::factory()->create([
            'name' => 'Anas',
            'email' => 'anas@kodegakure.com',
            'nip' => 'dpm-017',
            'address' => 'Padang Kunik',
            'phone_number' => '6282290602520',
            'birthplace' => 'Tanah Bekali',
            'birthdate' => '1988-04-15',
        ]);

        User::factory()->create([
            'name' => 'Permana',
            'email' => 'permana@kodegakure.com',
            'nip' => 'dpm-018',
            'address' => 'Pulau Rengas',
            'phone_number' => '6281290580148',
            'birthplace' => 'Tanah Bekali',
            'birthdate' => '1993-08-12',
        ]);

        User::factory()->create([
            'name' => 'Dhika',
            'email' => 'dhika@kodegakure.com',
            'nip' => 'dpm-019',
            'address' => 'Sungai Langsat',
            'phone_number' => '6282330549263',
            'birthplace' => 'Sungai Langsat',
            'birthdate' => '1995-11-02',
        ]);

        User::factory()->create([
            'name' => 'Edy',
            'email' => 'edy@kodegakure.com',
            'nip' => 'dpm-020',
            'address' => 'Pembatang',
            'phone_number' => '6285535787741',
            'birthplace' => 'Sungai Langsat',
            'birthdate' => '1986-06-09',
        ]);

        User::factory()->create([
            'name' => 'Kemal',
            'email' => 'kemal@kodegakure.com',
            'nip' => 'dpm-021',
            'address' => 'Padang Kunik',
            'phone_number' => '6282302326224',
            'birthplace' => 'Pembatang',
            'birthdate' => '1997-10-01',
        ]);

        User::factory()->create([
            'name' => 'Eka Pangestu',
            'email' => 'ekapangestu@kodegakure.com',
            'nip' => 'dpm-022',
            'address' => 'Padang Tanggung',
            'phone_number' => '6281260496862',
            'birthplace' => 'Tanah Bekali',
            'birthdate' => '1993-04-26',
        ]);

        User::factory()->create([
            'name' => 'Rizky',
            'email' => 'rizky@kodegakure.com',
            'nip' => 'dpm-023',
            'address' => 'Pulau Tongah',
            'phone_number' => '6281297572625',
            'birthplace' => 'Pulau Tongah',
            'birthdate' => '1988-09-12',
        ]);

        User::factory()->create([
            'name' => 'Rahma',
            'email' => 'rahma@kodegakure.com',
            'nip' => 'dpm-024',
            'address' => 'Sako',
            'phone_number' => '6282225347853',
            'birthplace' => 'Padang Tanggung',
            'birthdate' => '1995-09-26',
        ]);

        User::factory()->create([
            'name' => 'Andri',
            'email' => 'andri@kodegakure.com',
            'nip' => 'dpm-025',
            'address' => 'Sungai Langsat',
            'phone_number' => '6282271157386',
            'birthplace' => 'Pulau Deras',
            'birthdate' => '1997-12-22',
        ]);

        User::factory()->create([
            'name' => 'Imam',
            'email' => 'imam@kodegakure.com',
            'nip' => 'dpm-026',
            'address' => 'Padang Kunik',
            'phone_number' => '6282265637130',
            'birthplace' => 'Padang Kunik',
            'birthdate' => '1986-03-27',
        ]);

        User::factory()->create([
            'name' => 'Yuda',
            'email' => 'yuda@kodegakure.com',
            'nip' => 'dpm-027',
            'address' => 'Padang Kunik',
            'phone_number' => '6285230316748',
            'birthplace' => 'Pembatang',
            'birthdate' => '1995-04-19',
        ]);

        User::factory()->create([
            'name' => 'Rian',
            'email' => 'rian@kodegakure.com',
            'nip' => 'dpm-028',
            'address' => 'Pasar Baru',
            'phone_number' => '6282338767385',
            'birthplace' => 'Padang Tanggung',
            'birthdate' => '1989-04-21',
        ]);

        User::factory()->create([
            'name' => 'Selenia',
            'email' => 'selenia@kodegakure.com',
            'nip' => 'dpm-029',
            'address' => 'Pulau Rengas',
            'phone_number' => '6281248861967',
            'birthplace' => 'Sungai Langsat',
            'birthdate' => '1990-11-12',
        ]);

        User::factory()->create([
            'name' => 'Teddy',
            'email' => 'teddy@kodegakure.com',
            'nip' => 'dpm-030',
            'address' => 'Padang Tanggung',
            'phone_number' => '6282281465278',
            'birthplace' => 'Rawang Binjai',
            'birthdate' => '1997-11-15',
        ]);

        User::factory()->create([
            'name' => 'Nugroho',
            'email' => 'nugroho@kodegakure.com',
            'nip' => 'dpm-031',
            'address' => 'Pulau Rengas',
            'phone_number' => '6282297335920',
            'birthplace' => 'Pulau Deras',
            'birthdate' => '1995-04-20',
        ]);

        User::factory()->create([
            'name' => 'Erdi',
            'email' => 'erdi@kodegakure.com',
            'nip' => 'dpm-032',
            'address' => 'Padang Tanggung',
            'phone_number' => '6281394180849',
            'birthplace' => 'Pauh Angit',
            'birthdate' => '1998-10-01',
        ]);

        User::factory()->create([
            'name' => 'Amar',
            'email' => 'amar@kodegakure.com',
            'nip' => 'dpm-033',
            'address' => 'Pulau Kumpai',
            'phone_number' => '6281309636567',
            'birthplace' => 'Sukaping',
            'birthdate' => '1997-04-16',
        ]);

        User::factory()->create([
            'name' => 'Andi Pratama',
            'email' => 'andipratama@kodegakure.com',
            'nip' => 'dpm-034',
            'address' => 'Padang Kunik',
            'phone_number' => '6285250142159',
            'birthplace' => 'Koto Pangean',
            'birthdate' => '1997-07-01',
        ]);

        User::factory()->create([
            'name' => 'Fauzan',
            'email' => 'fauzan@kodegakure.com',
            'nip' => 'dpm-035',
            'address' => 'Padang Kunik',
            'phone_number' => '6282323417370',
            'birthplace' => 'Pulau Rengas',
            'birthdate' => '1999-09-04',
        ]);

        User::factory()->create([
            'name' => 'Jopa',
            'email' => 'jopa@kodegakure.com',
            'nip' => 'dpm-036',
            'address' => 'Padang Kunik',
            'phone_number' => '6282212668385',
            'birthplace' => 'Koto Pangean',
            'birthdate' => '1990-08-25',
        ]);

        User::factory()->create([
            'name' => 'Pangendra',
            'email' => 'pangendra@kodegakure.com',
            'nip' => 'dpm-037',
            'address' => 'Pulau Kumpai',
            'phone_number' => '6285398814838',
            'birthplace' => 'Pauh Angit Hulu',
            'birthdate' => '1986-06-22',
        ]);

        User::factory()->create([
            'name' => 'Fajri',
            'email' => 'fajri@kodegakure.com',
            'nip' => 'dpm-038',
            'address' => 'Padang Kunik',
            'phone_number' => '6285266894942',
            'birthplace' => 'Pulau Kumpai',
            'birthdate' => '1989-04-14',
        ]);

        User::factory()->create([
            'name' => 'Asih',
            'email' => 'asih@kodegakure.com',
            'nip' => 'dpm-039',
            'address' => 'Pulau Kumpai',
            'phone_number' => '6285253481975',
            'birthplace' => 'Rawang Binjai',
            'birthdate' => '1987-05-06',
        ]);

        User::factory()->create([
            'name' => 'Dina',
            'email' => 'dina@kodegakure.com',
            'nip' => 'dpm-040',
            'address' => 'Pulau Kumpai',
            'phone_number' => '6281239812738',
            'birthplace' => 'Sako',
            'birthdate' => '1994-07-26',
        ]);

        User::factory()->create([
            'name' => 'Rifqy',
            'email' => 'rifqy@kodegakure.com',
            'nip' => 'dpm-041',
            'address' => 'Pulau Kumpai',
            'phone_number' => '6289879974260',
            'birthplace' => 'Pembatang',
            'birthdate' => '1991-03-11',
        ]);

        User::factory()->create([
            'name' => 'Zulfi',
            'email' => 'zulfi@kodegakure.com',
            'nip' => 'dpm-042',
            'address' => 'Pulau Tongah',
            'phone_number' => '6281320517165',
            'birthplace' => 'Padang Kunik',
            'birthdate' => '1998-08-25',
        ]);

        User::factory()->create([
            'name' => 'Pratama',
            'email' => 'pratama@kodegakure.com',
            'nip' => 'dpm-043',
            'address' => 'Tanah Bekali',
            'phone_number' => '6285841625504',
            'birthplace' => 'Pulau Kumpai',
            'birthdate' => '1998-03-27',
        ]);

        User::factory()->create([
            'name' => 'Andriawan',
            'email' => 'andriawan@kodegakure.com',
            'nip' => 'dpm-044',
            'address' => 'Pulau Tongah',
            'phone_number' => '6282205821903',
            'birthplace' => 'Pauh Angit',
            'birthdate' => '1994-11-06',
        ]);

        User::factory()->create([
            'name' => 'Juni Muhamad',
            'email' => 'junimuhamad@kodegakure.com',
            'nip' => 'dpm-045',
            'address' => 'Pulau Tongah',
            'phone_number' => '6282384091651',
            'birthplace' => 'Koto Pangean',
            'birthdate' => '1992-12-11',
        ]);

        User::factory()->create([
            'name' => 'Fiky',
            'email' => 'fiky@kodegakure.com',
            'nip' => 'dpm-046',
            'address' => 'Padang Tanggung',
            'phone_number' => '6285572823321',
            'birthplace' => 'Pembatang',
            'birthdate' => '1990-10-01',
        ]);

        User::factory()->create([
            'name' => 'Roy',
            'email' => 'roy@kodegakure.com',
            'nip' => 'dpm-047',
            'address' => 'Padang Kunik',
            'phone_number' => '6282255946279',
            'birthplace' => 'Teluk Pauh',
            'birthdate' => '1993-06-04',
        ]);

        User::factory()->create([
            'name' => 'Mubarak',
            'email' => 'mubarak@kodegakure.com',
            'nip' => 'dpm-048',
            'address' => 'Padang Kunik',
            'phone_number' => '6285365420620',
            'birthplace' => 'Pulau Tongah',
            'birthdate' => '1986-01-31',
        ]);

        User::factory()->create([
            'name' => 'Syarief',
            'email' => 'syarief@kodegakure.com',
            'nip' => 'dpm-049',
            'address' => 'Pulau Tongah',
            'phone_number' => '6281272605788',
            'birthplace' => 'Pauh Angit',
            'birthdate' => '1995-01-23',
        ]);

        User::factory()->create([
            'name' => 'Adityo',
            'email' => 'adityo@kodegakure.com',
            'nip' => 'dpm-050',
            'address' => 'Sako',
            'phone_number' => '6282248065910',
            'birthplace' => 'Pulau Deras',
            'birthdate' => '1987-06-16',
        ]);
    }
}
