<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrenciesTable extends Migration {
    public function up() {
        Schema::create('currencies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('symbol');
            $table->string('iso');
        });
        DB::table('currencies')->insert([
            [
                'name' => 'Euro',
                'symbol' => '&euro;',
                'iso' => 'EUR',
            ],
            [
                'name' => 'US Dollar',
                'symbol' => '&dollar;',
                'iso' => 'USD',
            ],
            [
                'name' => 'British Pound',
                'symbol' => '&pound;',
                'iso' => 'GBP',
            ],
            [
                'name' => 'Libyan Dinar',
                'symbol' => 'LYD',
                'iso' => 'LYD',
            ],
            [
                'name' => 'Tunisian Dinar',
                'symbol' => 'TND',
                'iso' => 'TND',
            ],
            [
                'name' => 'Ghanaian Cedis',
                'symbol' => 'GHS',
                'iso' => 'GHS',
            ],
            [
                'name' => 'Sudanese Pound',
                'symbol' => 'SDG',
                'iso' => 'SGD',
            ],
            [
                'name' => 'Moroccan Dirham',
                'symbol' => 'MAD',
                'iso' => 'MAD',
            ],
            [
                'name' => 'Botswana Pula',
                'symbol' => 'BWP',
                'iso' => 'BWP',
            ],
            [
                'name' => 'South African Rand',
                'symbol' => 'ZAR',
                'iso' => 'ZAR',
            ],
            [
                'name' => 'Egyptian Pound',
                'symbol' => 'EGP',
                'iso' => 'EGP',
            ],
            [
                'name' => 'Eritrean Nakfa',
                'symbol' => 'ERN',
                'iso' => 'ERN',
            ],
            [
                'name' => 'Zambian Kwacha',
                'symbol' => 'ZMW',
                'iso' => 'ZMW',
            ],
            [
                'name' => 'Angolan Kwanza',
                'symbol' => 'AKZ',
                'iso' => 'AKZ',
            ],
            [
                'name' => 'Argentine Peso',
                'symbol' => 'ARS',
                'iso' => 'ARS',
            ],
            [
                'name' => 'Bolivian Boliviano',
                'symbol' => 'BOB',
                'iso' => 'BOB',
            ],
            [
                'name' => 'Brazilian Real',
                'symbol' => 'BRL',
                'iso' => 'BRL',
            ],
            [
                'name' => 'Chilean Peso',
                'symbol' => 'CLP',
                'iso' => 'CLP',
            ],
            [
                'name' => 'Colombian Peso',
                'symbol' => 'COP',
                'iso' => 'COP',
            ],
            [
                'name' => 'Paraguayan Guarani',
                'symbol' => 'PYG',
                'iso' => 'PYG',
            ],
            [
                'name' => 'Peruvian Novo Sol',
                'symbol' => 'PEN',
                'iso' => 'PEN',
            ],
            [
                'name' => 'Uruguayan Peso',
                'symbol' => 'UYU',
                'iso' => 'UYU',
            ],
            [
                'name' => 'Venezuelan Bolivar',
                'symbol' => 'VES',
                'iso' => 'VES',
            ],
            [
                'name' => 'Danish Krone',
                'symbol' => 'DKK',
                'iso' => 'DKK',
            ],
            [
                'name' => 'Icelandic Krona',
                'symbol' => 'ISK',
                'iso' => 'ISK',
            ],
            [
                'name' => 'Norwegian Krone',
                'symbol' => 'NOK',
                'iso' => 'NOK',
            ],
            [
                'name' => 'Swedish Krona',
                'symbol' => 'SEK',
                'iso' => 'SEK',
            ],
            [
                'name' => 'Albanian Lek',
                'symbol' => 'ALL',
                'iso' => 'ALL',
            ],
            [
                'name' => 'Armenian Dram',
                'symbol' => 'AMD',
                'iso' => 'AMD',
            ],
            [
                'name' => 'Azerbaijani Manat',
                'symbol' => 'AZN',
                'iso' => 'AZN',
            ],
            [
                'name' => 'Bosnia and Herzegovina Convertible Mark',
                'symbol' => 'BAM',
                'iso' => 'BAM',
            ],
            [
                'name' => 'Bulgarian Lev',
                'symbol' => 'BGN',
                'iso' => 'BGN',
            ],
            [
                'name' => 'Belarusian Ruble',
                'symbol' => 'BYN',
                'iso' => 'BYN',
            ],
            [
                'name' => 'Swiss Franc',
                'symbol' => 'CHF',
                'iso' => 'CHF',
            ],
            [
                'name' => 'Czech Koruna',
                'symbol' => 'CZK',
                'iso' => 'CZK',
            ],
            [
                'name' => 'Turkish lira',
                'symbol' => 'TRY',
                'iso' => 'TRY'
            ],
            [
                'name' => 'Yuan',
                'symbol' => '元',
                'iso' => 'CNY'
            ],
            [
                'name' => 'Yen',
                'symbol' => '&yen;',
                'iso' => 'JPY'
            ],
            [
                'name' => 'Australian dollar',
                'symbol' => '$',
                'iso' => 'AUD'
            ],
            [
                'name' => 'Hong Kong dollar',
                'symbol' => 'HK$',
                'iso' => 'HKD'
            ],
            [
                'name' => 'Indian rupee',
                'symbol' => '₹',
                'iso' => 'INR'
            ],
            [
                'name' => 'Rupiah',
                'symbol' => 'Rp',
                'iso' => 'IDR'
            ],
            [
                'name' => 'Ringgit',
                'symbol' => 'RM',
                'iso' => 'MYR'
            ],
            [
                'name' => 'South Korean won',
                'symbol' => '₩',
                'iso' => 'KRW'
            ],
            [
                'name' => 'Pakistani rupee',
                'symbol' => 'PKR',
                'iso' => 'PKR'
            ],
            [
                'name' => 'Philippine peso',
                'symbol' => '₱',
                'iso' => 'PHP'
            ],
            [
                'name' => 'Singapore dollar',
                'symbol' => '$',
                'iso' => 'SGD'
            ],
            [
                'name' => 'New Taiwan dollar',
                'symbol' => 'NT$',
                'iso' => 'TWD'
            ],
            [
                'name' => 'Baht',
                'symbol' => '฿',
                'iso' => 'THB'
            ],
            [
                'name' => 'đồng',
                'symbol' => '₫',
                'iso' => 'VND'
            ]
        ]);
    }

    public function down() {
        Schema::dropIfExists('currencies');
    }
}
