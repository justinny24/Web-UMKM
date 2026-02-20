<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('consultations', function (Blueprint $table) {
        $table->id();
        // Relasi ke User (UMKM/Siswa/Guru) yang merequest
        $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
        // Relasi ke Dosen yang dipilih
        $table->foreignId('dosen_id')->constrained('users')->onDelete('cascade');
        
        $table->dateTime('schedule_date'); // Jadwal konsul
        $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
        
        // Wajib diisi dosen jika mereject request
        $table->text('reject_reason')->nullable();
        
        // Disediakan oleh Admin (Fasilitator Zoom)
        $table->string('zoom_link')->nullable(); 
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
