<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class HuyDangKySHHTMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $lichBaoCao;
    public $giangVien;

    public function __construct($lichBaoCao, $giangVien)
    {
        $this->lichBaoCao = $lichBaoCao;
        $this->giangVien = $giangVien;
    }

    public function build()
    {
        return $this->subject('Giảng viên hủy đăng ký lịch báo cáo')
                    ->view('emails.thongbao-huyDangKySHHT')
                    ->with([
                        'chuDe' => $this->lichBaoCao->chuDe,
                        'ngayBaoCao' => $this->lichBaoCao->ngayBaoCao,
                        'gioBaoCao' => $this->lichBaoCao->gioBaoCao,
                        'boMon' => $this->lichBaoCao->boMon->tenBoMon ?? 'Chưa xác định',
                        'giangVienHuyDangKy' => $this->giangVien, // người vừa hủy
                        'giangVienLenLich' => $this->lichBaoCao->giangVien, // người lên lịch
                        'lichBaoCao' => $this->lichBaoCao,
                    ]);
    }
}
