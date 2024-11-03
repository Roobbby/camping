<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CampingSeeder extends Seeder
{
    public function run()
    {
        $items = [
            [
                "name" => "Tenda single layer kap 2",
                "price" => 15000,
                "description" => "Tenda single layer dengan kapasitas 1-2 orang. Tenda ini dirancang khusus untuk penggunaan dalam cuaca yang stabil dan tidak ekstrem. Ideal untuk berkemah di medan umum, tenda ini sangat mudah dipasang dan ringan untuk dibawa, menjadikannya pilihan yang sempurna untuk perjalanan singkat selama 1-2 hari. Keunggulan dari tenda ini adalah kemudahan penggunaan dan portabilitasnya, memastikan pengalaman berkemah yang nyaman dan praktis.",
                "cover" => null
            ],
            [
                "name" => "Tenda dome kap 4-5 bentuk topi",
                "price" => 28000,
                "description" => "Tenda dome dengan kapasitas 3-4 orang yang dilengkapi dengan desain berbentuk topi, memberikan stabilitas tambahan saat angin kencang. Desain ini tidak hanya meningkatkan kenyamanan tetapi juga memastikan perlindungan lebih saat berkemah di area terbuka. Cocok untuk keluarga kecil atau grup kecil yang berkemah selama 1-2 hari di medan umum, tenda ini menawarkan kombinasi ideal antara ruang dan perlindungan.",
                "cover" => null
            ],
            [
                "name" => "Tenda dome kap 5-6 bentuk teras",
                "price" => 37000,
                "description" => "Tenda dome dengan kapasitas 5-6 orang, dilengkapi dengan area teras untuk tambahan ruang. Teras ini memberikan kenyamanan ekstra dan ruang tambahan untuk menyimpan barang-barang atau bersantai. Ideal untuk berkemah dengan kenyamanan ekstra, tenda ini cocok digunakan di berbagai medan dan sangat sesuai untuk perjalanan berkemah selama 2 hari. Tenda ini menawarkan ruang dan kenyamanan yang lebih, ideal untuk grup yang memerlukan ruang lebih.",
                "cover" => null
            ],
            [
                "name" => "Tas Carier",
                "price" => 15000,
                "description" => "Tas Carier dengan kapasitas besar, dirancang untuk membawa berbagai peralatan dan perlengkapan berkemah dengan mudah. Tas ini memiliki distribusi beban yang merata, memastikan kenyamanan selama perjalanan jauh. Cocok untuk berbagai kegiatan outdoor dan penggunaan di medan umum, tas ini ideal untuk perjalanan berkemah singkat selama 1-2 hari. Fitur utama dari tas ini adalah ketahanan dan kenyamanannya dalam penggunaan sehari-hari.",
                "cover" => null
            ],
            [
                "name" => "Kompor Portabel",
                "price" => 8000,
                "description" => "Kompor portabel yang ringan dan mudah digunakan, sangat ideal untuk memasak saat berkemah. Kompor ini dirancang untuk memudahkan proses memasak di lapangan, cocok untuk berbagai kegiatan outdoor dan penggunaan di medan umum. Dapat digunakan untuk mempersiapkan makanan untuk 1-4 orang selama 1-2 hari berkemah. Kompor ini menawarkan kemudahan dan efisiensi dalam setiap perjalanan berkemah.",
                "cover" => null
            ],
            [
                "name" => "Sleeping bag",
                "price" => 8000,
                "description" => "Sleeping bag khusus untuk gunung yang dirancang untuk memberikan kehangatan dan kenyamanan di suhu dingin. Ideal untuk kondisi cuaca ekstrem di pegunungan, sleeping bag ini cocok untuk 1 orang dan sangat baik untuk berkemah selama 1-2 hari di medan dingin. Fitur utamanya adalah kemampuannya untuk menjaga suhu tubuh dan memberikan kenyamanan saat tidur.",
                "cover" => null
            ],
            [
                "name" => "Nesting",
                "price" => 10000,
                "description" => "Set peralatan masak yang praktis dan mudah dibawa, cocok untuk berbagai jenis kegiatan berkemah dan outdoor. Set ini dapat digunakan oleh 1-3 orang, memberikan fleksibilitas dalam memasak untuk kelompok kecil. Ideal untuk berkemah selama 1-2 hari di medan umum, nesting ini menawarkan solusi praktis untuk kebutuhan memasak saat berkemah.",
                "cover" => null
            ],
            [
                "name" => "Tracking pole",
                "price" => 9000,
                "description" => "Tracking pole yang dirancang untuk memberikan stabilitas dan dukungan ekstra saat mendaki di medan berat. Terbuat dari bahan ringan namun kuat, tracking pole ini cocok untuk 1 orang dan sangat berguna untuk mendaki atau trekking dalam waktu 1-2 hari di cuaca ekstrem. Fitur utama dari tracking pole ini adalah kemampuannya untuk meningkatkan keseimbangan dan mengurangi kelelahan selama pendakian.",
                "cover" => null
            ],
            [
                "name" => "Matras",
                "price" => 3000,
                "description" => "Matras yang dirancang untuk memberikan kenyamanan ekstra saat tidur di tenda. Mudah digulung dan dibawa, ideal untuk 1 orang dan cocok untuk berbagai kegiatan outdoor serta berkemah selama 1-2 hari di medan umum. Matras ini memberikan tambahan kenyamanan dan isolasi dari tanah, memastikan tidur yang nyenyak dan nyaman di lapangan.",
                "cover" => null
            ],
            [
                "name" => "Cover bag",
                "price" => 5000,
                "description" => "Cover bag yang dirancang untuk melindungi tas Anda dari hujan dan debu. Dapat digunakan oleh 1 orang, cover ini sangat berguna untuk menjaga perlengkapan tetap kering dan bersih di berbagai kondisi cuaca. Ideal untuk berkemah dalam waktu 1-2 hari di medan umum, cover bag ini menawarkan perlindungan tambahan untuk barang-barang Anda.",
                "cover" => null
            ],
            [
                "name" => "Lamp camp",
                "price" => 5000,
                "description" => "Lamp camp yang memberikan penerangan yang cukup di area perkemahan. Mudah dipasang dan digunakan, lampu ini cocok untuk 1-4 orang dan ideal untuk berbagai kondisi cuaca. Sangat berguna untuk berkemah selama 1-2 hari di medan umum, lampu ini memastikan area perkemahan Anda terang dan nyaman di malam hari.",
                "cover" => null
            ],
            [
                "name" => "Headlamp",
                "price" => 5000,
                "description" => "Headlamp yang memberikan penerangan kuat dan tahan lama, ideal untuk penggunaan malam hari atau dalam kondisi minim cahaya. Cocok untuk 1 orang, headlamp ini sangat berguna untuk mendaki atau berkemah di medan berat selama 1-2 hari. Fitur utamanya adalah kemampuannya untuk memberikan penerangan hands-free, meningkatkan kenyamanan dan keamanan saat beraktivitas di malam hari.",
                "cover" => null
            ],
            [
                "name" => "Sepatu",
                "price" => 18000,
                "description" => "Sepatu tahan lama yang dirancang untuk memberikan kenyamanan dan perlindungan kaki dalam berbagai jenis kegiatan outdoor. Dengan grip yang baik dan bahan yang tahan lama, sepatu ini ideal untuk 1 orang dan cocok untuk berkemah selama 2 hari di medan umum. Sepatu ini menawarkan perlindungan dan kenyamanan yang optimal selama perjalanan outdoor Anda.",
                "cover" => null
            ],
            [
                "name" => "Jaket",
                "price" => 15000,
                "description" => "Jaket yang memberikan kehangatan dan perlindungan dari angin. Dirancang untuk berbagai kondisi cuaca, jaket ini ideal untuk 1 orang dan cocok untuk berkemah selama 1-2 hari di medan umum. Fitur utama dari jaket ini adalah kemampuannya untuk melindungi dari angin dan menjaga suhu tubuh tetap stabil.",
                "cover" => null
            ],
            [
                "name" => "Flysheet",
                "price" => 10000,
                "description" => "Flysheet tambahan yang dapat digunakan sebagai penutup tambahan untuk tenda atau sebagai pelindung dari hujan dan sinar matahari. Mudah dipasang dan dibawa, ideal untuk 1 tenda dan cocok untuk berkemah selama 1-2 hari di medan umum. Flysheet ini memberikan perlindungan ekstra untuk tenda dan memastikan kenyamanan selama berkemah di berbagai kondisi cuaca.",
                "cover" => null
            ],
            [
                "name" => "Meja & Kursi lipat",
                "price" => 10000,
                "description" => "Meja dan kursi lipat yang ringan dan mudah dibawa, ideal untuk bersantai di pantai dengan kenyamanan ekstra. Cocok untuk 1-2 orang dan penggunaan singkat selama 1 hari di medan pantai. Meja dan kursi ini menawarkan kemudahan dalam penyimpanan dan transportasi, serta kenyamanan saat bersantai di luar ruangan.",
                "cover" => null
            ],
            [
                "name" => "Hammock",
                "price" => 6000,
                "description" => "Hammock yang dirancang untuk memberikan kenyamanan maksimal saat bersantai di pantai. Mudah dipasang antara dua titik penyangga, cocok untuk 1 orang dan sangat ideal untuk penggunaan singkat di medan pantai. Hammock ini menawarkan pengalaman bersantai yang nyaman dan praktis di luar ruangan.",
                "cover" => null
            ],
            [
                "name" => "Gas",
                "price" => 6000,
                "description" => "Gas isi ulang yang cocok untuk digunakan dengan kompor portabel. Memberikan sumber bahan bakar yang stabil dan mudah digunakan, ideal untuk 1-4 orang dan sangat cocok untuk berkemah selama 1-2 hari di medan umum. Gas ini memastikan ketersediaan bahan bakar yang andal untuk kebutuhan memasak saat berkemah.",
                "cover" => null
            ]
        ];

        foreach ($items as $item) {
            DB::table('camping')->insert([
                'name' => $item['name'],
                'price' => $item['price'],
                'description' => $item['description'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
