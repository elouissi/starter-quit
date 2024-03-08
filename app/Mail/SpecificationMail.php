<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SpecificationMail extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   */

  protected $specification;

  public function __construct($specification)
  {
    //
    $this->specification = $specification;
  }

  public function build()
  {
    // Check if pdf_file exists and is not null
    if ($this->specification->pdf_link) {
      return $this->view('content.specifications.mail')
        ->attach($this->specification->pdf_link, [
          'as' => $this->specification->entreprise_name . '_' . date('Y-m-d h-i-s') . '.pdf',
          'mime' => 'application/pdf',
        ])
        ->subject('Votre Cahier des Charges est Prêt sur mycdc.fr');
    } else {
      // Handle the case where pdf_file is null or does not exist
      // For example, log an error or proceed without attaching the file
      return $this->view('content.specifications.mail')
        ->subject('Votre Cahier des Charges est Prêt sur mycdc.fr');
    }
  }
}
  // /**
  //  * Get the message envelope.
  //  */
  // public function envelope(): Envelope
  // {
  //   return new Envelope(
  //     subject: 'Specification Mail',
  //   );
  // }

  // /**
  //  * Get the message content definition.
  //  */
  // public function content(): Content
  // {
  //   return new Content(
  //     view: 'view.name',
  //   );
  // }

  // /**
  //  * Get the attachments for the message.
  //  *
  //  * @return array<int, \Illuminate\Mail\Mailables\Attachment>
  //  */
  // public function attachments(): array
  // {
  //   return [];
  // }
