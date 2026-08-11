<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | BOOK 1
        |--------------------------------------------------------------------------
        */

        $book1 = DB::table('books')->insertGetId([
            'unique_key' => 'BOOK-001',
            'title' => 'Introduction to Programming',
            'author' => 'John Smith',
            'call_number' => 'QA76.6 S65 2025',
            'sublocation' => 'Information Technology Section',
            'publisher' => 'TechPress Publishing',
            'year' => '2025',
            'edition' => '1st Edition',
            'format' => 'Print',
            'content_type' => 'Text',
            'media_type' => 'Unmediated',
            'carrier_type' => 'Volume',
            'isbn' => '9781234567890',
            'issn' => null,
            'lccn' => null,
            'subjects' => 'Programming, Computer Science, Information Technology',
            'additional_details' => 'Basic introduction to programming concepts.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('book_copies')->insert([
            [
                'book_id' => $book1,
                'barcode' => 'LC-BOOK-0001',
                'accession_number' => 'ACC-0001',
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'book_id' => $book1,
                'barcode' => 'LC-BOOK-0002',
                'accession_number' => 'ACC-0002',
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | BOOK 2
        |--------------------------------------------------------------------------
        */

        $book2 = DB::table('books')->insertGetId([
            'unique_key' => 'BOOK-002',
            'title' => 'Database Management Systems',
            'author' => 'Maria Santos',
            'call_number' => 'QA76.9 D3 S26 2024',
            'sublocation' => 'Information Technology Section',
            'publisher' => 'Academic Press',
            'year' => '2024',
            'edition' => '2nd Edition',
            'format' => 'Print',
            'content_type' => 'Text',
            'media_type' => 'Unmediated',
            'carrier_type' => 'Volume',
            'isbn' => '9780987654321',
            'issn' => null,
            'lccn' => null,
            'subjects' => 'Database, SQL, Information Systems',
            'additional_details' => 'Covers database design, SQL, and database management.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('book_copies')->insert([
            [
                'book_id' => $book2,
                'barcode' => 'LC-BOOK-0003',
                'accession_number' => 'ACC-0003',
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'book_id' => $book2,
                'barcode' => 'LC-BOOK-0004',
                'accession_number' => 'ACC-0004',
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | BOOK 3
        |--------------------------------------------------------------------------
        */

        $book3 = DB::table('books')->insertGetId([
            'unique_key' => 'BOOK-003',
            'title' => 'Computer Networking',
            'author' => 'Robert Garcia',
            'call_number' => 'TK5105.5 G37 2025',
            'sublocation' => 'Information Technology Section',
            'publisher' => 'Digital Learning Press',
            'year' => '2025',
            'edition' => '1st Edition',
            'format' => 'Print',
            'content_type' => 'Text',
            'media_type' => 'Unmediated',
            'carrier_type' => 'Volume',
            'isbn' => '9782222222222',
            'issn' => null,
            'lccn' => null,
            'subjects' => 'Computer Networks, Networking, Internet',
            'additional_details' => 'Introduction to networking concepts and protocols.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('book_copies')->insert([
            [
                'book_id' => $book3,
                'barcode' => 'LC-BOOK-0005',
                'accession_number' => 'ACC-0005',
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'book_id' => $book3,
                'barcode' => 'LC-BOOK-0006',
                'accession_number' => 'ACC-0006',
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}