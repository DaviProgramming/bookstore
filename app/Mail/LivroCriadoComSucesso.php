<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LivroCriadoComSucesso extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    public $name;
    public $book;

    public function __construct($name, $book)
    {
        //
        $this->name = $name;
        $this->book = $book;
        
    }

    public function build(){

        return $this->view('emails.livro-criado')->subject('Livro criado')->with(['name' => $this->name, 'book' => $this->book]);

    }

    
}
