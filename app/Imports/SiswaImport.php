<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class SiswaImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    protected int $importedCount = 0;
    protected int $skippedCount = 0;
    protected array $errors = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            $rowNumber = $index + 2; // Baris 1 adalah header di file Excel

            // Normalisasi nilai kolom
            $username = trim((string)($row['username'] ?? $row['user_name'] ?? ''));
            $email = trim((string)($row['email'] ?? ''));
            $password = trim((string)($row['password'] ?? ''));
            $namaLengkap = trim((string)($row['nama_lengkap'] ?? $row['nama'] ?? $row['nama_siswa'] ?? ''));
            $nisn = !empty($row['nisn']) ? trim((string)$row['nisn']) : null;
            $nis = !empty($row['nis']) ? trim((string)$row['nis']) : null;
            $jkRaw = trim((string)($row['jenis_kelamin'] ?? $row['jenis_kelamin_lp'] ?? $row['jk'] ?? ''));

            // Abaikan jika baris benar-benar kosong
            if (empty($namaLengkap) && empty($username) && empty($email) && empty($nisn) && empty($nis)) {
                continue;
            }

            // Validasi nama lengkap
            if (empty($namaLengkap)) {
                $this->errors[] = "Baris {$rowNumber}: Nama lengkap wajib diisi.";
                $this->skippedCount++;
                continue;
            }

            // Validasi / penentuan username
            if (empty($username)) {
                if (!empty($nisn)) {
                    $username = $nisn;
                } else {
                    $this->errors[] = "Baris {$rowNumber} ({$namaLengkap}): Username wajib diisi.";
                    $this->skippedCount++;
                    continue;
                }
            }

            if (User::where('username', $username)->exists()) {
                $this->errors[] = "Baris {$rowNumber} ({$namaLengkap}): Username '{$username}' sudah terdaftar.";
                $this->skippedCount++;
                continue;
            }

            // Validasi / penentuan email
            if (empty($email)) {
                $email = strtolower($username) . '@siswa.sdn3krenceng.sch.id';
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->errors[] = "Baris {$rowNumber} ({$namaLengkap}): Format email '{$email}' tidak valid.";
                $this->skippedCount++;
                continue;
            }

            if (User::where('email', $email)->exists()) {
                $this->errors[] = "Baris {$rowNumber} ({$namaLengkap}): Email '{$email}' sudah terdaftar.";
                $this->skippedCount++;
                continue;
            }

            // Password
            if (empty($password)) {
                $password = 'password123';
            } elseif (strlen($password) < 8) {
                $this->errors[] = "Baris {$rowNumber} ({$namaLengkap}): Password minimal 8 karakter.";
                $this->skippedCount++;
                continue;
            }

            // Validasi keunikan NISN & NIS jika diisi
            if (!empty($nisn) && Siswa::where('nisn', $nisn)->exists()) {
                $this->errors[] = "Baris {$rowNumber} ({$namaLengkap}): NISN '{$nisn}' sudah terdaftar.";
                $this->skippedCount++;
                continue;
            }

            if (!empty($nis) && Siswa::where('nis', $nis)->exists()) {
                $this->errors[] = "Baris {$rowNumber} ({$namaLengkap}): NIS '{$nis}' sudah terdaftar.";
                $this->skippedCount++;
                continue;
            }

            // Normalisasi Jenis Kelamin (L / P)
            $jenisKelamin = null;
            if (!empty($jkRaw)) {
                $initial = strtoupper(substr($jkRaw, 0, 1));
                if (in_array($initial, ['L', 'P'])) {
                    $jenisKelamin = $initial;
                }
            }

            try {
                DB::transaction(function () use ($username, $email, $password, $namaLengkap, $nisn, $nis, $jenisKelamin) {
                    $user = User::create([
                        'username' => $username,
                        'email' => $email,
                        'password' => Hash::make($password),
                        'role' => 'siswa',
                    ]);

                    Siswa::create([
                        'user_id' => $user->id,
                        'nama_lengkap' => $namaLengkap,
                        'nisn' => $nisn,
                        'nis' => $nis,
                        'jenis_kelamin' => $jenisKelamin,
                        'is_active' => true,
                    ]);
                });

                $this->importedCount++;
            } catch (\Throwable $e) {
                $this->errors[] = "Baris {$rowNumber} ({$namaLengkap}): Terjadi kesalahan saat menyimpan (" . $e->getMessage() . ").";
                $this->skippedCount++;
            }
        }
    }

    public function getImportedCount(): int
    {
        return $this->importedCount;
    }

    public function getSkippedCount(): int
    {
        return $this->skippedCount;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
