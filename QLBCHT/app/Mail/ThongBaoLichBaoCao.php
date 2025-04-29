<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\LichBaoCao;
class ThongBaoLichBaoCao extends Mailable
{
    use Queueable, SerializesModels;
    public $lichBaoCao;
    /**
     * Create a new message instance.
     */
    public function __construct(LichBaoCao $lichBaoCao)
    {
        $this->lichBaoCao = $lichBaoCao;
    }

    public function build()
    {
        return $this->subject('Thông báo: Bạn có lịch sinh hoạt học thuật mới!')
                    ->view('emails.thongbao-lich');
    }

    /**
     * Get the message envelope.
     */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'Thong Bao Dang Ky Bao Cao',
    //     );
    // }

    // /**
    //  * Get the message content definition.
    //  */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'view.name',
    //     );
    // }

    // /**
    //  * Get the attachments for the message.
    //  *
    //  * @return array<int, \Illuminate\Mail\Mailables\Attachment>
    //  */
    // public function attachments(): array
    // {
    //     return [];
    // }
}
