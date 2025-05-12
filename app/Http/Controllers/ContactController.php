<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        // Founders information
        $founders = [
            [
                'name' => 'Wasif Ishmam',
                'role' => 'Lead Developer',
                'bio' => 'Experienced web developer with expertise in Laravel and modern web technologies.',
                'email' => 'wasif@example.com'
            ],
            [
                'name' => 'Shayonton Hasan',
                'role' => 'Backend Developer',
                'bio' => 'Specialized in database design and API development for robust applications.',
                'email' => 'shayonton@example.com'
            ],
            [
                'name' => 'Syed Izdian Siraji',
                'role' => 'Frontend Developer',
                'bio' => 'Passionate about creating beautiful and responsive user interfaces.',
                'email' => 'izdian@example.com'
            ],
            [
                'name' => 'Eftekhar Tanvir Efti',
                'role' => 'Full Stack Developer',
                'bio' => 'Versatile developer with expertise in both frontend and backend technologies.',
                'email' => 'efti@example.com'
            ]
        ];

        return view('contact.index', compact('founders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:complaint,suggestion,other'
        ]);

        // Here you would typically send an email or store the message
        // For now, we'll just log it
        \Log::info('Contact form submission', $request->all());

        return redirect()->route('contact.index')
            ->with('success', 'Thank you for your message. We will get back to you soon!');
    }
} 