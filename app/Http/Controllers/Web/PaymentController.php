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

        // Pastikan folder ada
        $uploadPath = public_path('uploads/payment-proofs');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Simpan file
        $file = $request->file('proof');
        $filename = 'proof_' . $orderId . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move($uploadPath, $filename);

        // Upload bukti + auto PAID
        $this->dataService->uploadPaymentProof($orderId, [
            'filename' => $filename,
            'path' => '/uploads/payment-proofs/' . $filename,
            'sender_name' => $request->sender_name,
            'uploaded_at' => now()->toDateTimeString()
        ]);

        return redirect('/invoice/' . $orderId)->with('success', '✅ Bukti pembayaran berhasil diupload! Pembayaran Anda telah dikonfirmasi.');
    }

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

    public function receipt($orderId)
    {
        $order = $this->dataService->getOrderById($orderId);
        if (!$order) {
            abort(404);
        }
        return view('invoice.receipt', compact('order'));
    }
}