<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicServiceController extends Controller
{
    public function show($service)
    {
        $services = [
            'adoption' => [
                'title' => 'Pet Adoption',
                'description' => 'Find your new best friend today. Browse through hundreds of lovable pets waiting for a forever home. Our adoption process is designed to be simple, transparent, and supportive, ensuring that both you and your new companion start your journey off on the right paw.',
                'features' => [
                    'Wide variety of breeds and ages',
                    'Health checks and vaccinations included',
                    'Supportive adoption counseling',
                    'Post-adoption resources'
                ],
                'image' => 'https://images.unsplash.com/photo-1450778869180-41d0601e046e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'cta' => 'Adopt Now',
                'cta_link' => auth()->check() ? route('pethome') : route('register'), // Redirect to pethome if logged in, else register
            ],
            'care' => [
                'title' => 'Pet Care Services',
                'description' => 'Ensure your pet stays happy and healthy with our network of verified care providers. From grooming and walking to training and veterinary services, we connect you with professionals who treat your pet like family.',
                'features' => [
                    'Verified and background-checked providers',
                    'Services for all pet types',
                    'Easy booking and scheduling',
                    'Competitive pricing'
                ],
                'image' => 'https://images.unsplash.com/photo-1516734212186-a967f81ad0d7?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'cta' => 'Find a Sitter',
                'cta_link' => auth()->check() ? route('pethome') : route('register'),
            ],
            'community' => [
                'title' => 'Pet Community',
                'description' => 'Join a vibrant community of pet lovers. Share stories, ask for advice, and connect with other pet owners in your area. Together, we can create a supportive environment for all pets and their people.',
                'features' => [
                    'Forums and discussion boards',
                    'Local pet meetups and events',
                    'Expert Q&A sessions',
                    'Photo contests and sharing'
                ],
                'image' => 'https://images.unsplash.com/photo-1534361960057-19889db9621e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'cta' => 'Join the Community',
                'cta_link' => auth()->check() ? route('pethome') : route('register'),
            ],
        ];

        if (!array_key_exists($service, $services)) {
            abort(404);
        }

        return view('services.show', ['service' => $services[$service]]);
    }
}
