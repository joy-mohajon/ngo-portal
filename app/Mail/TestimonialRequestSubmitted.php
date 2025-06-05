<?php

namespace App\Mail;

use App\Models\Testimonial;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class TestimonialRequestSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The testimonial instance.
     *
     * @var \App\Models\Testimonial
     */
    public $testimonial;

    /**
     * Create a new message instance.
     */
    public function __construct(Testimonial $testimonial)
    {
        $this->testimonial = $testimonial;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new \Illuminate\Mail\Mailables\Address('codecode2024@gmail.com', 'NGO Portal'),
            subject: 'New Testimonial Request Submitted',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.testimonial-request-submitted',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];
        
        // Check if the testimonial has an application file
        if ($this->testimonial->application_file && Storage::disk('public')->exists($this->testimonial->application_file)) {
            $filePath = storage_path('app/public/' . $this->testimonial->application_file);
            $fileName = basename($this->testimonial->application_file);
            
            $attachments[] = Attachment::fromPath($filePath)
                ->as($fileName)
                ->withMime(mime_content_type($filePath));
        }
        
        return $attachments;
    }
} 