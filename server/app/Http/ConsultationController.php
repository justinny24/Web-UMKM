<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    // 1. Klien Booking Jadwal
    public function book(Request $request)
    {
        $request->validate([
            'lecturer_id' => 'required|exists:users,id',
            'schedule' => 'required|date'
        ]);

        $consultation = Consultation::create([
            'user_id' => $request->user()->id,
            'lecturer_id' => $request->lecturer_id,
            'schedule' => $request->schedule,
            'status' => 'pending'
        ]);

        return response()->json(['message' => 'Booking berhasil dibuat', 'data' => $consultation], 201);
    }

    // 2. Dosen Accept/Reject Request
    public function respondRequest(Request $request, $id)
    {
        $consultation = Consultation::findOrFail($id);

        // Pastikan hanya dosen yang dituju yang bisa merespon
        if ($consultation->lecturer_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'status' => 'required|in:accepted,rejected',
            'rejection_reason' => 'required_if:status,rejected' // Wajib diisi jika ditolak
        ]);

        $consultation->update([
            'status' => $request->status,
            'rejection_reason' => $request->status === 'rejected' ? $request->rejection_reason : null
        ]);

        return response()->json(['message' => 'Status berhasil diupdate', 'data' => $consultation]);
    }

    // 3. Admin Input Link Zoom
    public function addZoomLink(Request $request, $id)
    {
        // Disini kamu idealnya menambahkan middleware pengecekan role 'admin'
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Hanya admin yang bisa input link zoom'], 403);
        }

        $request->validate([
            'zoom_link' => 'required|url'
        ]);

        $consultation = Consultation::findOrFail($id);
        $consultation->update(['zoom_link' => $request->zoom_link]);

        return response()->json(['message' => 'Link Zoom berhasil ditambahkan', 'data' => $consultation]);
    }
}