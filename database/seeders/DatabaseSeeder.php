<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Book;
use App\Models\Member;
use App\Models\Loan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@perpustakaan.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Sample Books
        $books = [
            ['kode_buku' => 'BK001', 'judul' => 'Laskar Pelangi', 'penulis' => 'Andrea Hirata', 'penerbit' => 'Bentang Pustaka', 'tahun_terbit' => 2005, 'kategori' => 'Novel', 'stok' => 3],
            ['kode_buku' => 'BK002', 'judul' => 'Bumi Manusia', 'penulis' => 'Pramoedya Ananta Toer', 'penerbit' => 'Lentera Dipantara', 'tahun_terbit' => 1980, 'kategori' => 'Novel', 'stok' => 2],
            ['kode_buku' => 'BK003', 'judul' => 'Pemrograman Web dengan Laravel', 'penulis' => 'Ahmad Fauzi', 'penerbit' => 'Informatika', 'tahun_terbit' => 2022, 'kategori' => 'Teknologi', 'stok' => 5],
            ['kode_buku' => 'BK004', 'judul' => 'Sejarah Indonesia Modern', 'penulis' => 'M.C. Ricklefs', 'penerbit' => 'Gadjah Mada University Press', 'tahun_terbit' => 2001, 'kategori' => 'Sejarah', 'stok' => 2],
            ['kode_buku' => 'BK005', 'judul' => 'Pengantar Algoritma', 'penulis' => 'Thomas H. Cormen', 'penerbit' => 'MIT Press', 'tahun_terbit' => 2009, 'kategori' => 'Teknologi', 'stok' => 4],
            ['kode_buku' => 'BK006', 'judul' => 'Ekonomi Makro', 'penulis' => 'N. Gregory Mankiw', 'penerbit' => 'Erlangga', 'tahun_terbit' => 2018, 'kategori' => 'Ekonomi', 'stok' => 3],
            ['kode_buku' => 'BK007', 'judul' => 'Sang Pemimpi', 'penulis' => 'Andrea Hirata', 'penerbit' => 'Bentang Pustaka', 'tahun_terbit' => 2006, 'kategori' => 'Novel', 'stok' => 2],
            ['kode_buku' => 'BK008', 'judul' => 'Psikologi Umum', 'penulis' => 'Sarlito Wirawan Sarwono', 'penerbit' => 'Rajawali Pers', 'tahun_terbit' => 2013, 'kategori' => 'Psikologi', 'stok' => 3],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }

        // Sample Members with user accounts
        $membersData = [
            ['nim' => '2021001', 'nama' => 'Budi Santoso', 'email' => 'budi@mahasiswa.ac.id', 'alamat' => 'Jl. Merdeka No. 1, Jakarta'],
            ['nim' => '2021002', 'nama' => 'Siti Rahayu', 'email' => 'siti@mahasiswa.ac.id', 'alamat' => 'Jl. Sudirman No. 5, Bandung'],
            ['nim' => '2021003', 'nama' => 'Ahmad Firdaus', 'email' => 'ahmad@mahasiswa.ac.id', 'alamat' => 'Jl. Diponegoro No. 10, Surabaya'],
        ];

        foreach ($membersData as $m) {
            $user = User::create([
                'name' => $m['nama'],
                'email' => $m['email'],
                'password' => Hash::make('password'),
                'role' => 'member',
            ]);
            Member::create([...$m, 'user_id' => $user->id]);
        }

        // Sample Loans
        $member1 = Member::first();
        $book1 = Book::first();
        if ($member1 && $book1) {
            Loan::create([
                'member_id' => $member1->id,
                'book_id' => $book1->id,
                'user_id' => 1,
                'tanggal_pinjam' => Carbon::now()->subDays(7),
                'tanggal_kembali' => Carbon::now()->addDays(7),
                'status' => 'dipinjam',
            ]);
        }
    }
}
