<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DealEnd extends Mailable
{
    use Queueable, SerializesModels;

    protected $title;
    protected $user_name;
    protected $item;
    protected $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_name, $item, $url)
    {
        $this->title = "取引完了メール";
        $this->user_name = $user_name;
        $this->item = $item;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.deal_end_mail')
                    ->subject($this->title)
                    ->with([
                        'user_name' => $this->user_name,
                        'item' => $this->item,
                        'url' => $this->url,
                    ]);

    }
}
