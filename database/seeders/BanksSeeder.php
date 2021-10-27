<?php

namespace Database\Seeders;

use Domain\Payouts\Bank;
use Illuminate\Database\Seeder;

class BanksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bank::upsert([

            [
               "bank_id" => 255,
               "code"=> "MTN",
               "name"=> "MTN Mobile Money"
            ],
            [
              "bank_id" => 256,
              "code" => "TIGO",
              "name" => "TIGO Mobile Money"
            ],
            [
              "bank_id" => 257,
              "code" => "VODAFONE",
              "name" => "Vodafone Mobile Money"
            ],
            [
              "bank_id" => 258,
              "code" => "AIRTEL",
              "name" => "Airtel Mobile Money"
            ],
            [
              "bank_id" => 752,
              "code" => "10550214",
              "name" => "The Hongkong and Shanghai Banking Corporation Limited"
            ],
            [
              "bank_id" => 753,
              "code" =>"11088200",
              "name" => "Giro Elszamolasforgalmi Zrt."
            ],
            [
              "bank_id" => 754,
              "code" =>"11276282",
              "name" => "First National Bank Ghana Limited"
            ],
            [
              "bank_id" => 755,
              "code" => "11299458",
              "name" => "OMNIBANK GHANA LIMITED"
            ],
            [
              "bank_id" => 756,
              "code" => "11319374",
              "name" => "GHL Bank Ltd"
            ],
            [
              "bank_id" => 757,
              "code" =>"11350352",
              "name" => "Consolidated Bank Ghana Limited"
            ],
            [
              "bank_id" => 758,
              "code" => "1812142W72",
              "name" => "GH PREPAID"
            ],
            [
              "bank_id" => 759,
              "code" => "190815670S",
              "name" => "VISA"
            ],
            [
              "bank_id" => 760,
              "code" => "2006168ICS",
              "name" => "Standard Chartered Bk Ghana Int"
            ],
            [
              "bank_id" => 761,
              "code" => "2006228LG0",
              "name" => "UNITED BANK FOR AFRICA (GHANA) LT"
            ],
            [
              "bank_id" => 762,
              "code" => "20112200",
              "name" => "Partner Banka d.d."
            ],
            [
              "bank_id" => 763,
              "code" => "20313200",
              "name" => "Agricultural Development Bank Limited"
            ],
            [
              "bank_id" => 764,
              "code" => "20313400",
              "name" => "Bank of Ghana"
            ],
            [
              "bank_id" => 765,
              "code" => "20313400",
              "name" => "Bank of Ghana"
            ],
            [
               "bank_id" => 765,
               "code" => "20313500",
               "name" => "Barclays Bank of Ghana Limited"
            ],
            [
                "bank_id" => 766,
                "code" => "20313600",
                "name" => "GCB Bank Limited"
            ],
            [
                "bank_id" => 767,
                "code" => "20313800",
                "name" => "Universal Merchant Bank"
            ],
            [
                "bank_id" => 768,
                "code" => "20313900",
                "name" => "National Investment Bank Ltd"
            ],
            [
                "bank_id" => 769,
                "code" => "20314100",
                "name" => "Societe Generale Ghana Limited"
            ],
            [
                "bank_id" => 770,
                "code" => "20314200",
                "name" => "Standard Chartered Bank Ghana Limited"
            ],
            [
                "bank_id" => 771,
                "code" => "20321900",
                "name" => "Societe Generale Haitienne de Banque S.A. (Sogebank)"
            ],
            [
                "bank_id" => 772,
                "code" => "20497300",
                "name" => "BNG Bank N V"
            ],
            [
               "bank_id" => 773,
               "code" => "22031960",
               "name" => "Cal Bank Limited"
            ],
            [
                "bank_id" => 774,
                "code" => "25449292",
                "name" => "DBS Group Holdings Ltd"
            ],
            [
                "bank_id" => 775,
                "code" => "25528546",
                "name" => "Financial Brokerage Group (Fbg)"
            ],
            [
                "bank_id" => 776,
                "code" => "25544088",
                "name" => "Arb Apex Bank Limited"
            ],
            [
                "bank_id" => 777,
                "code" => "25549518",
                "name" => "Stock Exchange Of Hong Kong Ltd, The"
            ],
            [
                "bank_id" => 778,
                "code" => "25562284",
                "name" => "Guaranty Trust Bank (Ghana) Ltd"
            ],
            [
                "bank_idd" => 779,
                "code" => "25570554",
                "name" => "Fidelity Bank Ghana Ltd."
            ],
            [
                "bank_id" => 780,
                "code" => "25785380",
                "name" => "Banque Sahelo-Saharienne Pour LInvestissment et le Commerce (Ghana) Lt"
            ],
            [
                "bank_id" => 781,
                "code" => "25817360",
                "name" => "Guaranty Trust Bank (UK) Limited"
            ],
            [
                "bank_id" => 782,
                "code" => "25892776",
                "name" => "Bank of Baroda (Ghana) Limited"
            ],
            [
                "bank_id" => 783,
                "code" => "25897096",
                "name" => "Gatehouse Bank Plc"
            ],
            [
                "bank_id" => 784,
                "code" => "26153374",
                "name" => "Access Bank (Ghana) PLC"
            ],
            [
                "bank_id" => 785,
                "code" => "26153460",
                "name" => "Noble Group Ltd"
            ],
            [
                "bank_id" => 786,
                "code" => "26156818",
                "name" => "Ghazanfar Bank"
            ],
            [
                "bank_id" => 787,
                "code" => "26545578",
                "name" => "Social Security And National Insurance Trust"
            ],
            [
                "bank_id" => 788,
                "code" => "26675842",
                "name" => "Energy Bank Ghana Limited"
            ],
            [
                "bank_id" => 789,
                "code" => "26699422",
                "name" => "Ghana Revenue Authority"
            ],
            [
                "bank_id" => 790,
                "code" => "26708398",
                "name" => "Pacific Eagle Asset Management Ltd"
            ],
            [
                "bank_id" => 791,
                "code" => "26852136",
                "name" => "Independent Petroleum Group"
            ],
            [
                "bank_id" => 791,
                "code" => "26852136",
                "name" => "Independent Petroleum Group"
            ],
            [
                "bank_id" => 792,
                "code" => "26935088",
                "name" => "Controller And Accountant-GeneralS Department"
            ],
            [
                "bank_id" => 793,
                "code" => "26935170",
                "name" => "Partners Group AG"
            ],
            [
                "bank_id" => 794,
                "code" => "26955918",
                "name" => "Compass Global Holdings Pty Ltd"
            ],
            [
                "bank_id" => 795,
                "code" => "27096388",
                "name" => "Global Exchange Centre Limited"
            ],
            [
                "bank_id" => 796,
                "code" => "27108818",
                "name" => "Volta River Authority"
            ],
            [
                "bank_id" => 797,
                "code" => "27127004",
                "name" => "Norma Group Holding"
            ],
            [
                "bank_id" => 798,
                "code" => "27208826",
                "name" => "Tronox Global Holdings Pty Limited"
            ],
            [
                "bank_id" => 799,
                "code" => "27209142",
                "name" => "Cqlt Saargummi Technologies SAR.l"
            ],
            [
                "bank_id" => 800,
                "code" => "27257744",
                "name" => "Pigeon Corporation"
            ],
            [
                "bank_id" => 801,
                "code" => "27349456",
                "name" => "Ping An Of China Asset Management (Hong Kong) Company Ltd"
            ],
            [
                "bank_id" => 802,
                "code" => "27352014",
                "name" => "Gebr. Heinemann Se And Co.KG"
            ],
            [
                "bank_id" => 803,
                "code" => "27404306",
                "name" => "Cgnpc Huasheng Investment Limited"
            ],
            [
                "bank_id" => 804,
                "code" => "27451510",
                "name" => "Premium Bank Ghana Limited"
            ],
            [
                "bank_id" => 805,
                "code" => "27452668",
                "name" => "G.H. Financials Ltd"
            ],
            [
                "bank_id" => 806,
                "code" => "27457008",
                "name" => "Asahi Group Holdings, Ltd."
            ],
            [
                "bank_id" => 807,
                "code" => "27462484",
                "name" => "Heritage Bank Limited"
            ],
            [
                "bank_id" =>  808,
                "code" => "27464082",
                "name" => "Grabtaxi Holdings PTE LTD"
            ],
            [
                "bank_id" => 809,
                "code" => "27466360",
                "name" => "Al Ghurair International Exchange"
            ],
            [
                "bank_id" => 810,
                "code" => "27547278",
                "name" => "Dogan Sirketler Grubu Holding AS"
            ],
            [
                "bank_id" => 811,
                "code" => "50480908",
                "name" => "GN Bank Limited"
            ],
            [
                "bank_id" => 812,
                "code" => "60002121",
                "name" => "Banque Populaire de Rabat-Kenitra"
            ],
            [
                "bank_id" => 813,
                "code" => "60003190",
                "name" => "Prudential Bank Ltd"
            ],
            [
                "bank_id" => 814,
                "code" => "60003191",
                "name" => "First Atlantic Bank Ltd"
            ],
            [
                "bank_id" => 815,
                "code" => "60003193",
                "name" => "FBN Bank (Ghana) Limited"
            ],
            [
                "bank_id" => 816,
                "code" => "96683220",
                "name" => "Privredna banka Zagreb d.d."
            ],
            [
                "bank_id" => 817,
                "code" => "96788653",
                "name" => "Ghana International Bank plc"
            ],
            [
                "bank_id" => 818,
                "code" => "96793657",
                "name" => "Republic Bank (Ghana) Ltd"
            ],
            [
                "bank_id" => 819,
                "code" => "96855152",
                "name" => "Guaranty Trust Bank Kenya Limited"
            ],
            [
                "bank_id" => 820,
                "code" => "97151844",
                "name" => "Stanbic Bank Ghana Limited"
            ],
            [
                "bank_id" => 821,
                "code" => "97155860",
                "name" => "Bank of Africa - Ghana"
            ],
            [
                "bank_id" => 822,
                "code" => "98357706",
                "name" => "ZENITH BANK (GHANA) LIMITED"
            ],
            [
                "bank_id" => 823,
                "code" => "99730556",
                "name" => "FINANCIJSKA AGENCIJA"
            ],
            [
                "bank_id" => 824,
                "code" => "GH130100",
                "name" => "Ecobank Ghana (GH130100)"
            ]

        ], ['bank_id', 'code'], []);
    }
}
