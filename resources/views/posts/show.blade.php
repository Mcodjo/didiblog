@extends('layouts.app')

@section('title', $post->title . ' - Emploi Connect')

@section('content')
    <div class="bg-white">
        <!-- Header/Hero for Post -->
        <div class="relative py-16 bg-white overflow-hidden">
            <div class="hidden lg:block lg:absolute lg:inset-y-0 lg:h-full lg:w-full">
                <div class="relative h-full text-lg max-w-prose mx-auto" aria-hidden="true">
                    <svg class="absolute top-12 left-full transform translate-x-32" width="404" height="384" fill="none"
                        viewBox="0 0 404 384">
                        <defs>
                            <pattern id="74b3fd99-0a6f-4271-bef2-e80eeafdf357" x="0" y="0" width="20" height="20"
                                patternUnits="userSpaceOnUse">
                                <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
                            </pattern>
                        </defs>
                        <rect width="404" height="384" fill="url(#74b3fd99-0a6f-4271-bef2-e80eeafdf357)" />
                    </svg>
                </div>
            </div>

            <div class="relative px-4 sm:px-6 lg:px-8">
                <div class="text-lg max-w-prose mx-auto">
                    <h1>
                        <span class="block text-base text-center text-blue-600 font-semibold tracking-wide uppercase">
                            {{ $post->category->name ?? 'Article' }}
                        </span>
                        <span
                            class="mt-2 block text-3xl text-center leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                            {{ $post->title }}
                        </span>
                    </h1>
                    <div class="mt-8 flex justify-center space-x-2 text-sm text-gray-500">
                        <time
                            datetime="{{ $post->published_at }}">{{ $post->published_at ? $post->published_at->format('d M Y') : '' }}</time>
                        <span aria-hidden="true">&middot;</span>
                        <span>Coach Didi</span>
                    </div>
                    @if($post->image)
                        <figure class="mt-8">
                            <img class="w-full rounded-xl shadow-lg object-cover h-96" src="{{ $post->image }}"
                                alt="{{ $post->title }}">
                        </figure>
                    @endif
                </div>

                <div class="mt-8 prose prose-blue prose-lg text-gray-500 mx-auto">
                    {!! nl2br(e($post->content)) !!}
                </div>

                <div class="mt-12 border-t border-gray-200 pt-8 max-w-prose mx-auto">
                    <a href="{{ route('home') }}"
                        class="font-medium text-blue-600 hover:text-blue-500 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Retour aux articles
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection