<?php

namespace Database\Seeders;

use App\Models\SimulasiKasus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SimulasiKasusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SimulasiKasus::insert([
            [
                'tag'        => 'Usia 16 tahun',
                'skenario'   => 'Sudah 2 minggu tidak mau keluar kamar. Nilai sekolah turun drastis dan sering menangis tanpa sebab yang jelas.',
                'pertanyaan' => 'Apa yang sebaiknya dilakukan orang tua?',
                'pilihan'    => json_encode([
                    ['id' => 'A', 'teks' => 'Marahi agar tidak cengeng'],
                    ['id' => 'B', 'teks' => 'Biarkan saja, nanti sembuh sendiri'],
                    ['id' => 'C', 'teks' => 'Ajak bicara lalu konsultasi ke profesional', 'benar' => true],
                    ['id' => 'D', 'teks' => 'Larang bermain HP dan media sosial'],
                ]),
                'pembahasan' => 'Gejala seperti menarik diri, penurunan akademik, dan menangis terus-menerus selama 2 minggu bisa menjadi tanda depresi. Orang tua perlu mendengarkan tanpa menghakimi, lalu mencari bantuan profesional.',
                'urutan'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tag'        => 'Usia 14 tahun',
                'skenario'   => 'Tiba-tiba berhenti dari semua kegiatan yang dulu disukai, sering marah tanpa sebab, dan tidur berlebihan.',
                'pertanyaan' => 'Respons orang tua yang paling tepat adalah?',
                'pilihan'    => json_encode([
                    ['id' => 'A', 'teks' => 'Paksa ikut kegiatan seperti dulu'],
                    ['id' => 'B', 'teks' => 'Tanya perasaannya dengan tenang dan dengarkan', 'benar' => true],
                    ['id' => 'C', 'teks' => 'Hubungi guru BK saja, itu bukan urusan keluarga'],
                    ['id' => 'D', 'teks' => 'Beri hadiah supaya semangat lagi'],
                ]),
                'pembahasan' => 'Kehilangan minat, mudah marah, dan hipersomnia adalah gejala depresi yang umum pada remaja. Pendekatan pertama yang terbaik adalah komunikasi yang hangat dan tanpa penilaian.',
                'urutan'     => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tag'        => 'Usia 17 tahun',
                'skenario'   => 'Mengatakan sering merasa cemas berlebihan menjelang ujian hingga sakit perut dan tidak bisa tidur.',
                'pertanyaan' => 'Langkah yang paling membantu adalah?',
                'pilihan'    => json_encode([
                    ['id' => 'A', 'teks' => 'Katakan semua anak merasakannya, biasa saja'],
                    ['id' => 'B', 'teks' => 'Tambah jam belajar agar lebih siap'],
                    ['id' => 'C', 'teks' => 'Validasi perasaannya lalu ajarkan teknik relaksasi', 'benar' => true],
                    ['id' => 'D', 'teks' => 'Larang mengikuti ujian agar tidak stres'],
                ]),
                'pembahasan' => 'Kecemasan ujian dengan gejala fisik menunjukkan respons stres yang tinggi. Validasi emosi anak penting agar ia merasa dipahami. Teknik relaksasi seperti pernapasan dalam dapat membantu.',
                'urutan'     => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
