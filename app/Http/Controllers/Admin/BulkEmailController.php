<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Exception;

class BulkEmailController extends Controller
{
    public function index()
    {
        $subscribers = NewsletterSubscriber::all();
        return view('admin.bulk-email.index', compact('subscribers'));
    }

    public function send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Log the mail configuration (without sensitive data)
            Log::info('Mail Configuration:', [
                'driver' => config('mail.default'),
                'host' => config('mail.mailers.smtp.host'),
                'port' => config('mail.mailers.smtp.port'),
                'encryption' => config('mail.mailers.smtp.encryption'),
                'from_address' => config('mail.from.address'),
                'from_name' => config('mail.from.name')
            ]);

            $subscribers = NewsletterSubscriber::all();
            $totalSubscribers = $subscribers->count();
            $successCount = 0;
            $failCount = 0;
            
            // Test email configuration first
            try {
                Mail::raw('Testing email configuration', function($message) {
                    $message->to(config('mail.from.address'))
                            ->subject('Email Configuration Test');
                });
                Log::info('Test email sent successfully');
            } catch (Exception $e) {
                Log::error('Test email failed: ' . $e->getMessage());
                return redirect()->back()
                    ->with('error', 'Email configuration test failed: ' . $e->getMessage())
                    ->withInput();
            }

            // Process subscribers in chunks
            $subscribers->chunk(10)->each(function ($chunk) use ($request, &$successCount, &$failCount) {
                foreach ($chunk as $subscriber) {
                    try {
                        Log::info('Attempting to send email to: ' . $subscriber->email);
                        
                        Mail::send('emails.newsletter', 
                            ['content' => $request->message], 
                            function($message) use ($request, $subscriber) {
                                $message->from(config('mail.from.address'), config('mail.from.name'))
                                        ->to($subscriber->email)
                                        ->subject($request->subject);
                            }
                        );
                        
                        $successCount++;
                        Log::info('Successfully sent email to: ' . $subscriber->email);
                        
                        // Add a small delay to avoid rate limiting
                        sleep(1);
                        
                    } catch (Exception $e) {
                        $failCount++;
                        Log::error('Failed to send email to: ' . $subscriber->email . ' - Error: ' . $e->getMessage());
                        continue;
                    }
                }
            });

            $message = "Newsletter sending completed. Successfully sent to {$successCount} subscribers.";
            if ($failCount > 0) {
                $message .= " Failed to send to {$failCount} subscribers.";
            }

            return redirect()->back()->with('success', $message);
            
        } catch (Exception $e) {
            Log::error('Bulk email sending failed: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()->back()
                ->with('error', 'Failed to send newsletter: ' . $e->getMessage())
                ->withInput();
        }
    }
} 