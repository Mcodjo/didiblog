@extends('admin.layout')
@section('title', 'Lecture du message')
@section('subtitle', 'Détails de la correspondance')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('admin.contacts.index') }}"
                class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-orange-600 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Retour aux messages
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Header -->
            <div class="p-8 border-b border-gray-100 bg-gray-50/30">
                <div class="flex items-start justify-between">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xl shadow-sm">
                            {{ substr($contact->nom, 0, 1) }}
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $contact->sujet }}</h1>
                            <div class="mt-1 flex items-center gap-2 text-sm text-gray-500">
                                <span class="font-medium text-gray-900">{{ $contact->nom }}</span>
                                <span>&lt;{{ $contact->email }}&gt;</span>
                                <span>•</span>
                                <span>{{ $contact->created_at->format('d/m/Y à H:i') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700 uppercase tracking-wide border border-gray-200">
                            {{ $contact->type }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-8">
                <div class="prose max-w-none text-gray-700 leading-relaxed whitespace-pre-wrap font-serif text-lg">
                    {{ $contact->message }}
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="bg-gray-50 px-8 py-6 flex items-center justify-between border-t border-gray-100">
                <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST"
                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?');">
                    @csrf @method('DELETE')
                    <button type="submit"
                        class="text-red-600 hover:text-red-700 text-sm font-medium flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-red-50 transition-colors">
                        <i class="fas fa-trash"></i> Supprimer
                    </button>
                </form>

                <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->sujet }}"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white rounded-xl shadow-lg shadow-orange-900/20 font-medium transition-all hover:scale-105">
                    <i class="fas fa-reply"></i>
                    Répondre par email
                </a>
            </div>
        </div>
    </div>
@endsection