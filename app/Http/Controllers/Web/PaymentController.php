<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\DataService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $dataService;

    public function __construct(DataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Upload bukti bayar QRIS
     */
    public function uploadProof(Request $request, $orderId)
    {
        $request->validate([
            'proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'sender_name' => 'required|string|max:100'
        ]);

        $order = $this->dataService->getOrderById($orderId);
        if (!$order) {
            return back()->with('error', 'Pesanan tidak ditemukan.');
        }

        // Simpan file
        $file = $request->file('proof');
        $filename = 'proof_' . $orderId . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/payment-proofs'), $filename);

        // Update order
        $this->dataService->uploadPaymentProof($orderId, [
            'filename' => $filename,
            'path' => '/uploads/payment-proofs/' . $filename,
            'sender_name' => $request->sender_name,
            'uploaded_at' => now()->toDateTimeString()
        ]);

        return redirect('/invoice/' . $orderId)->with('success', 'Bukti pembayaran berhasil diupload! Menunggu verifikasi admin.');
    }

    /**
     * Admin verifikasi pembayaran
     */
    public function verify(Request $request, $orderId)
    {
        $request->validate([
            'status' => 'required|in:VERIFIED,REJECTED',
            'note' => 'nullable|string|max:255'
        ]);

        $this->dataService->verifyPayment($orderId, $request->status, $request->note);

        $message = $request->status === 'VERIFIED' 
            ? 'Pembayaran berhasil diverifikasi!' 
            : 'Pembayaran ditolak.';

        return redirect('/admin/orders/' . $orderId)->with('success', $message);
    }

    /**
     * Halaman struk pembelian
     */
    public function receipt($orderId)
    {
        $order = $this->dataService->getOrderById($orderId);
        if (!$order) {
            abort(404);
        }
        return view('invoice.receipt', compact('order'));
    }
}