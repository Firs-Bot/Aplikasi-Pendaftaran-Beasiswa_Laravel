<?php

namespace Tests\Feature;

use App\Models\Beasiswa;
use App\Models\Pendaftaran;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_security_headers_are_present_on_responses(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->assertHeader('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
        $this->assertNotNull($response->headers->get('Content-Security-Policy'));
    }

    public function test_rbac_prevents_cross_role_access(): void
    {
        $mhs = User::factory()->create();
        $baak = User::factory()->baak()->create();
        $admin = User::factory()->admin()->create();

        $this->actingAs($mhs)->get('/admin/dashboard')->assertForbidden();
        $this->actingAs($mhs)->get('/baak/dashboard')->assertForbidden();

        $this->actingAs($baak)->get('/admin/dashboard')->assertForbidden();
        $this->actingAs($baak)->get('/mahasiswa/dashboard')->assertForbidden();

        $this->actingAs($admin)->get('/baak/dashboard')->assertForbidden();
        $this->actingAs($admin)->get('/mahasiswa/dashboard')->assertForbidden();
    }

    public function test_idor_protection_on_document_download_and_pendaftaran_update(): void
    {
        Storage::fake('local');

        $owner = User::factory()->create(['nim_username' => '20240810001']);
        $otherStudent = User::factory()->create(['nim_username' => '20240810002']);
        $baak = User::factory()->baak()->create();

        $beasiswa = Beasiswa::create([
            'nama_beasiswa' => 'Beasiswa Prestasi',
            'penyedia' => 'UNIKU',
            'deskripsi' => 'Deskripsi beasiswa',
        ]);

        Storage::disk('local')->put('uploads/dokumen/test-ktp.pdf', '%PDF-1.4 sample');

        $pendaftaran = Pendaftaran::create([
            'user_id' => $owner->id,
            'beasiswa_id' => $beasiswa->id,
            'nama_lengkap' => $owner->nama_lengkap,
            'nim' => $owner->nim_username,
            'jenis_kelamin' => 'Laki-laki',
            'jurusan' => 'S1 Teknik Informatika',
            'email' => 'owner@uniku.ac.id',
            'no_hp' => '081234567890',
            'penghasilan_ortu' => '1000000 - 1500000',
            'file_sktm' => 'uploads/dokumen/test-ktp.pdf',
            'file_transkrip' => 'uploads/dokumen/test-ktp.pdf',
            'file_ktp' => 'uploads/dokumen/test-ktp.pdf',
            'status_verifikasi' => 'MENUNGGU',
        ]);

        // Guest must redirect to login
        $this->get(route('pendaftaran.dokumen', [$pendaftaran->id, 'ktp']))
            ->assertRedirect('/login');

        // Another student gets 403
        $this->actingAs($otherStudent)
            ->get(route('pendaftaran.dokumen', [$pendaftaran->id, 'ktp']))
            ->assertForbidden();

        // Owner and BAAK get 200
        $this->actingAs($owner)
            ->get(route('pendaftaran.dokumen', [$pendaftaran->id, 'ktp']))
            ->assertOk();

        $this->actingAs($baak)
            ->get(route('pendaftaran.dokumen', [$pendaftaran->id, 'ktp']))
            ->assertOk();

        // Another student cannot update owner's pendaftaran
        $this->actingAs($otherStudent)
            ->put(route('mhs.pendaftaran.update', $pendaftaran->id), [
                'email' => 'attacker@example.com',
                'no_hp' => '081299999999',
                'penghasilan_ortu' => '< 500000',
            ])
            ->assertForbidden();

        // Owner cannot update once status is no longer MENUNGGU
        $pendaftaran->update(['status_verifikasi' => 'LOLOS']);
        $this->actingAs($owner)
            ->put(route('mhs.pendaftaran.update', $pendaftaran->id), [
                'email' => 'changed@example.com',
                'no_hp' => '081299999999',
                'penghasilan_ortu' => '< 500000',
            ])
            ->assertForbidden();
    }

    public function test_mahasiswa_cannot_spoof_nim_or_nama_when_submitting_pendaftaran(): void
    {
        Storage::fake('local');

        $mhs = User::factory()->create([
            'nama_lengkap' => 'Nama Asli',
            'nim_username' => '20240810011',
        ]);

        $beasiswa = Beasiswa::create([
            'nama_beasiswa' => 'Beasiswa KIP',
            'penyedia' => 'Kemendikbud',
            'deskripsi' => 'Bantuan pendidikan',
        ]);

        $pdf = UploadedFile::fake()->create('doc.pdf', 100, 'application/pdf');

        $response = $this->actingAs($mhs)->post(route('mhs.pendaftaran.store'), [
            'beasiswa_id' => $beasiswa->id,
            'nama_lengkap' => 'Nama Palsu <script>alert(1)</script>',
            'nim' => '99999999999',
            'jenis_kelamin' => 'Laki-laki',
            'jurusan' => 'S1 Teknik Informatika',
            'email' => 'asli@uniku.ac.id',
            'no_hp' => '081234567890',
            'penghasilan_ortu' => '500000 - 1000000',
            'sktm' => $pdf,
            'transkrip' => UploadedFile::fake()->create('t.pdf', 100, 'application/pdf'),
            'aktif_kuliah' => UploadedFile::fake()->create('a.pdf', 100, 'application/pdf'),
            'ktp' => UploadedFile::fake()->create('k.pdf', 100, 'application/pdf'),
            'ktm' => UploadedFile::fake()->create('m.pdf', 100, 'application/pdf'),
            'krs' => UploadedFile::fake()->create('r.pdf', 100, 'application/pdf'),
            'tidak_menerima_beasiswa' => UploadedFile::fake()->create('n.pdf', 100, 'application/pdf'),
        ]);

        $response->assertRedirect(route('mhs.dashboard'));
        $this->assertDatabaseHas('pendaftarans', [
            'user_id' => $mhs->id,
            'nama_lengkap' => 'Nama Asli',
            'nim' => '20240810011',
        ]);
    }

    public function test_admin_can_update_pendaftaran_and_baak_can_export_pdf(): void
    {
        Storage::fake('local');

        $admin = User::factory()->admin()->create();
        $baak = User::factory()->baak()->create();
        $mhs = User::factory()->create();

        $beasiswa = Beasiswa::create([
            'nama_beasiswa' => 'Beasiswa Unggulan',
            'penyedia' => 'UNIKU',
            'deskripsi' => '<script>alert("xss")</script>Beasiswa unggulan',
        ]);

        $pendaftaran = Pendaftaran::create([
            'user_id' => $mhs->id,
            'beasiswa_id' => $beasiswa->id,
            'nama_lengkap' => $mhs->nama_lengkap,
            'nim' => $mhs->nim_username,
            'jenis_kelamin' => 'Perempuan',
            'jurusan' => 'S1 Akuntansi',
            'email' => 'mhs@uniku.ac.id',
            'no_hp' => '081234567890',
            'penghasilan_ortu' => '1000000 - 1500000',
            'file_sktm' => 'uploads/dokumen/a.pdf',
            'file_transkrip' => 'uploads/dokumen/b.pdf',
            'status_verifikasi' => 'MENUNGGU',
        ]);

        // Admin update works without unknown column SQL errors
        $adminResponse = $this->actingAs($admin)->put(route('admin.pendaftaran.update', $pendaftaran->id), [
            'nama_lengkap' => 'Nama Diubah Admin',
            'nim' => $mhs->nim_username,
            'email' => 'baru@uniku.ac.id',
            'no_hp' => '081234567891',
            'jenis_kelamin' => 'Perempuan',
            'jurusan' => 'S1 Akuntansi',
            'penghasilan_ortu' => '1500000 - 2000000',
            'status_verifikasi' => 'LOLOS',
        ]);

        $adminResponse->assertRedirect();
        $this->assertDatabaseHas('pendaftarans', [
            'id' => $pendaftaran->id,
            'nama_lengkap' => 'Nama Diubah Admin',
            'status_verifikasi' => 'LOLOS',
        ]);

        // XSS payload in SQLi search does not crash and output is escaped
        $searchResponse = $this->actingAs($admin)->get(route('admin.beasiswa.index', ['search' => "' OR 1=1 -- %_"]));
        $searchResponse->assertOk();

        // BAAK PDF export returns downloadable PDF
        $pdfResponse = $this->actingAs($baak)->get(route('baak.pendaftaran.pdf'));
        $pdfResponse->assertOk();
        $this->assertStringContainsString('application/pdf', (string) $pdfResponse->headers->get('content-type'));
    }
}
