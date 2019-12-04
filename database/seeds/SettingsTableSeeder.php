<?php

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $model = new Setting();
        $model->id = 'company';
        $model->name = '<span class="headline font-weight-light">Si</span><span class="headline font-weight-bold">PANDIK</span>';
        $model->title = '<div class="d-block display-1 text-uppercase"><span class="font-weight-light">PENDATAAN </span><span class="font-weight-bold">KEPENDIDIKAN</span></div>';
        $model->quote = '<span class="d-block">Sistem Pendataan ASN Non PNS Tenaga Pendidik dan Kependidikan Non Pegawai Negeri Sipil di lingkungan Pemerintah Provinsi Banten. Tata cara penggunaan aplikasi dapat dilihat pada <a href="https://tinyurl.com/rxejjta" target="_blank">tautan</a> berikut.</span>';
        $model->logo = '/images/logo-holder.svg';
        $model->background = '/images/back-holder.jpg';
        $model->height = '120px';
        $model->width = '120px';
        $model->save();
    }
}
